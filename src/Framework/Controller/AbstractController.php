<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Controller;

use DI\Container;
use Lamahive\Hive\Framework\Logger\Logger;
use Lamahive\Hive\Framework\Module\ModuleLoader;
use Lamahive\Hive\Framework\Module\ModuleRegistry;
use Lamahive\Hive\Framework\View;
use Twig\Error\LoaderError;

abstract class AbstractController
{
    public const TEMPLATES_FOLDER_PATH_FROM_MODULE_CONTROLLER = '/../Template';

    /**
     * @throws LoaderError
     */
    public function __construct(protected View $view, protected ModuleLoader $moduleLoader)
    {
        __DIR__ . '/../load.php'

        $templatesFolderPath = $this->getTemplatesFolderPath();
        $templatesNamespace = $this->getTemplatesNamespace();

        $this->view->loadModuleTemplates($templatesFolderPath, $templatesNamespace);
    }

    public function getNamespaceTemplatePath(string $templatePath): string
    {
        return sprintf('@%s/%s', $this->getTemplatesNamespace(), $templatePath);
    }

    private function getTemplatesFolderPath(): ?string
    {
        if (!is_dir(self::TEMPLATES_FOLDER_PATH_FROM_MODULE_CONTROLLER)) {
            return null;
        }
    }
}
