<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daodien */

$this->title = 'Chỉnh sửa thông tin đạo diễn: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Đạo diễn', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="daodien-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
