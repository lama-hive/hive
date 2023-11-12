<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module\Factory;

use Lamahive\Hive\Framework\Db\Db;
use Lamahive\Hive\Framework\Factory\AbstractFactory;
use Lamahive\Hive\Framework\Module\ModuleMigration;

readonly class ModuleMigrationFactory extends AbstractFactory
{
    public function __construct(private Db $db){}

    public function create(string $migrationPathname): ModuleMigration
    {
        return new ModuleMigration($this->db, $migrationPathname);
    }
}
