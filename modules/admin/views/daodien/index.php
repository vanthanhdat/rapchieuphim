<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DaodienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách đạo diễn';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Thêm đạo diễn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $urlImage = Yii::getAlias('@web/uploads/image/daodien'); ?>
     <?php foreach($listDaoDien as $value): ?>
        <article class="row blog-post">
                <div class="col-md-3">
                    <a href='/admin/daodien/view/?id=<?= $value->id ?>'>
                        <?= Html::img($urlImage.'/'. $value->image, [
                            'alt' => Html::encode($value->name),
                            'class' => 'img-rounded img-responsive img-thumbnail',
                            'title' => Html::encode($value->name),
                            'width' => '100%'])
                        ?>
                        <span class="hover-zoom"></span>
                    </a>
                </div>
                <div class="col-md-9">
                    <h2>
                        <a href="<?= '/admin/daodien/view/?id='.$value->id.'' ?>" title="<?= Html::encode($value->name) ?>">
                            <?= Html::encode($value->name) ?>
                        </a>
                    </h2>
                    
                    <div class="post-meta">    
                        <div class="meta-info meta-info-created">
                            <?php $timezone  = +7; ?>
                            <b>Đã thêm:</b> <?= gmdate('d-m-Y H:i:s',$value->created_at + 3600*($timezone)) .'.'  ?> <br>
                            <b>Cập nhật lúc:</b> <?= gmdate('d-m-Y H:i:s',$value->updated_at + 3600*($timezone)) .'.'  ?>
                        </div>
                        <!--
                        <div class="meta-info meta-info-created">
                            <b>Ngày sinh <i class="glyphicon glyphicon-calendar"></i> :</b> <?= $value->birthdate  ?>
                        </div> -->         
                    </div>
                    <!--
                    <div class="article-description">
                        <div class="article-introtext">
                           <b>Sơ lược:</b>
                        </div>
                        <div class="article-fulltext">
                            <?= $value->description ?>
                        </div>
                    </div>
                    <div class="article-description">
                        <div class="article-introtext">
                           <b>Tiểu sử:</b>
                        </div>
                        <div class="article-fulltext">
                            <?= $value->tieusu ?>
                        </div>
                    </div>
                    -->
                </div>
        </article>
        <br>
     <?php endforeach ?>
        
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
</div>