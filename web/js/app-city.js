var app = angular.module("demoApp", []);
app.controller("demoCityCtrl", function($scope,$http) {

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
			$scope.getCites();
			$scope.status = "create";           
		},function(response) {
			alert('fail');
		});
	};

	$scope.edit = function(city){
		$scope.data = city;
		$scope.status = "update";
	};

	$scope.clearDataInput = function(){
		$scope.data = {
			cityname:""
		};
	};

	$scope.getCitiesAfterCreate = function(city){

	};

	$scope.getCites = function(){
		var page = window.location.href.split('page=')[1];
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