<?php

    // Izveido CSRF atslēgu
    if(!isset($_SESSION)) {
        session_start();
    }
    if (empty($_SESSION['key'])) {
        $_SESSION['key'] = bin2hex(random_bytes(32));
    }

    $csrf = $_SESSION['key'];
    
?>

<html lang="en">
    <head>
        <!-- Header fails, kurš satur vispārējos datus un visus izmantotos stylesheet-us, scripti tiek linkoti tikai noteiktajos failos-->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= SITENAME; ?></title>        
        <script src="https://kit.fontawesome.com/bd7041d089.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?= URLROOT ?>/public/css/style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    </head>
    <body>