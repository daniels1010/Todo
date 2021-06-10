<?php
    // piesaista header failu kurā ir <head> tags ar visu informāciju, stiliem un parējiem resursiem, kurus izmanto teju visās lapās
    require APPROOT . '/views/includes/header.php';

?>
<div class="container">
    <div class="text-center">
        <h1 class="edit-title">Darāmo lietu saraksts</h1>
    </div>
    <div class="text-center">
        <h3>Pievienot jaunu</h3>
    </div>
    <div class="edit-form text-center">
        <!-- Forma, kurā prasa ievadīt virsrakstu un aprakstu. Tam līdzi padod CSRF atslēgu -->
        <form action="<?= URLROOT ?>/todo/create" method="POST">
            <input type="hidden" name="csrf" value="<?= $csrf ?>">
            <div> 
                <label for="title">Virsraksts</label>
                <br>
                <input class="title-field" type="text" name="title" required>
                <span class="invalidFeedback">
                    <?= $data['titleError']?>
                </span>
            </div>
            <div>
                <label for="description">Apraksts</label>
                <br>
                <textarea rows="3" class="description-field" type="text" name="description"></textarea>
                <span class="invalidFeedback">
                    <?= $data['descriptionError']?>
                </span>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <a class="btn btn-secondary custom-button" href="<?= URLROOT ?>/todo/index" role="button">Doties atpakaļ</a>
                </div>
                <div class="col-sm-6">
                    <button id="submit" type="submit" value="submit" class="btn btn-success custom-button">Pievienot jaunu</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>