<?php
use MyProject\Models\Users\User;
use MyProject\Models\Articles\Article;
use MyProject\Controllers\MainController;
try {
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . $className . '.php';
    });

//$controller = new MainController();

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundExcrption();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
}
catch (\MyProject\Exceptions\DbException $e){
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
}

catch (\MyProject\Exceptions\NotFoundExcrption $e){
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php',['error' => $e->getMessage()],404);
}