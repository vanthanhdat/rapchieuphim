<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách các thể loại', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-view container">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>Mã thể loại: <?= Html::encode($model->id) ?></h3>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Thêm phim', ['/admin/phim/create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
