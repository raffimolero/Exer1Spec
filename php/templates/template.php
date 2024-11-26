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
    <div class="mainContainer">
        <div class="subContainer1">
            <div class="header">
                <h1>~ Tropixotics ~</h1>
            </div>
            <embed src="welcome">
        </div>
        <div class="subContainer2">
            <a href="<?= "$root/index.php" ?>">Home</a>
            <embed src="loginout">
            <a href="<?= "$root/register.php" ?>">Register</a>
        </div>

    </div>

    <?= $body ?>
    <?= $footer ?>

</body>

</html>