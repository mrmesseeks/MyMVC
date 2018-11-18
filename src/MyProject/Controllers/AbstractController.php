<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 18.11.2018
 * Time: 19:55
 */

namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;


class AbstractController
{
    protected $view;

    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
    }
}