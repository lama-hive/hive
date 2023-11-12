<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module;

use Lamahive\Hive\Framework\Db\Db;
use Lamahive\Hive\Framework\Db\DbQueries\MigrationDbQueries;

readonly class ModuleMigration
{

    public function __construct(private Db $db, MigrationDbQueries $migrationDbQueries, private string $migrationPathname){}

    public function migrate()
    {

    }
}
