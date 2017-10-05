app.controller("ComZeAppsUsersCtrl", ["$scope", "zeHttp", "menu",
	function ($scope, zhttp, menu) {

        menu("com_ze_apps_config", "com_ze_apps_users");

		$scope.delete = del;

		loadList() ;

		function loadList() {
			zhttp.app.user.all().then(function (response) {
				if (response.status == 200) {
					$scope.users = response.data ;
				}
			});
		}

		function del(user) {
            zhttp.app.user.del(user.id).then(function (response) {
                if (response.status == 200) {
                	$scope.users.splice($scope.users.indexOf(user), 1);
                }
            });
		}

	}]);