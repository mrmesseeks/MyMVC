<?php

use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\UsersController;


return [
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/add~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete~' => [ArticlesController::class, 'delete'],
    '~^users/signup$~' => [UsersController::class, 'signUp'],
    '~^users/login~' => [UsersController::class, 'login'],
    '~^users/logout~' => [UsersController::class, 'logout'],
    '~^$~' => [MainController::class, 'main'],
];