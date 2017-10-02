app.controller("ComZeAppsImportDBCtrl", ["$scope", "$http",
	function ($scope, $http) {

		$scope.start = start;
        $scope.step = 0;
        $scope.offset = 0;
        $scope.max = 0;

		function start() {
			if($scope.step <= 15) {
                $http.get('/zeapps/import_DB/getSizeOf/' + $scope.step).then(function (response) {
                	$scope.offset = 0;
                    $scope.max = parseInt(response.data);
                    //if(parseInt($scope.max) > 25000) $scope.max = 25000;
                    import_table();
                });
            }
		}

		function import_table(){
            $http.get('/zeapps/import_DB/process/' + $scope.step + "/" + $scope.offset).then(function(){
                $scope.offset += 3000;
            	if($scope.offset <= $scope.max) {
                    import_table();
                }
                else{
                    $scope.step++;
            		start();
				}
            });
		}
	}]);