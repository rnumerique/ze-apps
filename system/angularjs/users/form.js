app.controller("ComZeAppsUsersFormCtrl", ["$scope", "$routeParams", "$location", "zeHttp", "zeHooks", "menu",
	function ($scope, $routeParams, $location, zhttp, zeHooks, menu) {

        menu("com_ze_apps_config", "com_ze_apps_users");

		$scope.form = {};
        $scope.hooks = zeHooks.get("zeappsCore_UserFormHook");

		$scope.enregistrer = enregistrer;
		$scope.annuler = annuler;

		// charge la fiche
		if ($routeParams.id && $routeParams.id != 0) {
			zhttp.app.user.get($routeParams.id).then(function (response) {
				if (response.status == 200) {
					$scope.form = response.data.user;
					$scope.form.hourly_rate = parseFloat($scope.form.hourly_rate);
                    if($scope.form.rights) {
                        $scope.form.rights_array = angular.fromJson($scope.form.rights);
                    }
                    else{
                        $scope.form.rights_array = {};
                    }

                    $scope.groups = response.data.groups ;

                    $scope.modules = response.data.modules ;
                    angular.forEach($scope.modules, function(module){
                        module.closed = false;
                    })
				}
			});
		}
		else{
            zhttp.app.user.get_context($routeParams.id).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.groups = response.data.groups ;

                    $scope.modules = response.data.modules ;
                    angular.forEach($scope.modules, function(module){
                        module.closed = false;
                    })
                }
            });
		}

		function enregistrer() {
			$scope.form.rights = angular.toJson($scope.form.rights_array);

			var formatted_data = angular.toJson($scope.form);
			zhttp.app.user.post(formatted_data).then(function () {
				// pour que la page puisse être redirigé
				$location.path("/ng/com_zeapps/users");
			});
		}

		function annuler() {
			$location.path("/ng/com_zeapps/users");
		}

	}]);