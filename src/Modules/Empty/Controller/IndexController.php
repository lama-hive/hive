<?php

declare(strict_types=1);

namespace Lamahive\Hive\Modules\Empty\Controller;

use Exception;
use Lamahive\Hive\Framework\Controller\AbstractController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends AbstractController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->view->render($response, $this->getNamespaceTemplatePath('index.twig'));
    }
}
