<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Raps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rap-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rap', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'attributes:ntext',
            'giave:ntext',
            'idcity',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
