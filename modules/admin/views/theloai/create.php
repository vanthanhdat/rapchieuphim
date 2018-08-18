<?php

use yii\helpers\Html;

$this->title = 'Thêm thể loại';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách thể loại', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
