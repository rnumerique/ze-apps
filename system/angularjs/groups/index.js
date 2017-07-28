app.controller("ComZeAppsGroupsCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "$http", "$uibModal",
	function ($scope, $route, $routeParams, $location, $rootScope, $http, $uibModal) {

		$scope.$parent.loadMenu("com_ze_apps_config", "com_ze_apps_groups");

		$scope.delete = del;

		loadList() ;

		function loadList() {
			var options = {};
			$http.post("/zeapps/group/getAll", options).then(function (response) {
				if (response.status == 200) {
					$scope.groups = response.data ;
				}
			});
		}

		function del(argIdUser) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: "/assets/angular/popupModalDeBase.html",
				controller: "ZeAppsPopupModalDeBaseCtrl",
				size: "lg",
				resolve: {
					titre: function () {
						return "Attention";
					},
					msg: function () {
						return "Souhaitez-vous supprimer définitivement ce groupe ?";
					},
					action_danger: function () {
						return "Annuler";
					},
					action_primary: function () {
						return false;
					},
					action_success: function () {
						return "Je confirme la suppression";
					}
				}
			});

			modalInstance.result.then(function (selectedItem) {
				if (selectedItem.action == "success") {
					$http.get("/zeapps/group/delete/" + argIdUser).then(function (response) {
						if (response.status == 200) {
							loadList() ;
						}
					});
				}

			}, function () {
				//console.log("rien");
			});

		}

	}]);