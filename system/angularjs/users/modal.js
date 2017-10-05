// declare the modal to the app service
listModuleModalFunction.push({
	module_name:"com_zeapps_core",
	function_name:"search_user",
	templateUrl:"/zeapps/user/modal_user",
	controller:"ZeAppsCoreModalUserCtrl",
	size:"lg",
	resolve:{
		titre: function () {
			return "Recherche d'un utilisateur";
		}
	}
});


app.controller("ZeAppsCoreModalUserCtrl", ["$scope", "$uibModalInstance", "zeHttp", "titre", "option", function($scope, $uibModalInstance, zhttp, titre, option) {

	$scope.titre = titre ;

	option.banned_ids = option.banned_ids || [];

	$scope.loadUser = loadUser;
	$scope.cancel = cancel;

	loadList() ;

	function loadList() {
        zhttp.app.user.all().then(function (response) {
			if (response.status == 200) {
				var users = response.data;
				$scope.users = [];
				angular.forEach(users, function(user){
					if(( !option.whitelist_ids || option.whitelist_ids.indexOf(user.id) !== -1 ) && option.banned_ids.indexOf(user.id) === -1){
						$scope.users.push(user);
					}
				});
			}
		});
	}

	function loadUser(id_user) {

		// search the user
		var user = false ;
		for (var i = 0 ; i < $scope.users.length ; i++) {
			if ($scope.users[i].id == id_user) {
				user = $scope.users[i] ;
				break;
			}
		}

		$uibModalInstance.close(user);
	}

	function cancel() {
		$uibModalInstance.dismiss("cancel");
	}

}]) ;