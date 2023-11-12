<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module;

use Lamahive\Hive\Framework\Filesystem\Directory;
use Lamahive\Hive\Framework\Module\Factory\ModuleMigrationFactory;
use Lamahive\Hive\Framework\Routing\Route;
use function sort;
use function file_exists;

class Module
{
    /**
     * @var ModuleMigration[]
     */
    private array $migrations;
    /**
     * @var Route[]
     */
    private array $routes;

    public function __construct(
        readonly public ModuleDir $moduleDir,
        readonly private ModuleMigrationFactory $moduleMigrationFactory
    ){}

    /**
     * @return ModuleMigration[]
     */
    public function getMigrations(): array
    {
        return $this->migrations ?? $this->loadMigrations();
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes ?? $this->loadRoutes();
    }

    /**
     * @return Route[]
     */
    private function loadRoutes(): array
    {
        $this->routes = [];

        if (file_exists($this->moduleDir->path . '/Setup/routes.php')) {
            $this->routes = require $this->moduleDir->path . '/Setup/routes.php';
        }

        return $this->routes;
    }

    /**
     * @return ModuleMigration[]
     */
    private function loadMigrations(): array
    {
        $migrations = [];

        foreach (Directory::getFilesByExtension($this->moduleDir->path . '/Setup/Db', 'sql') as $migrationFilePathname) {
            $migrations[$migrationFilePathname] = $this->moduleMigrationFactory->create($migrationFilePathname);
        }

        sort($migrations);

        $this->migrations = $migrations;

        return $migrations;
    }
}
