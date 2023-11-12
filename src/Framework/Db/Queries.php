<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Db;

use Exception;

class Queries
{
    public function __construct(protected readonly Db $db) {}

    public function db(): Db
    {
        return $this->db;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->db->queryThrow('START TRANSACTION');
    }

    /**
     * @throws Exception
     */
    public function commit(): void
    {
        $this->db->queryThrow('COMMIT');
    }

    /**
     * @throws Exception
     */
    public function rollback(): void
    {
        $this->db->queryThrow('ROLLBACK');
    }
}
