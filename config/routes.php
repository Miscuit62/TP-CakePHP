<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/users/add', ['controller' => 'Users', 'action' => 'add']);
        $builder->connect('/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);
        $builder->connect('/users/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
        $builder->connect('/menus/update-order', ['controller' => 'Menus', 'action' => 'updateOrder']);
        $builder->connect('/sleep/weekly-summary', ['controller' => 'Sleep', 'action' => 'weeklySummary']);
        $builder->connect('/users/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);
        $builder->connect('/sleep/dashboard', ['controller' => 'Sleep', 'action' => 'dashboard']);
    
        $builder->connect('/pages/*', 'Pages::display');
        $builder->fallbacks();
    });
};
