<?php

use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;


return [
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/add~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete~' => [ArticlesController::class, 'delete'],
    '~^$~' => [MainController::class, 'main'],
];