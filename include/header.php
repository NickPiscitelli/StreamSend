<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <?php if($page != 'results') { ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php } ?>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">
        <?php foreach ($css_files as $file) { ?>
            <link rel="stylesheet" type="text/css" href="css/<?php echo $file ?>.css">
        <?php } ?>
    </head>
    <body>
        <header>
            <div class="logo constrain">
                <img src="imgs/stream_send.png" alt="Stream Send Logo">
            </div>
        </header>
