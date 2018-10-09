<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<div class="container-fluid">
	<div class="alert-message">
	</div>
	<br>
	<div class="lds-spinner" ng-show="dataLoading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
	<fieldset>
		<legend>
			<h2>Danh sách phim</h2>
			<button class="btn btn-success" ng-click="edit(city)">ĐANG CHIẾU</button>
			<button class="btn btn-primary" ng-click="edit(city)">SẮP CHIẾU</button>
			<button class="btn btn-warning" ng-click="edit(city)">NGƯNG CHIẾU</button>
		</legend>
		<form class="form-inline">
			<div class="form-group">
				<label>Search:</label>
				<input type="text" name="search" ng-model="searchCity" ng-keyup="query()" class="form-control" placeholder="search" autocomplete="off">
			</div>
		</form>
		<table class="table table-striped table-bordered" ng-show="!dataLoading">
			<thead>
				<th>#</th>
				<th ng-click="sort('id')">
					<a href="">Id
						<span ng-if="sortType =='id' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'id' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('cityname')">
					<a href="" >Tựa phim
						<span ng-if="sortType == 'cityname' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'cityname' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th><a href="">Thời lượng</a></th>
				<th><a href="">Đạo diễn</a></th>
				<th><a href="">Diễn viên</a></th>
				<th><a href="">Quốc gia</a></th>
				<th><a href="">Nhà sản xuất</a></th>
				<th><a href="">Thể loại</a></th>
				<th><a href="">Ngày bắt đầu</a></th>
				<th><a href="">Hành động</a></th>
			</thead>
			<tbody>

			</tbody>
		</table>
		<?php /* LinkPager::widget([
			'pagination' => $pagination,
		])*/ ?> 
	</fieldset>
</div>
