var app = angular.module("demoApp", []);

app.controller("demoCityCtrl", function($scope,$http,$location,$timeout) {

	$scope.submitForm = function(formValid){
		if(formValid) {
			$scope.save();	
		}
	};

	$scope.dataLoading = true;

	$scope.status = "create";
	$scope.data = {};

	$scope.sortReverse  = false;
	$scope.searchCity = '';

	$scope.sort = function(key) {
		$scope.sortType = key;
		$scope.sortReverse = !$scope.sortReverse;
	}

	$scope.save = function(){
		switch($scope.status){
			case "create":
			$scope.create();
			break;

			case "update":
			$scope.update();
			break;
		}
	};

	$scope.create = function(){
		$http.post('test-create',
		{
			data : $scope.data
		}
		).then(function(response) {
			$scope.clearDataInput();          
			$("div.alert-message").fadeIn(300).html("<div class='alert-success alert fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Thêm thành công !</div>");
			$timeout(function () {
				$("div.alert-message").fadeOut(1000,function() {
					$("div.alert-message").html('');
				});
			}, 3000);
			$scope.dataLoading = true;
			$scope.getCites();
		},function(response) {
			alert('fail');
		});
	};


	$scope.update = function(){
		$http.post('test-update',
		{
			data : $scope.data
		}
		).then(function(response) {
			$scope.clearDataInput();
			$("div.alert-message").fadeIn(300).html("<div class='alert-success alert fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Cập nhật thành công !</div>");
			$timeout(function () {
				$("div.alert-message").fadeOut(1000,function() {
					$("div.alert-message").html('');
				});
			}, 3000);
			$scope.status = "create";
			$scope.dataLoading = true;
			$scope.getCites();          
		},function(response) {
			alert('fail');
		});
	};

	$scope.edit = function(city){
		$scope.data = city;
		$scope.status = "update";
	};


	$scope.delete = function(city){
		if (confirm("Bạn có muốn xóa thành phố này!")) {
			$http.post('test-delete',
			{
				data : city
			}
			).then(function(response) {
				$scope.clearDataInput();
				$("div.alert-message").fadeIn(300).html("<div class='alert-success alert fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Xóa thành công !</div>");
				$timeout(function () {
					$("div.alert-message").fadeOut(1000,function() {
						$("div.alert-message").html('');
					});
				}, 3000);
				$scope.status = "create";
				$scope.dataLoading = true;
				$scope.getCites();          
			},function(response) {
				alert('fail');
			});
		}
	};

	$scope.clearDataInput = function(){
		$scope.data = {
			cityname:""
		};
	};

	$scope.query = function() {
		var page = $location.absUrl().split('page=')[1];
		$scope.dataLoading = true;
		$scope.clearDataInput(); 
		$http.post('query-city',
		{
			params : { queryParam:$scope.searchCity,page: typeof(page) != "undefined" ? page:0 }
		}
		).then(function(response) {
			$scope.cities = response.data.cities;
			$scope.dataLoading = false;         
		},function(response) {
			alert('fail');
		});
	}

	$scope.getCites = function(){
		var page = $location.absUrl().split('page=')[1];
		$http.get('get-cities',{
			params : { page: typeof(page) != "undefined" ? page:0 }
		}).then(function(response){
			$scope.cities = response.data.cities;
			$scope.dataLoading = false;
			//console.log(page);
		});
	};
	$scope.getCites();
});