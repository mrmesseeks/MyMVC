<?php
 include __DIR__ . '/../header.php'; ?>
<h1>Напишите свою статью!</h1>
<?php if (!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
<form action="/MVC/www//articles/add" method="post">
    <label for="name">Название статьи</label><br>
    <input type="text" name="title" id="title"
           value="<?= $_POST['title'] ?? '' ?>" size="50">
    <br><br>
    <label for="title">Текст статьи</label><br>
    <textarea name="text" id="text" rows="10" cols="80">
        <?= $_POST['text'] ?? '' ?>
    </textarea>
    <br><br>
    <input type="submit" value="Опубликовать">
</form>

