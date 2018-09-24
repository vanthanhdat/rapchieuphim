<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
$this->title = 'Danh sách các tỉnh thành'; 
$this->params['breadcrumbs'][] = $this->title;
echo $this->registerJsFile("@web/js/app.js");
echo $this->registerJsFile("@web/js/dirPagination.js");
?>


<div class="city-index container">
    <p>
        <?php // Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        <?php // Html::a('Demo download'.' '.'<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', ['download'], ['class' => 'btn btn-primary']) ?>
    </p>
    <div ng-app="demoApp" ng-controller="demoCtrl">
        <button class="btn btn-sm btn-warning" ng-if="dataLoading"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Vui lòng đợi...</button>

        <fieldset>
            <legend>Danh sách các tỉnh thành</legend>
            <form class="form-inline">
                <div class="form-group">
                    <label>Search:</label>
                    <input type="text" name="search" ng-model="search" class="form-control" placeholder="search">
                </div>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Tên thành phố</th>
                    <th>Hành động</th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td><input type="text" ng-model="data.cityname" placeholder="City name" class="form-control" required></td>
                        <td>
                            <button class="btn btn-success" ng-click="save()">Save</button>
                        </td>
                    </tr>
                    <tr ng-repeat="city in cities">
                        <td>{{$index+1}}</td>
                        <td>{{city.cityname}}</td>
                        <td>
                            <button class="btn btn-primary" ng-click="edit(city)">Edit</button>
                            <button class="btn btn-danger" ng-click="delete(city)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?> 

    </div>
    <!--<div ng-app="demoApp" ng-controller="demoCtrl">
        <fieldset>
            <legend>Dữ liệu các tỉnh thành</legend>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Tên thành phố</th>
                    <th>Hành động</th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td><input type="text" ng-model="data.cityname" placeholder="City name" class="form-control" required></td>
                        <td>
                            <button class="btn btn-success" ng-click="save()">Save</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?php Pjax::begin()  ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' =>$searchModel, 
            'columns' => [
                ['class' => 'yii\grid\SerialColumn','header'=>"Số thứ tự"],
                'id',
                'cityname',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Hành động',
                ],
            ],       
        ]); ?>
        <?php Pjax::end()  ?>
    </div>-->

</div>


