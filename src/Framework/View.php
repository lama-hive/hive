<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

readonly class View
{
    protected Twig $twig;

    /**
     * @throws LoaderError
     */
    public function __construct()
    {
        $this->twig = Twig::create(__DIR__ . '/../Template', ['cache' => __DIR__ . '/../../cache/twig']);
        $this->twig->addExtension(new DebugExtension());
    }

    /**
     * @throws LoaderError
     */
    public function loadModuleTemplates(string $templateFolderPath, string $templatesNamespace): void
    {
        /*** @var $loader FilesystemLoader */
        $loader = $this->twig->getLoader();
        $loader->addPath($templateFolderPath, $templatesNamespace);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        return $this->twig->render($response, $template, $data);
    }
}
