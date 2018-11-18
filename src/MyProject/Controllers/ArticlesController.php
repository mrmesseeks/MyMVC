<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2018
 * Time: 19:26
 */

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;
use MyProject\Exceptions\NotFoundExcrption;
use MyProject\Services\Functions;

class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundExcrption();
            return;
        }

        $articleAuthor = User::getById($article->getAuthorId());

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'author' => $articleAuthor
        ]);
    }


    public function add (): void
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();

       // Functions::vardump($article);
    }

    public function delete (int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundExcrption();
            return;
        }

        $article->delete();

    }
    public function edit (int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundExcrption();
            return;
        }

        $article->setName('Что то новенькое');
        $article->setText('Давным давно в даекой далекой галактике');

        $article->save();
    }
}