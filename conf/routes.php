<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();
    $settings = $container->get('settings');

    // if ($settings['debug'] == true && $settings['tracy']['enableConsoleRoute'] == true) {
    //     $app->post('/console', 'RunTracy\Controllers\RunTracyConsole:index');
    // }

    $app->map(['GET', 'POST'], '/[{slug}]', 'App\Controller\HomeController:index')->setName('home');

    $app->group('/member', function (Group $group) {
        $group->map(['GET', 'POST'],'/login', 'App\Controller\AuthController:login')->setName('login');
        $group->get('/logout', 'App\Controller\AuthController:logout')->setName('logout');
        $group->map(['GET', 'POST'], '/raffle', 'App\Controller\RaffleController:index')->setName('raffle');
    });
};
