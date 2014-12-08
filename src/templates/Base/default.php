<?php $title = isset($title) ? $title : 'Home' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Overlock:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?= $this->asset('css/main.css') ?>"/>
    <title>Globathon - <?= $title ?></title>
</head>
<body>
<div id="allwrap">
    <?= $this->section('content') ?>
</div>

<?php $this->insert('Base/javascript') ?>
</body>
</html>
