app.controller("ComZeAppsProfileViewCtrl", ["$scope", "$routeParams", "$location", "zeHttp",
	function ($scope, $routeParams, $location, zhttp) {


		// Edition d'un plan de charge

		$scope.edit_profile = edit_profile;

		// charge la fiche

        zhttp.get("/zeapps/profile/get/" + $routeParams.id).then(function (response) {
			if (response.status == 200) {
				$scope.user = response.data;
			}
		});


		function edit_profile() {
			$location.path("/ng/com_zeapps/profile/edit");
		}

	}]);