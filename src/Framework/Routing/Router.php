<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Routing;

use Generator;
use Lamahive\Hive\Framework\Module\ModuleRegistry;

class Router
{
    protected ModuleRegistry $moduleRegistry;
    private array $routes = [];

    public function __construct(ModuleRegistry $moduleRegistry)
    {
        $this->moduleRegistry = $moduleRegistry;
    }

    public function getRoutes(): Generator
    {
        if (empty($this->routes)) {
            foreach ($this->moduleRegistry->list as $module) {
                foreach ($module->getRoutes() as $route) {
                    $this->routes[] = $route;
                }
            }
        }

        foreach ($this->routes as $route) {
            yield $route;
        }
    }
}
