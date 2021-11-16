<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/static/components/loader.css">
    <link href="/static/panel/login/index.css" rel="stylesheet">
</head>

<body>
    <div class="loader">
        <div class="loader__blocks">
            <div class="loader__block-1"></div>
            <div class="loader__block-2"></div>
            <div class="loader__block-3"></div>
        </div>
    </div>
    <div class="login">
        <? if (isset($errors) && count($errors)) : ?>
            <div class="login__errors">
                <? foreach ($errors as $error) : ?>
                    <div><?= $error ?></div>
                <? endforeach; ?>
            </div>
        <? endif; ?>
        <form class="login__form" method="POST">
            <div class="login__title">Авторизация</div>
            <input class="input login__input" type="email" name="email" value="<?= $email ?? '' ?>" placeholder="E-mail" required>
            <input class="input login__input" type="password" name="password" placeholder="Password" minlength="5" required>
            <button class="btn btn--secondary" type="submit" name="submit">Войти</button>
        </form>
    </div>
    <script defer="defer" src="/static/panel/login/index.js"></script>
</body>

</html>