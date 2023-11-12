<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Controller;

interface ModuleControllerInterface
{
    public function getTemplatesFolderPath(): string;
    public function getTemplatesNamespace(): string;
}
