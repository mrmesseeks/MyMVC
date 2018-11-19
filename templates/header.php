<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Мой блог' ?></title>
    <link rel="stylesheet" href="/../MVC/www/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
   <?php
            if (!empty($user)){
                echo 'Привет, ' . $user->getNickname() . ' | <a href ="/MVC/www/users/logout/"> Выйти</a>';
            }
            else
            {
                echo '<a href ="/MVC/www/users/login/"> Войти </a> | <a href ="/MVC/www/users/signup"> Зарегестрироватся </a>';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>