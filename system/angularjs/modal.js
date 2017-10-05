app.controller("ZeAppsPopupModalDeBaseCtrl", ["$scope", "$uibModalInstance", "titre", "msg", "action_danger", "action_primary", "action_success",
	function($scope, $uibModalInstance, titre, msg, action_danger, action_primary, action_success) {

	$scope.titre = titre ;
	$scope.msg = msg ;
	$scope.action_danger = action_danger ;
	$scope.action_primary = action_primary ;
	$scope.action_success = action_success ;

	$scope.cancel = cancel;
	$scope.action_danger_click = action_danger_click;
	$scope.action_primary_click = action_primary_click;
	$scope.action_success_click = action_success_click;

	function cancel() {
		$uibModalInstance.dismiss("cancel");
	}

	function action_danger_click() {
		$uibModalInstance.close({action:"danger"});
	}

	function action_primary_click() {
		$uibModalInstance.close({action:"primary"});
	}

	function action_success_click() {
		$uibModalInstance.close({action:"success"});
	}
}]) ;


app.factory("zeapps_modal", ["$uibModal", function($uibModal) {

	var myServiceInstance = {};

	myServiceInstance.loadModule = loadModule;

	// factory function body that constructs shinyNewServiceInstance
	return myServiceInstance;

	function loadModule(moduleName, functionName, option, next, dismiss) {

		var moduleTrouve = false ;
		for (var i = 0 ; i < listModuleModalFunction.length ; i++) {
			if (listModuleModalFunction[i].module_name == moduleName && listModuleModalFunction[i].function_name == functionName) {
				moduleTrouve = true ;

				var resolve = listModuleModalFunction[i].resolve ;
				resolve.option = option;

				var modalInstance = $uibModal.open({
					animation: true,
					templateUrl: listModuleModalFunction[i].templateUrl,
					controller: listModuleModalFunction[i].controller,
					size: listModuleModalFunction[i].size,
					resolve: listModuleModalFunction[i].resolve
				});

				modalInstance.result.then(function (selectedItem) {
					next(selectedItem);
				}, function (selectedItem) {
					if(dismiss) {
                        dismiss(selectedItem);
                    }
				});

				break;
			}
		}


		if (moduleTrouve == false) {
			alert("Impossible de charger le module");
		}

	}
}]);