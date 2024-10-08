<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * TestsController
 */
namespace TestPlugin\Controller;

use Cake\Http\Response;

class TestsController extends TestPluginAppController
{
    public function index(): void
    {
        $this->set('test_value', 'It is a variable');
    }

    /**
     * @return \Cake\Http\Response
     */
    public function some_method(): Response
    {
        $this->response->body(25);

        return $this->response;
    }
}
