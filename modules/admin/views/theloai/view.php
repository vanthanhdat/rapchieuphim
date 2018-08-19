<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục phim',]; 
$this->params['breadcrumbs'][] = ['label' => 'Danh sách các thể loại','url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-view container">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>Mã thể loại: <?= Html::encode($model->id) ?></h3>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Thêm phim', ['/admin/theloai/create-phim','id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-6">
            <h2>Danh sách các phim: <?php echo $model->name; ?></h2>
            <?php foreach ($model->phims as $key => $value): ?>
            	<?php $attributes = json_decode($value->attributes); ?>
            	 <div class="list-group">
                    <a href="<?= '/admin/theloai/view-phim/?id='.$value->id.'' ?>" title="<?= $attributes->title ?>" class="list-group-item list-group-item-action list-group-item-info">
                        <?= Html::beginForm(['/admin/theloai/delete-phim/?id='.$value->id.'&id_tl='.$model->id.''],
                         'post',
                        ['onsubmit' => 'return confirm("Bạn có muốn xóa phim này, sau khi xóa mọi dữ liệu liên quan đến bộ phim này sẽ bị mất, lưu ý ?");']);?>
                        <?= Html::submitButton('x',['class' => 'close',])?>
                        <?= Html::endForm(); ?>
                        <?= Html::encode($attributes->title) ?>
                    </a>  
                </div>    
            <?php endforeach ?>
    </div>
</div>
