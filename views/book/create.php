<?php

$this->title = 'Add Book';
?>
<div class="page-header"><h1>Add Book</h1></div>
<?= $this->render('_form', ['model' => $model, 'authors' => $authors]) ?>
