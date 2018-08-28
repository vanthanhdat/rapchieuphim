<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DaodienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách đạo diễn';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php $urlImage = Yii::getAlias('@web/uploads/image/daodien'); ?>
<h3 class="text-uppercase"><?= $this->title ?></h3>
<?php foreach($listDaoDien as $value): ?>
    <article class="blog-post">
        <div class="col-md-4 col-xs-4"> 
            <?= Html::a(Html::img($urlImage.'/'. $value->image, [
                'alt' => Html::encode($value->name),
                'class' => 'img-responsive',
                'title' => Html::encode($value->name),
            ]), ['daodien/view', 'slug' => $value->slug,]) ?>
        </div>
        <div class="col-md-8 col-xs-8">
            <h4>
            <?= Html::a($value->name, ['daodien/view', 'slug' => $value->slug,]) ?>
        </h4>
        <div class="article-description hidden-xs">
            <div class="article-introtext">
              <?= $value->getPreview();?>
          </div>   
      </div>
  </div>
</article>
<?php endforeach ?>  
<?= LinkPager::widget([
    'pagination' => $pagination,
    ]) ?>