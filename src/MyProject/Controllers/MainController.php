<?php

namespace MyProject\Controllers;

use MyProject\Services\UsersAuthService;
use function MyProject\Services\vardump;
use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Services\Functions;

class MainController extends AbstractController
{

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
        ]);
    }
}