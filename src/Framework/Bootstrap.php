<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Lamahive\Hive\Framework\Exception\BootstrapException;
use Lamahive\Hive\Framework\Filesystem\Directory;
use Lamahive\Hive\Framework\Module\ModuleRegistry;
use Lamahive\Hive\Framework\Routing\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;

readonly class Bootstrap
{
    private App $app;

    /**
     * @param string $env
     * @throws BootstrapException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(string $env = 'prod'): void
    {
        try {
            if (!in_array($env, ['dev', 'prod'])) {
                throw new BootstrapException('Environment has to be set to one of ["dev", "prod"]');
            }

            // Build Container
            $container = $this->buildContainer($env);
            ObjectManager::setContainer($container);

            $this->app = Bridge::create($container);

            // Init Framework
            $framework = $container->get(Framework::class);
            $this->init($framework);

            // Load Routes
            $this->loadRoutes();

            if ($framework->debug) {
                $this->clearCache();
            }

            $this->app->run();
        } catch (Exception $e) {
            if ($env !== 'dev') {
                echo 'Application failed to load.';
            } else {
                throw $e;
            }
        }
    }

    private function clearCache(): void
    {
        Directory::removeDirectoryContent('/app/cache');
    }

    private function init(Framework $framework): void
    {
        if ($framework->debug) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function loadRoutes(): void
    {
        /*** @var $router Router */
        $router = $this->app->getContainer()->get(Router::class);

        foreach ($router->getRoutes() as $route) {
            // eg. $this->>app->get('/', \Lamahive\Hive\Modules\Empty\Controller\IndexController::class, 'index');
            $this->app->{$route->httpMethod}($route->pattern, [$route->controller, $route->method]);
        }
    }

    /**
     * @throws Exception
     */
    private function buildContainer(string $env): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../../config.php');
        $builder->addDefinitions(__DIR__ . '/../../config.' . $env . '.php');

        return $builder->build();
    }
}
