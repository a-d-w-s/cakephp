<?php
/**
 * CakePHP : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP Project
 * @since         2.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setExtensions('json');
    $routes->scope('/', function (RouteBuilder $routes): void {
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $routes->connect(
            '/some_alias',
            [
                'controller' => 'tests_apps',
                'action' => 'some_method'],
            [
                '_name' => 'some_alias',
                'routeClass' => 'InflectedRoute',
            ],
        );
        $routes->fallbacks();
    });
};
