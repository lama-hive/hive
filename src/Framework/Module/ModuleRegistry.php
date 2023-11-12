<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module;

use Lamahive\Hive\Framework\Exception\ModuleLoadException;
use Lamahive\Hive\Framework\Filesystem\Directory;
use Lamahive\Hive\Framework\Module\Factory\ModuleFactory;
use function file_exists;

class ModuleRegistry
{
    /**
     * @var Module[]
     */
    public array $list;

    /**
     * @throws ModuleLoadException
     */
    public function __construct(readonly private ModuleFactory $moduleFactory)
    {
        $this->loadModules();
    }

    /**
     * @throws ModuleLoadException
     */
    private function loadModules(): void
    {
        foreach (Directory::getSubdirectories(__DIR__ . '/../../Modules') as $pathname) {
            $this->registerModule($pathname);
        }
    }

    /**
     * @throws ModuleLoadException
     * @throws \Exception
     */
    private function registerModule(string $pathname): void
    {
        $loadFilePath = $pathname . '/load.php';

        if (!file_exists($loadFilePath)) {
            throw new ModuleLoadException($loadFilePath, ' File does not exist.');
        }

        $moduleDir = require $loadFilePath;
        if (!($moduleDir instanceof ModuleDir)) {
            throw new ModuleLoadException($loadFilePath, ' Module load type.');
        }

        $module = $this->moduleFactory->create($moduleDir);

        $this->list[$module->moduleDir->path] = $module;
    }
}
