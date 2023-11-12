<?php

declare(strict_types=1);

namespace Lamahive\Hive\Modules\Empty\Setup;

use Lamahive\Hive\Framework\Controller\AbstractController;

class ModuleController extends AbstractController
{
    public const TEMPLATES_NAMESPACE = 'empty';

    public function getTemplatesFolderPath(): string
    {
        return __DIR__ . AbstractController::TEMPLATES_FOLDER_PATH_FROM_MODULE_CONTROLLER;
    }

    public function getTemplatesNamespace(): string
    {
        return static::TEMPLATES_NAMESPACE;
    }
}
