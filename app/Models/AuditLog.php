<?php
namespace App\Models;

use App\Core\Database;

/**
 * AuditLog Model
 * Handles recording and querying audit/history trails.
 */
class AuditLog
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Record an audit log entry
     *
     * @param string $module Module name (e.g. Students, Staff, Users, Import, Auth)
     * @param string $action Action name (e.g. CREATE, UPDATE, DELETE, IMPORT, LOGIN, LOGOUT)
     * @param string $description Summary of activity
     * @param int|null $entityId Target record ID
     * @param string|null $entityName Target record descriptive name (e.g. Student name, staff name)
     * @param array|null $oldValues Array of previous values before change
     * @param array|null $newValues Array of new values after change
     * @return bool
     */
    public static function record(
        string $module,
        string $action,
        string $description,
        ?int $entityId = null,
        ?string $entityName = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): bool {
        try {
            $db = Database::getInstance();

            $userId   = $_SESSION['user_id'] ?? null;
            $userName = $_SESSION['user_name'] ?? ($_SESSION['username'] ?? 'System / Anonymous');

            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $ipAddress = trim($ips[0]);
            }

            $oldJson = $oldValues !== null ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null;
            $newJson = $newValues !== null ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null;

            $sql = 'INSERT INTO audit_logs 
                    (user_id, user_name, action, module, entity_id, entity_name, description, old_values, new_values, ip_address, created_at)
                    VALUES 
                    (:user_id, :user_name, :action, :module, :entity_id, :entity_name, :description, :old_values, :new_values, :ip_address, NOW())';

            $db->query($sql);
            $db->bind(':user_id', $userId);
            $db->bind(':user_name', $userName);
            $db->bind(':action', strtoupper($action));
            $db->bind(':module', $module);
            $db->bind(':entity_id', $entityId);
            $db->bind(':entity_name', $entityName);
            $db->bind(':description', $description);
            $db->bind(':old_values', $oldJson);
            $db->bind(':new_values', $newJson);
            $db->bind(':ip_address', $ipAddress);

            return $db->execute();
        } catch (\Throwable $e) {
            error_log('AuditLog recording failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Compute field-level differences between old and new state
     */
    public static function diff(array $old, array $new, array $ignoredKeys = ['updated_at', 'created_at', 'csrf_token']): array
    {
        $changes = [];
        $allKeys = array_unique(array_merge(array_keys($old), array_keys($new)));

        foreach ($allKeys as $key) {
            if (in_array($key, $ignoredKeys, true)) {
                continue;
            }

            $valOld = $old[$key] ?? null;
            $valNew = $new[$key] ?? null;

            // Treat null, empty string and numeric conversions cleanly
            if (is_numeric($valOld) && is_numeric($valNew) && (string)$valOld === (string)$valNew) {
                continue;
            }
            if ($valOld === '' && $valNew === null) {
                continue;
            }
            if ($valOld === null && $valNew === '') {
                continue;
            }

            if ($valOld !== $valNew) {
                $changes[$key] = [
                    'old' => $valOld,
                    'new' => $valNew,
                ];
            }
        }

        return $changes;
    }

    /**
     * Get single audit record by ID
     */
    public function getById(int $id): array|false
    {
        $this->db->query('SELECT * FROM audit_logs WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Build WHERE clause for filters
     */
    private function buildFilterConditions(array $filters): array
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $where[] = '(description LIKE :kw OR entity_name LIKE :kw OR user_name LIKE :kw)';
            $params[':kw'] = '%' . trim($filters['keyword']) . '%';
        }

        if (!empty($filters['module'])) {
            $where[] = 'module = :module';
            $params[':module'] = $filters['module'];
        }

        if (!empty($filters['action'])) {
            $where[] = 'action = :action';
            $params[':action'] = strtoupper($filters['action']);
        }

        if (!empty($filters['user_id'])) {
            $where[] = 'user_id = :user_id';
            $params[':user_id'] = (int)$filters['user_id'];
        }

        if (!empty($filters['date_from'])) {
            $where[] = 'DATE(created_at) >= :date_from';
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $where[] = 'DATE(created_at) <= :date_to';
            $params[':date_to'] = $filters['date_to'];
        }

        return [implode(' AND ', $where), $params];
    }

    /**
     * Get paginated logs matching filters
     */
    public function getFiltered(array $filters = [], int $limit = 25, int $offset = 0): array
    {
        [$whereSql, $params] = $this->buildFilterConditions($filters);

        $sql = "SELECT * FROM audit_logs WHERE {$whereSql} ORDER BY created_at DESC, id DESC LIMIT :limit OFFSET :offset";
        $this->db->query($sql);

        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        $this->db->bind(':limit', $limit, \PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    /**
     * Count total logs matching filters
     */
    public function countFiltered(array $filters = []): int
    {
        [$whereSql, $params] = $this->buildFilterConditions($filters);

        $sql = "SELECT COUNT(*) as total FROM audit_logs WHERE {$whereSql}";
        $this->db->query($sql);

        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        $row = $this->db->single();
        return (int)($row['total'] ?? 0);
    }

    /**
     * Get distinct modules for filter dropdown
     */
    public function getDistinctModules(): array
    {
        $this->db->query('SELECT DISTINCT module FROM audit_logs WHERE module IS NOT NULL AND module != "" ORDER BY module ASC');
        $rows = $this->db->resultSet();
        return array_column($rows, 'module');
    }

    /**
     * Get distinct actions for filter dropdown
     */
    public function getDistinctActions(): array
    {
        $this->db->query('SELECT DISTINCT action FROM audit_logs WHERE action IS NOT NULL AND action != "" ORDER BY action ASC');
        $rows = $this->db->resultSet();
        return array_column($rows, 'action');
    }

    /**
     * Get recent activity statistics
     */
    public function getStats(): array
    {
        $this->db->query('SELECT 
            COUNT(*) as total_logs,
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_logs,
            SUM(CASE WHEN action = "CREATE" THEN 1 ELSE 0 END) as total_creates,
            SUM(CASE WHEN action = "UPDATE" THEN 1 ELSE 0 END) as total_updates,
            SUM(CASE WHEN action = "DELETE" THEN 1 ELSE 0 END) as total_deletes
            FROM audit_logs');
        return $this->db->single() ?: [
            'total_logs' => 0,
            'today_logs' => 0,
            'total_creates' => 0,
            'total_updates' => 0,
            'total_deletes' => 0
        ];
    }
}
