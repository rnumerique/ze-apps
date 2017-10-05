app.controller("ComZeAppsModulesCtrl", ["$scope", "zeHttp", "menu",
	function ($scope, zhttp, menu) {

        menu("com_ze_apps_config", "com_ze_apps_modules");

		$scope.modules = [];
		$scope.modulesToInstall = [];
		$scope.modulesToUpdate = [];
		$scope.modulesForm = {};

		$scope.installModules = installModules;
		$scope.toggleActivation = toggleActivation;
		$scope.testIfActif = testIfActif;

        zhttp.get("/zeapps/modules/getAll").then(function(response){
			if(response.data && response.data!="false"){
				$scope.modules = response.data;
			}
		});

        zhttp.get("/zeapps/modules/toInstall").then(function(response){
			if(response.data && response.data!="false"){
				var i;
				$scope.modulesToInstall = response.data.toInstall;
				$scope.modulesToUpdate = response.data.toUpdate;
				for(i=0;i<$scope.modulesToInstall.length;i++){
					$scope.modulesForm[$scope.modulesToInstall[i].module_id] = true;
				}
				for(i=0;i<$scope.modulesToUpdate.length;i++){
					$scope.modulesForm[$scope.modulesToUpdate[i].module_id] = true;
				}
			}
		});

		function installModules(){

			var data = {modules:[]};

			angular.forEach($scope.modulesForm, function(value, module_id){
				if(value){
					data.modules.push(module_id);
				}
			});

			var formatted_data = angular.toJson(data);
            zhttp.post("/zeapps/modules/installModules", formatted_data).then(function(response){
				if(response.data && response.data!="false"){
					document.location.reload(true);
				}
			});

		}

		function toggleActivation(module){
			var active = parseInt(module.active) ? "0" : "1";
            zhttp.post("/zeapps/modules/toggleActivation/" + module.id + "/" + active).then(function(response){
				if(response.data && response.data != "false"){
					document.location.reload(true);
				}
			});
		}

		function testIfActif(module){
			var classes = "";
			var active = parseInt(module.active);
			if(active){
				if(module.missing_dependencies != "") {
					classes = "fa-exclamation-triangle text-warning";
				}
				else{
					classes = "fa-check text-success";
				}
			}
			else{
				classes = "fa-times text-danger";
			}
			return classes;
		}

	}]);