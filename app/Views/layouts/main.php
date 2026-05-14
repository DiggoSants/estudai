<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? APP_NAME); ?> | <?= e(APP_NAME); ?></title>
    <link rel="stylesheet" href="<?= asset('css/app.css'); ?>">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="<?= url(); ?>">Estudai</a>
        <nav class="nav">
            <a href="<?= url(); ?>">Início</a>
        </nav>
    </header>

    <main class="page">
        <?= $content; ?>
    </main>

    <script src="<?= asset('js/app.js'); ?>"></script>
</body>
</html>
