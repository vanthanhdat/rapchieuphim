<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'Danh sách phim'; 
$this->params['breadcrumbs'][] = $this->title;
$getStatus = json_decode($status);
$arr = new stdClass();
foreach ($getStatus as $key => $value) {
	$property = $value->key;
	$arr->$property = $value->value;
}
?>

<div class="container-fluid" ng-controller="demoPhimCtrl" ng-init = "status=<?= htmlspecialchars(json_encode($arr,JSON_UNESCAPED_UNICODE)) ?>">
	<div class="alert-message">
	</div>
	<br>
	<div class="lds-spinner" ng-show="dataLoading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
	<fieldset>
		<legend>
			<h4 class="text-uppercase">Danh sách phim: {{status[currentStatus]}}</h4>
			<?php foreach ($getStatus as $key => $value): ?>
				<button class="btn btn-<?= $value->css->button?>" ng-click="getPhims(<?= $value->key ?>)"><?= $value->value ?> <i class="fa <?= $value->css->icon ?>"></i></button>
			<?php endforeach ?>
			<!--<button class="btn btn-success" ng-click="getPhims(<?= $getStatus[2]->key ?>)"><?= $getStatus[2]->value ?> <i class="fa fa-toggle-on"></i></button>
			<button class="btn btn-primary" ng-click="getPhims(<?= $getStatus[1]->key ?>)"><?= $getStatus[1]->value ?> <i class="fa fa-toggle-off"></i></button>
			<button class="btn btn-warning" ng-click="getPhims(<?= $getStatus[0]->key ?>)"><?= $getStatus[0]->value ?> <i class="fa fa-ban"></i></button>-->
		</legend>
		<form class="form-inline">
			<div class="form-group">
				<label>Search:</label>
				<input type="text" name="search" ng-model="searchCity" ng-keyup="query()" class="form-control" placeholder="search" autocomplete="off">
			</div>
		</form>
		<table class="table table-striped table-bordered" ng-show="!dataLoading">
			<thead>
				<th><a href="">#</a></th>
				<th ng-click="sort('id')">
					<a href="">Id
						<span ng-if="sortType =='id' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'id' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('title')">
					<a href="" >Tựa phim
						<span ng-if="sortType == 'title' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'title' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('thoiLuong')">
					<a href="">Thời lượng
						<span ng-if="sortType == 'thoiLuong' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'thoiLuong' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('daodien.name')">
					<a href="">Đạo diễn
						<span ng-if="sortType == 'daodien.name' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'daodien.name' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('dienVien')">
					<a href="">Diễn viên
						<span ng-if="sortType == 'dienVien' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'dienVien' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('quocGia')">
					<a href="">Quốc gia
						<span ng-if="sortType == 'quocGia' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'quocGia' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('nhaSanXuat')">
					<a href="">Nhà sản xuất
						<span ng-if="sortType == 'nhaSanXuat' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'nhaSanXuat' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('id_tl')">
					<a href="">Thể loại
						<span ng-if="sortType == 'id_tl' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'id_tl' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th ng-click="sort('start')">
					<a href="">Ngày bắt đầu
						<span ng-if="sortType == 'start' && !sortReverse" class="fa fa-caret-down"></span>
						<span ng-if="sortType == 'start' && sortReverse" class="fa fa-caret-up"></span>
					</a>
				</th>
				<th>
					<a href="">Trạng thái
					</a>
				</th>
			</thead>
			<tbody>
				<tr ng-repeat="phim in phims[currentStatus] | orderBy:sortType:sortReverse">
					<td>{{$index+1}}</td>
					<td>{{phim.id}}</td>
					<td>{{phim.title}}</td>
					<td>{{phim.thoiLuong}}</td>
					<td ng-init = "daodien=phim.id_dd">{{daodien.name}}</td>
					<td>{{phim.dienVien}}</td>
					<td>{{phim.quocGia}}</td>
					<td>{{phim.nhaSanXuat}}</td>
					<td>{{phim.id_tl}}</td>
					<td>{{phim.start}}</td>
					<td>{{phim.status}}</td>
					<td>
						<button class="btn btn-primary" ng-click="edit(city)">Edit <i class="fa fa-edit"></i></button>
					</td>
					<td><button class="btn btn-danger" ng-click="delete(city)">Delete <i class="fa fa-trash" aria-hidden="true"></i></button></td>
				</tr>
			</tbody>
		</table>
		<?php /* LinkPager::widget([
			'pagination' => $pagination,
		])*/ ?> 
	</fieldset>
</div>
