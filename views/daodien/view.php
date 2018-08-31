<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Đạo diễn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $urlImageDaoDien = Yii::getAlias('@web/uploads/image/daodien'); ?>
<section>
    <article>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="detail-img">
                    <img src="<?= $urlImageDaoDien.'/'. $model->image ?>">
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <h2 class="detail-title"><?= Html::encode($this->title) ?></h2>
                 <h4><span class="label label-primary"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> <?= $model->views ?></span></h4>
                <div class="detail-info">
                   <p><?= $model->description ?></p>
                   <p>Ngày sinh: <?= $model->birthdate  ?></p>
                   <p>Quốc tịch: <?= $model->quoctich  ?></p>
               </div>
           </div>
       </div>
   </article>
</section>

<section style="margin: 15px 0;">
    <?php
    $urlImagePhim = Yii::getAlias('@web/uploads/image/phim');  
    $phims = [];
    foreach ($listPhim as $key => $value) {
        $attributes = json_decode($value->attributes);
        $item = Html::a('<img src="'.$urlImagePhim.'/'.$attributes->image.'" style = "width:30px;height:30px;"/>&nbsp;&nbsp;'.$attributes->title.'', ['phim/view', 'id' => $value->id], ['class' => 'list-group-item']);
        array_push($phims,$item);
    }
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Tiểu sử',
                'content' => '<div class="content-text">
                '.$model->tieusu.'
                </div>',
                'active' => true,
            ],[
                'label' => 'Phim đã tham gia',
                'content' => '<div class="list-group">
                '.implode('',$phims).'
                </div>',
            ]
        ],
    ]); 
    ?>
</section>

<?= $this->render(
    '//layouts//relatedpost.php'
) ?>


