app.controller("ComZeAppsGroupsFormCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "$http",
	function ($scope, $route, $routeParams, $location, $rootScope, $http) {

		$scope.$parent.loadMenu("com_ze_apps_config", "com_ze_apps_groups");


		$scope.form = [];

		$scope.enregistrer = enregistrer;
		$scope.annuler = annuler;

		// charge la fiche
		if ($routeParams.id && $routeParams.id != 0) {
			$http.get("/zeapps/group/get/" + $routeParams.id).then(function (response) {
				if (response.status == 200) {
					$scope.form = response.data;

					if ($scope.form.right_list) {
						$scope.form.rights = $scope.form.right_list.split(",");
					} else {
						$scope.form.rights = [] ;
					}

				}
			});
		}

		// charge la liste des droits
		$http.get("/zeapps/user/getRightList").then(function (response) {
			if (response.status == 200) {
				$scope.right_list = response.data ;
			}
		});

		function enregistrer() {
			var $data = {} ;

			if ($routeParams.id != 0) {
				$data.id = $routeParams.id;
			}

			$data.name = $scope.form.name ;
			$data.right_list = $scope.form.rights.join() ;

			$http.post("/zeapps/group/save", $data).then(function () {
				// pour que la page puisse être redirigé
				$location.path("/ng/com_zeapps/groups");
			});
		}

		function annuler() {
			$location.path("/ng/com_zeapps/groups");
		}

	}]);