app.controller("ComZeAppsGroupsFormCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "$http",
	function ($scope, $route, $routeParams, $location, $rootScope, $http) {

		$scope.$parent.loadMenu("com_ze_apps_config", "com_ze_apps_groups");


		$scope.form = {};

		$scope.enregistrer = enregistrer;
		$scope.annuler = annuler;

		// charge la fiche
		if ($routeParams.id && $routeParams.id != 0) {
			$http.get("/zeapps/group/get/" + $routeParams.id).then(function (response) {
				if (response.status == 200) {
					$scope.form = response.data;
				}
			});
		}

		function enregistrer() {
			var formatted_data = angular.toJson($scope.form);

			$http.post("/zeapps/group/save", formatted_data).then(function () {
				// pour que la page puisse être redirigé
				$location.path("/ng/com_zeapps/groups");
			});
		}

		function annuler() {
			$location.path("/ng/com_zeapps/groups");
		}

	}]);