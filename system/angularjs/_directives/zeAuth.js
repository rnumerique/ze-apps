app.directive("zeAuth", function($rootScope){

	return {
		restrict: "A",
		scope: {
            zeAuth: '='
		},
		link: function(scope, elm){
			scope.$watch("zeAuth", function(value){
				evaluateRight(value, elm);
			}, true);
		}
	};

	function evaluateRight(right, elm){
		if($rootScope.user && $rootScope.user.rights && $rootScope.user.rights[right] !== "1"){
			elm.remove();
		}
	}

});