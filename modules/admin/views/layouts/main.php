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
            var firstSeatLabel = 1;
            $(document).ready(function() {
                var arr = new Array();
                var tickets = new Array();
                <?php foreach($GLOBALS['_sodo'] as $key => $val){ ?>
                    arr.push('<?php echo $val; ?>');
                <?php } ?>
                var $cart = $('#selected-seats'),
                $counter = $('#counter'),
                $total = $('#total'),
                sc = $('#seat-map').seatCharts({
                    map: arr,
                    /*
                    seats: {
                        e: {
                            price   : 40,
                            classes : 'economy-class', //your custom CSS class
                            category: 'Economy Class'
                        }                   
                    
                    },*/
                    naming : {
                        top : false,
                        getLabel : function (character, row, column) {
                            return firstSeatLabel++;
                        },
                    },
                    legend : {
                        node : $('#legend'),
                        items : [
                        [ 'a', 'available',   'Có thể chọn'],
                        ['a', 'unavailable', 'Đã bán'],
                        ]                   
                    },
                    click: function () {
                        if (this.status() == 'available') {

                            if (tickets.length < <?php echo $GLOBALS['_tickets']; ?>) {
                                $('<b>'+this.settings.label+'&nbsp;</b>')
                                .attr('id', 'cart-item-'+this.settings.id)
                                .data('seatId', this.settings.id)
                                .appendTo($cart);
                                tickets.push(this.settings.id);
                                //alert(tickets.length + ' ' + tickets);
                                return 'selected';
                            }else{
                                $('#cart-item-'+tickets[0]).remove();
                                sc.status(tickets[0],'available');
                                tickets.shift();
                                $('<b>'+this.settings.label+'&nbsp;</b>')
                                .attr('id', 'cart-item-'+this.settings.id)
                                .data('seatId', this.settings.id)
                                .appendTo($cart);
                                tickets.push(this.settings.id);
                               // alert(tickets.length + ' ' + tickets);
                               return 'selected';
                           } 
                       }
                       else if (this.status() == 'selected') {
                        tickets.splice(tickets.indexOf(this.settings.id),1);
                           // alert(tickets.length + ' ' + tickets);
                           $('#cart-item-'+this.settings.id).remove();
                            //seat has been vacated
                            return 'available';
                        } else if (this.status() == 'unavailable') {
                            //seat has been already booked
                            return 'unavailable';
                        } else {
                            return this.style();
                        }
                    }
                });

                //this will handle "[cancel]" link clicks
                $('#selected-seats').on('click', '.cancel-cart-item', function () {
                    //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
                    sc.get($(this).parents('li:first').data('seatId')).click();
                });

                //let's pretend some seats have already been booked
                var selectedSeats = [];
                <?php foreach($GLOBALS['_bookedSeats'] as $key => $val){ ?>
                    selectedSeats.push('<?php echo $val; ?>');
                <?php } ?>
                sc.get(selectedSeats).status('unavailable');

            });

function recalculateTotal(sc) {
    var total = 0;
    sc.find('selected').each(function () {
        total += this.data().price;
    });
    return total;
}

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
