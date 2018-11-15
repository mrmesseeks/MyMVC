<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Article extends ActiveRecordEntity
{

    protected  $name;
    protected  $text;
    protected  $authorId;
    protected  $createdAt;


    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName () :string
    {
        return $this->name;
    }
    public function getText () :string
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getAuthorId () :int
    {
        return (int) $this->authorId;
    }
    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }
    protected static function getTableName (): string
    {
        return 'articles';
    }


}