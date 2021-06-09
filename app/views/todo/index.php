<?php
    require APPROOT . '/views/includes/header.php';
    $cardIds = array_map(function( $card) {
        return $card->card_id;
    }, $data['cards']);
?>

<div class="container">
    <div class="todo-title-box">
        <h1 class="todo-title">Darāmo lietu saraksts</h1>
    </div>
    <?php foreach($data['cards'] as $card) {?>
        <div class="card">
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" class="card-checkbox" value="<?= $card->card_id ?>" <?= $card->isChecked ? 'checked' : '' ?> >
                </div>
                <div class="col-md-10">
                    <h1 class="card-title"><?= $card->title ?></h1>
                </div>
                <div class="col-md-1">
                <a class="btn btn-warning card-edit" href="<?= URLROOT . "/todo/edit/". $card->card_id ?>"><i class="fas fa-pencil-alt fa-2x"></i></a>

                </div>

            </div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <p  class="card-description"><?= $card->description ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                </div>
                <div class="col-md-3">
                    <p  class="card-age"><?= $data['cardAge'][$card->card_id] ?></p>
                </div>
            </div>
            
        </div>
    <?php } ?>
    <div class="card-create-button-box">
        <a class="btn btn-warning card-create-button" href="<?= URLROOT ?>/todo/create" role="button">Pievienot jaunu</a>
    </div>

</div>
    <script>
        var rootUrl = '<?=URLROOT?>';
        var cardIds = [<?php echo implode(',', $cardIds) ?>];
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   <script src="<?= URLROOT ?>/public/javascript/javascript.js"></script>
</body>
</html>