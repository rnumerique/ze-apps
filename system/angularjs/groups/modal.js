// declare the modal to the app service
listModuleModalFunction.push({
	module_name:"com_zeapps_core",
	function_name:"form_group",
	templateUrl:"/zeapps/group/modal",
	controller:"ZeAppsGroupModalCtrl",
	size:"lg",
	resolve:{
		titre: function () {
			return "Ajouter un groupe";
		}
	}
});


app.controller("ZeAppsGroupModalCtrl", ["$scope", "$uibModalInstance", "titre", "option", function($scope, $uibModalInstance, titre, option) {

	$scope.titre = titre ;

	$scope.cancel = cancel;
	$scope.save = save;

	if(option.group){
		$scope.form = option.group;
        $scope.titre = "Modifier un groupe";
	}
	else{
		$scope.form = {};
	}

	function cancel() {
		$uibModalInstance.dismiss("cancel");
	}

	function save() {
		$uibModalInstance.close($scope.form);
	}

}]) ;