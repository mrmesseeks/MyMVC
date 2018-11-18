<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 16.11.2018
 * Time: 15:49
 */

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php',['error'=>$e->getMessage()]);
                return;
    }
    if ($user instanceof User){
                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
                             }
        }
        $this->view->renderHtml('users/signUp.php');
    }

    public function login ()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /MVC/www/index.php');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('users/login.php');
    }
}