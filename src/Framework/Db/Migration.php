<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Db;

use Exception;
use Lamahive\Hive\Framework\Db\DbQueries\MigrationDbQueries;
use Lamahive\Hive\Framework\Filesystem\FileReader;
use Lamahive\Hive\Framework\Module\ModuleRegistry;

// @todo details about what is happening during the migration
readonly class Migration
{
    public function __construct(private MigrationDbQueries $dbQueries, private FileReader $fileReader, private ModuleRegistry $moduleRegistry) {}

    /**
     * @throws Exception
     */
    public function migrate(): void
    {
        $this->setup();
        $this->process();
    }

    /**
     * @throws Exception
     */
    protected function setup(): void
    {
        $this->dbQueries->createMigrationTableIfNotExists();
    }

    /**
     * @throws Exception
     */
    protected function process(): void
    {
        foreach ($this->moduleRegistry->list as $module) {

        }
    }
}
