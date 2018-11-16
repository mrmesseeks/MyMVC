<?php

use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\UsersController;


return [
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/add~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete~' => [ArticlesController::class, 'delete'],
    '~^users/register$~' => [UsersController::class, 'signUp'],
    '~^$~' => [MainController::class, 'main'],
];