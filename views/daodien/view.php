<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Đạo diễn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daodien-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Bạn có muốn xóa "'.$model->name.'" ?',
                    'method' => 'post',
                ],
        ]);
     ?>
    </p>

    <?php $urlImage = Yii::getAlias('@web/uploads/image/daodien'); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'image',
                'value'=>$urlImage.'/'. $model->image,
                'format' => ['image',['class' => 'img-thumbnail img-responsive','alt' => $model->name]],
            ],
            'name',
            'description',
            'birthdate',
            'tieusu',
            'quoctich',
        ],
    ]) ?>

</div>
