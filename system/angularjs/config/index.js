app.controller("ComZeAppsConfigCtrl", ["$scope", "$rootScope", "zeHttp", "menu",
	function ($scope, $rootScope, zhttp, menu) {

        menu("com_ze_apps_config", "com_ze_apps_config");

		$scope.emptyCache = emptyCache;
		$scope.success = success;

		function emptyCache(){
			zhttp.get("/zeapps/config/emptyCache/").then(function(response){
				if(response.data && response.data != "false"){
					document.location.reload(true);
				}
			});
		}

		function success(){
			var data = {};

			data["id"] = "zeapps_debug";
			data["value"] = $rootScope.debug ? 1 : 0;

			var formatted_data = angular.toJson(data);
			zhttp.config.save(formatted_data);
		}

	}]);