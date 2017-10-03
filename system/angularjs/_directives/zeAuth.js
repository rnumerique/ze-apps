app.directive("zeAuth", ["$rootScope", function($rootScope){

	return {
		restrict: "A",
		scope: {
            zeAuth: '@'
		},
		link: function(scope, elm){
            elm.hide();

			var watch1 = scope.$watch("zeAuth", function(value){
                if(value) {
                    if(evaluateRight(value, elm)){
                        watch1();
                        watch2();
                    }
                }
			}, true);
            var watch2 = $rootScope.$watch("user", function(value){
                if(value) {
                    if(evaluateRight(scope.zeAuth, elm)){
                        watch1();
                        watch2();
                    }
                }
            }, true);
		}
	};

	function evaluateRight(right, elm){
        if($rootScope.user && $rootScope.user.rights){
            if($rootScope.user.rights[right] !== 1) {
                elm.remove();
            }
            else{
                elm.show();
                elm.removeAttr("ze-auth");
            }
            return true;
        }
        return false;
	}

}]);