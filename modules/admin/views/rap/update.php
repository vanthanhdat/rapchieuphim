<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rap */

$this->title = 'Update rạp: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'objGia' => $objGia,
        'listCity' => $listCity,
    ]) ?>

</div>
