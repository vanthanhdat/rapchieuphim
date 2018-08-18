<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Theloai */

$this->title = 'Create Theloai';
$this->params['breadcrumbs'][] = ['label' => 'Theloais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theloai-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
