<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= "$title - Tropixotics" ?></title>
    <link rel="stylesheet" href="<?= "$root/styles/style.css" ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
</head>

<body>
    <h1>~ Tropixotics ~</h1>
    <embed src="welcome">
    <?= view('links', ['links' => [
        ['Home', 'index.php'],
        isset($_COOKIE['name']) ? ['Log out', 'logout.php'] : ['Log in', 'login.php'],
        ['Register', 'register.php'],
    ]]) ?>
    <?= $body ?>
    <p>See you soon~</p>
</body>

</html>