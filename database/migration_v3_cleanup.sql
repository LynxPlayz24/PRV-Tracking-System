-- ============================================================
-- PRVTS - Migration V3: Cleanup
-- Drop orphaned alert_resolutions table (L4 audit fix)
-- The resolve-alert feature was removed; this table has no
-- remaining queries or references anywhere in the codebase.
-- ============================================================

USE `prvts_db`;

DROP TABLE IF EXISTS `alert_resolutions`;
