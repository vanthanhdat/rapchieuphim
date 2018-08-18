<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách các rạp của hệ thống';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Thêm Rạp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?php foreach ($listRap as $rap): ?>
                <?php $attributes = json_decode($rap->attributes) ?>
                <div class="list-group">
                    <a href="<?= '/admin/rap/view/?id='.$rap->id.'' ?>" title="<?= $attributes->name ?>" class="list-group-item list-group-item-action list-group-item-info">
                        <?= Html::encode($attributes->name) ?>
                    </a>  
                </div>  
            <?php endforeach ?>
        </div>    
    </div>  
 <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>   
</div>
