<?php
    // piesaista header failu kurā ir <head> tags ar visu informāciju, stiliem un parējiem resursiem, kurus izmanto teju visās lapās
    require APPROOT . '/views/includes/header.php';

    // Izveido CSRF atslēgu
    if(!isset($_SESSION)) {
        session_start();
    }
    if (empty($_SESSION['key'])) {
        $_SESSION['key'] = bin2hex(random_bytes(32));
    }

    $csrf = $_SESSION['key'];
?>

<div class="container">
    <div class="text-center">
        <h1 class="edit-title">Darāmo lietu saraksts</h1>
    </div>
    <div class="text-center">
        <h3>Labot</h3>
    </div> 
    <div class="edit-form text-center">
        <!-- Forma, kur piedāvā izmainīt virsrakstu un aprakstu. Tam līdzi padod CSRF atslēgu -->
        <form action="<?= URLROOT . "/todo/edit/". $data['post']->card_id ?>" method="POST">
            <input type="hidden" name="csrf" value="<?= $csrf ?>">
            <div>  
                <label for="title">Virsraksts</label>
                <br>
                <input class="title-field" type="text" value="<?= $data['post']->title ?>" name="title">
                <span class="invalidFeedback">
                    <?= $data['titleError']?>
                </span>
            </div>  
            <div>
                <label for="description">Apraksts</label>
                <br>
                <textarea rows="3" class="description-field" type="text" name="description"><?= $data['post']->description ?></textarea>
                <span class="invalidFeedback">
                    <?= $data['descriptionError']?>
                </span>
            </div>
            <div class="row">
            <div class="col-sm-4">
                <a class="btn btn-secondary custom-button" href="<?= URLROOT ?>/todo/index" role="button">Doties atpakaļ</a>
            </div>
            <div class="col-sm-4">
                <button id="submit" type="submit" value="submit" class="btn btn-warning custom-button">Saglabāt izmaiņas</button>
            </div>
        </form>
        <div class="col-sm-4">
            <form action="<?= URLROOT . "/todo/delete/". $data['post']->card_id ?>" method="POST">
                <input type="submit" value="Izdzēst" class="btn btn-danger custom-button">
            </form>        
        </div>
    </div>
</div>
</body>
</html>