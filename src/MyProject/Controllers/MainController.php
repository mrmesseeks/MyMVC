<?php

namespace MyProject\Controllers;

use function MyProject\Services\vardump;
use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Services\Functions;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php',['articles' => $articles]);
    }
}