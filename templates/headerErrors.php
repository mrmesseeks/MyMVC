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
            <a href="/MVC/www/index.php">Мой блог</a>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php

                echo '<a href ="/MVC/www/index.php/">Вернутся на главную</a>';
            ?>
        </td>
    </tr>
    <tr>
        <td>