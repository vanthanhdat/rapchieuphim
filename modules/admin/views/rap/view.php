<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rap */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ban có muốn xóa "'.$model->name.'" ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
       <div class="col-md-6">
               <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'address',
                'phone',
                'description',
                'city_id',
            ],
        ]) ?>
       </div>
       <div class="col-md-6">
            <h2>Danh sách các phòng</h2>
            <p>
                <?= Html::a('Thêm Phòng', ['create-phong','id' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?php foreach ($listPhong as $phong): ?>
                <div class="list-group">
                    <a href="<?= '/admin/rap/view-phong/?id='.$phong->id.'' ?>" title="<?= $phong->name ?>" class="list-group-item list-group-item-action list-group-item-info">
                        <?= Html::beginForm(['/admin/rap/delete-phong/?id='.$phong->id.''],
                         'post',
                        ['onsubmit' => 'return confirm("Bạn có muốn xóa phòng này,sau khi xóa mọi dữ liệu liên quan đến phòng này sẽ bị mất, lưu ý ?");']);?>
                        <?= Html::submitButton('x',['class' => 'close',])?>
                        <?= Html::endForm(); ?>
                        <?= Html::encode($phong->name) ?>
                    </a>  
                </div>  
            <?php endforeach ?>
        </div>
    </div>
</div>
