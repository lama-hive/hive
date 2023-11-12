<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Controller;

use DI\Container;
use Lamahive\Hive\Framework\Logger\Logger;
use Lamahive\Hive\Framework\View;
use Twig\Error\LoaderError;

abstract class AbstractController implements ModuleControllerInterface
{
    public const TEMPLATES_FOLDER_PATH_FROM_MODULE_CONTROLLER = '/../Template';

    /**
     * @throws LoaderError
     */
    public function __construct(protected Container $container, protected View $view, protected Logger $logger)
    {
        $this->view->loadModuleTemplates($this->getTemplatesFolderPath(), $this->getTemplatesNamespace());
    }

    public function getNamespaceTemplatePath(string $templatePath): string
    {
        return sprintf('@%s/%s', $this->getTemplatesNamespace(), $templatePath);
    }
}
