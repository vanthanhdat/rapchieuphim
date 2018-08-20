<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = $model->cityname;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách thành phố', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-view container">
    <div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <h3>Mã thành phố: <?= Html::encode($model->id) ?></h3>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
        <p>
            <?= Html::a('Thêm Rạp', ['/admin/rap/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php if (count($model->raps) > 0 ): ?>
            <h3><label class="label label-success">Danh sách các rạp thuộc <?= $model->cityname ?></label></h4>
            <?php foreach ($model->raps as $key => $value): ?>
                <div class="list-group">
                        <?php $attributes = json_decode($value->attributes); ?>
                        <a href="<?= '/admin/rap/view/?id='.$value->id.'' ?>" title="<?= $attributes->name ?>" class="list-group-item list-group-item-action list-group-item-info">
                            <?= Html::encode($attributes->name) ?>
                        </a>  
                    </div>
            <?php endforeach ?>
            <?php else: ?>
                <h3>Thành phố này chưa tạo rạp!</h4>  
        <?php endif ?>
    </div>
</div>
