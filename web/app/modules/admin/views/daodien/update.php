<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daodien */

$this->title = 'Update Daodien: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daodiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="daodien-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
