app.controller("ComZeAppsProfileFormCtrl", ["$scope", "$routeParams", "$location", "zeHttp",
	function ($scope, $routeParams, $location, zhttp) {

		var options = {};

		$scope.form = [];

		$scope.enregistrer = enregistrer;
		$scope.annuler = annuler;

		// charge la fiche

        zhttp.get("/zeapps/profile/get/" + $routeParams.id).then(function (response) {
			if (response.status == 200) {
				$scope.form = response.data;

				if ($scope.form.groups_list) {
					$scope.form.groups = $scope.form.groups_list.split(",");
				} else {
					$scope.form.groups = [];
				}


				if ($scope.form.right_list) {
					$scope.form.rights = $scope.form.right_list.split(",");
				} else {
					$scope.form.rights = [] ;
				}

			}
		});

        zhttp.post("/zeapps/group/getAll", options).then(function (response) {
			if (response.status == 200) {
				$scope.groups = response.data ;
			}
		});

		// charge la liste des droits
        zhttp.get("/zeapps/user/getRightList").then(function (response) {
			if (response.status == 200) {
				$scope.right_list = response.data ;
			}
		});

		function enregistrer() {
			var $data = {} ;



			if ($scope.form.password_field && $scope.form.password_field.trim() != "") {
				$data.password = $scope.form.password_field ;
			}

			$data.firstname = $scope.form.firstname ;
			$data.lastname = $scope.form.lastname ;
			$data.email = $scope.form.email ;

			$data.groups_list = $scope.form.groups.join();
			$data.right_list = $scope.form.rights.join() ;

            zhttp.post("/zeapps/profile/update_user", $data).then(function () {
				// pour que la page puisse être redirigé
				$location.path("/ng/com_zeapps/profile/view");
			});
		}

		function annuler() {
			$location.path("/ng/com_zeapps/profile/view");

		}


	}]);