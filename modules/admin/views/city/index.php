<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
$this->title = 'Danh sách các tỉnh thành'; 
$this->params['breadcrumbs'][] = $this->title;
echo $this->registerJsFile("@web/js/app-city.js");
echo $this->registerJsFile("@web/js/dirPagination.js");
?>


<div class="city-index container">

    <?php // Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    <?php // Html::a('Demo download'.' '.'<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', ['download'], ['class' => 'btn btn-primary']) ?>
    <div ng-app="demoApp" ng-controller="demoCityCtrl">
        <div class="alert-message">
        </div>
        <button class="btn btn-sm btn-warning" ng-if="dataLoading"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Vui lòng đợi...</button>
        <fieldset>
            <legend><h2>Danh sách các tỉnh thành</h2></legend>
            <form class="form-inline">
                <div class="form-group">
                    <label>Search:</label>
                    <input type="text" name="search" ng-model="searchCity" class="form-control" placeholder="search" autocomplete="off">
                </div>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th ng-click="sort('id')">
                        <a href="">Id
                            <span ng-if="sortType =='id' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-if="sortType == 'id' && sortReverse" class="fa fa-caret-up"></span>
                        </a>
                    </th>
                    <th ng-click="sort('cityname')">
                        <a href="" >Tên thành phố 
                            <span ng-if="sortType == 'cityname' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-if="sortType == 'cityname' && sortReverse" class="fa fa-caret-up"></span>
                        </a>
                    </th>
                    <th><a href="">Hành động</a></th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <form name="cityForm" ng-submit="submitForm(cityForm.$valid)" class="form-inline">
                                <input type="text" ng-model="data.cityname" name="cityname" autocomplete="off" placeholder="City name" class="form-control" required>
                                <span ng-show="(cityForm.cityname.$invalid && cityForm.cityname.$touched)" class="input-error">Vui lòng điền tên thành phố !</span>
                                <button class="btn btn-success" type="submit">Save</button>
                            </form>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr ng-repeat="city in cities | orderBy:sortType:sortReverse | filter:searchCity">
                        <td>{{$index+1}}</td>
                        <td>{{city.id}}</td>
                        <td>{{city.cityname}}</td>
                        <td>
                            <button class="btn btn-primary" ng-click="edit(city)">Edit</button> |
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


