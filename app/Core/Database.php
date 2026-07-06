<?php
namespace App\Core;

/**
 * Database Class - PDO Singleton
 * Provides prepared statement helpers for secure database queries.
 */
class Database
{
    private static ?Database $instance = null;
    private \PDO $pdo;
    private ?\PDOStatement $stmt = null;

    private function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset']
        );

        try {
            $this->pdo = new \PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the raw PDO instance
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * Prepare a query
     */
    public function query(string $sql): self
    {
        $this->stmt = $this->pdo->prepare($sql);
        return $this;
    }

    /**
     * Bind a value to a parameter
     */
    public function bind(string $param, mixed $value, ?int $type = null): self
    {
        if ($type === null) {
            $type = match (true) {
                is_int($value)  => \PDO::PARAM_INT,
                is_bool($value) => \PDO::PARAM_BOOL,
                is_null($value) => \PDO::PARAM_NULL,
                default         => \PDO::PARAM_STR,
            };
        }
        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Execute the prepared statement
     */
    public function execute(array $params = []): bool
    {
        if (!empty($params)) {
            return $this->stmt->execute($params);
        }
        return $this->stmt->execute();
    }

    /**
     * Fetch all results as associative array
     */
    public function resultSet(array $params = []): array
    {
        $this->execute($params);
        return $this->stmt->fetchAll();
    }

    /**
     * Fetch single row
     */
    public function single(array $params = []): array|false
    {
        $this->execute($params);
        return $this->stmt->fetch();
    }

    /**
     * Get row count from last statement
     */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    // Prevent cloning
    private function __clone() {}
}
