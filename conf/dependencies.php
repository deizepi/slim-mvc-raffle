<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;
use Twig\TwigFilter;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'logger' => function (ContainerInterface $container) {
            $settings = $container->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        'session' => function (ContainerInterface $container) {
            return new \App\Middleware\SessionMiddleware;
        },
        'flash' => function (ContainerInterface $container) {
            $session = $container->get('session');
            return new \Slim\Flash\Messages($session);
        },
        'twig_profile' => function () {
            return new \Twig\Profiler\Profile();
        },
        'view' => function (ContainerInterface $container) {
            $settings = $container->get('settings');
            $view = Twig::create($settings['view']['template_path'], $settings['view']['twig']);
            $view->getEnvironment()->addFilter(new TwigFilter('phone', function ($string) {
                return preg_replace("/([0-9]{2})(?(?=[0-9]{9})([0-9]{5})([0-9]{4})|(([0-9]{4})([0-9]{4})))/", "($1) $2-$3", $string);
            }));
            return $view;
        },
    ]);
};
