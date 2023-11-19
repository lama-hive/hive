<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module;

class ModuleLoader
{
    public function __construct(private readonly ModuleRegistry $moduleRegistry){}

    public function getModuleWithLoad(ModuleDir $moduleDir): ?Module
    {
        return $this->moduleRegistry->list[$moduleDir->path] ?? null;
    }
}
