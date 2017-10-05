app.controller("ComZeAppsGroupsCtrl", ["$scope", "zeHttp", "zeapps_modal", "menu",
	function ($scope, zhttp, zeapps_modal, menu) {

        menu("com_ze_apps_config", "com_ze_apps_groups");

		$scope.create = create;
		$scope.edit = edit;
		$scope.delete = del;
		$scope.save = save;

		loadList() ;

		function loadList() {
			zhttp.app.groups.all().then(function (response) {
				if (response.status == 200) {
					$scope.groups = response.data.groups ;
					angular.forEach($scope.groups, function(group){
						if(group.rights) {
                            group.rights_array = angular.fromJson(group.rights);
                        }
                        else{
							group.rights_array = {};
						}
					});

					$scope.modules = response.data.modules ;
					angular.forEach($scope.modules, function(module){
						module.closed = false;
					})
				}
			});
		}

		function create(){
            var options = {};
            zeapps_modal.loadModule("com_zeapps_core", "form_group", options, function(objReturn) {
                if (objReturn) {
                	var formatted_data = angular.toJson(objReturn);

                	zhttp.app.groups.post(formatted_data).then(function(response){
                		if(response.data && response.data != "false"){
                			objReturn.id = response.data;

                			$scope.groups.push(objReturn);
						}
					});
                }
            });
		}

		function edit(group){
            var options = {
            	group: angular.fromJson(angular.toJson(group))
            };
            zeapps_modal.loadModule("com_zeapps_core", "form_group", options, function(objReturn) {
                if (objReturn) {
                    var formatted_data = angular.toJson(objReturn);

                    zhttp.app.groups.post(formatted_data).then(function(response){
                        if(response.data && response.data != "false"){
                        	$scope.groups[$scope.groups.indexOf(group)] = objReturn;
                        }
                    });
                }
            });
		}

		function save(group){
			group.rights = angular.toJson(group.rights_array);

			var formatted_data = angular.toJson(group);
			zhttp.app.groups.post(formatted_data);
		}

		function del(group) {
            zhttp.app.groups.del(group.id).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.groups.splice($scope.groups.indexOf(group), 1);
                }
            });
		}
	}]);