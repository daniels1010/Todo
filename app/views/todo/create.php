<?php
    require APPROOT . '/views/includes/header.php';
?>

<div class="container">

    <h1>Darāmo lietu saraksts</h1>
    <h3>Pievienot jaunu</h3>
    <form action="<?= URLROOT ?>/todo/create" method="POST">
        <input type="text" placeholder="Virsraksts" name="title">
        <span class="invalidFeedback">
            <?= $data['titleError']?>
        </span>
        <input type="text" placeholder="Apraksts" name="description">
        <span class="invalidFeedback">
            <?= $data['descriptionError']?>
        </span>
        <a class="btn btn-secondary" href="<?= URLROOT ?>/todo/index" role="button">Doties atpakaļ</a>
        <button id="submit" type="submit" value="submit" class="btn btn-success">Pievienot jaunu</button>
    </form>
    



</div>
</body>
</html>