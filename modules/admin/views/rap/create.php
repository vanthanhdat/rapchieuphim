<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rap */

$this->title = 'Tạo mới rạp';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'objGia' => $objGia,
        'listCity' => $listCity,
    ]) ?>

</div>
