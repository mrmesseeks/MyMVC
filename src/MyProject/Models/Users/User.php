<?php

namespace MyProject\Models\Users;



use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\Functions;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $isConfirmed;
    protected $role;
    protected $passwordHash;
    protected $authToken;
    protected $createdAt;


    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
    public function getAuthToken (): string
    {
        return $this->authToken;
    }
    public function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
    public static function signUp(array $userData) : User
    {
        if (empty($userData['nickname'])){
            throw new InvalidArgumentException('Не заполнен Nickname');
        }
        if (!preg_match('/[a-zA-Z0-9]+/', $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }
        if (empty($userData['email'])){
            throw new InvalidArgumentException('Не заполнен email');
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }
        if (empty($userData['password'])){
            throw new InvalidArgumentException('Не заполнен Password');
        }
        if (strlen($userData['password']) < 8 || strlen($userData['password']) > 20) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов и не более 20');
        }
        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }
        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user -> nickname = $userData['nickname'];
        $user -> email = $userData['email'];
        $user -> passwordHash = password_hash($userData['password'],PASSWORD_DEFAULT);
        $user -> isConfirmed = true;
        $user -> role = 'user';
        $user -> authToken = sha1(random_bytes(100)).sha1(random_bytes(100));
        $user -> save();

        return $user;
    }

    public static function login (array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

}
