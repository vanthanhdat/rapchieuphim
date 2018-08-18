<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Theloai */

$this->title = 'Update Theloai: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Theloais', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="theloai-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
