<?php
    require APPROOT . '/views/includes/header.php';
?>

<div class="container">

    <h1>Darāmo lietu saraksts</h1>
    <h3>Labot</h3>
   
    <form action="<?= URLROOT . "/todo/edit/". $data['post']->card_id ?>" method="POST">
        <input type="text" value="<?= $data['post']->title ?>" name="title">
        <span class="invalidFeedback">
            <?= $data['titleError']?>
        </span>
        <input type="text" value="<?= $data['post']->description ?>" name="description">
        <span class="invalidFeedback">
            <?= $data['descriptionError']?>
        </span>

        <a class="btn btn-secondary" href="<?= URLROOT ?>/todo/index" role="button">Doties atpakaļ</a>
        <button id="submit" type="submit" value="submit" class="btn btn-success">Saglabāt izmaiņas</button>
    </form>
    <form action="<?= URLROOT . "/todo/delete/". $data['post']->card_id ?>" method="POST">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
    
</div>
</body>
</html>