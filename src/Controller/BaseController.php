<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    protected $view;
    protected $logger;
    protected $flash;
    protected $db;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');
        $this->logger = $container->get('logger');
        $this->flash = $container->get('flash');
        $this->db = $container->get('db');
    }

    protected function render(Request $request, Response $response, string $template, array $params = []): Response
    {
        $params['flash'] = $this->flash;
        $params['uinfo'] = $request->getAttribute('uinfo');

        return $this->view->render($response, $template, $params);
    }
}
