<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
echo $this->render(
    'main-login',
    ['content' => $content]
);
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        //app\assets\AppAsset::register($this);
        app\assets\AdminAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $name = 'Project của Đạt';
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <?= $this->render(
                'header.php',
                ['directoryAsset' => $directoryAsset,'name' => $name]
            ) ?>

            <?= $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset,'name' => $name,]
            )
            ?>

            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>

        </div>

        <?php $this->endBody() ?>
        <script type="text/javascript">
            function readURL(input,id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#'+id+'')
                        .attr('src', e.target.result);                
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
