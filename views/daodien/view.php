<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
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
       // var_dump($value->attributes);
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

<!--<section id="relatedpost">
    <a href="#" style="color: #43464b;" class="text-uppercase"><h3>Bài viết liên quan</h3></a>
    <div class="related">
        <ul class="related-post">
            <?php foreach ($relatedPost as $key => $value): ?>
                <?php $attributes = json_decode($value->attributes) ?>
                <div class="col-md-3 col-sm-6 col-xs-6">
                       <?= Html::a(Html::img($urlImageDaoDien.'/'. $attributes->image, [
                        'alt' => Html::encode($attributes->name),
                        'class' => 'img-responsive',
                        'title' => Html::encode($attributes->name),
                    ]), ['daodien/view', 'id' => $value->id,]) ?>
                </div>
        <?php endforeach ?>
    </ul>
</div>
</section> -->

