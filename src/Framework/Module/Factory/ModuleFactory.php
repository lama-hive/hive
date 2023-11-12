<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Module\Factory;

use Exception;
use Lamahive\Hive\Framework\Factory\AbstractFactory;
use Lamahive\Hive\Framework\Module\Module;
use Lamahive\Hive\Framework\Module\ModuleDir;

readonly class ModuleFactory extends AbstractFactory
{
    /**
     * @throws Exception
     */
    public function create(ModuleDir $moduleDir): Module
    {
        return $this->make(Module::class, ['moduleDir' => $moduleDir]);
    }
}
