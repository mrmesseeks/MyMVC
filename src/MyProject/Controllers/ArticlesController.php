<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2018
 * Time: 19:26
 */

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundExcrption;
use MyProject\Exceptions\UnauthorizedException;
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
            'author' => $articleAuthor,
        ]);
    }


    public function add (): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if ($this->user->isAdmin() !== 'admin'){
            throw new Forbidden('Вы не обладаете правами писать статьи');
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }
          //  Functions::vardump($this->user);
          //  header('Location: /MVC/www/index.php' , true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
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