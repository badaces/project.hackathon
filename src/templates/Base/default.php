<?php $title = isset($title) ? $title : 'Home' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <link rel="stylesheet" href="<?= $this->asset('css/main.css') ?>"/>

    <title>Globathon - <?= $title ?></title>
</head>
<body>
<div class="container">
    <?= $this->section('content') ?>
</div>

<?php $this->insert('Base/javascript') ?>
</body>
</html>
