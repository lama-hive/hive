<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Db\DbQueries;

use Exception;
use Lamahive\Hive\Framework\Db\Queries;

class MigrationDbQueries extends Queries
{
    public const TABLE = 'migration';

    /**
     * @throws Exception
     */
    public function createMigrationTableIfNotExists(): void
    {
        if ($this->db->tableExists(static::TABLE)) {
            return;
        }

        $this->db->createTable(static::TABLE, [
            '`entry_id` tinyint unsigned NOT NULL PRIMARY KEY'
        ]);
    }
}
