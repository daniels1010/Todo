<?php
    // piesaista header failu kurā ir <head> tags ar visu informāciju, stiliem un parējiem resursiem, kurus izmanto teju visās lapās
    require APPROOT . '/views/includes/header.php';
?>

<div class="container">
    <div class="text-center">
        <h1 class="todo-title">Darāmo lietu saraksts</h1>
    </div>
    <!-- Izdrukā katru kartiņu, ar tās attiecīgajiem datiem-->
    <?php foreach($data['cards'] as $card) {?>
        <div class="card">
            <div class="row">
                <div class="col-lg-1 col-md-1 col-2">
                    <input type="checkbox" class="card-checkbox" value="<?= $card->card_id ?>" <?= $card->isChecked ? 'checked' : '' ?> >
                </div>
                <div class="col-lg-10 col-md-9 col-10">
                    <h1 class="card-title"><?= $card->title ?></h1>
                </div>
                <div class="col-lg-1 col-md-2 col-2">
                    <a class="btn btn-warning card-edit" href="<?= URLROOT . "/todo/edit/". $card->card_id ?>"><i class="fas fa-pencil-alt fa-2x"></i></a>
                </div>
                <div class="col-md-11 offset-md-1 col-10">
                    <p  class="card-description"><?= $card->description ?></p>
                </div>
                <div class="col-sm-3 offset-9 ">
                    <p  class="card-age"><?= $data['cardAge'][$card->card_id] ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="text-center col-md-6 offset-md-3">
        <a class="btn btn-warning card-create-button" href="<?= URLROOT ?>/todo/create" role="button">
        Pievienot jaunu
    </a>
    </div>
</div>
<script>
    // Padod .js pamata direktoriju
    var rootUrl = '<?=URLROOT?>';
</script>
    <!-- importē axios.js, lai veidotu asinhronus pieprasījumus (šajā gadijumā čekbokšus, kurus ieķeksējot nepārlādējas visa lapa) -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="<?= URLROOT ?>/public/javascript/javascript.js"></script>
</body>
</html>