app.directive("zeAuth", function($rootScope){

	return {
		restrict: "A",
		scope: {
            zeAuth: '@'
		},
		link: function(scope, elm){
            elm.hide();

			scope.$watch("zeAuth", function(value){
                if(value) {
                    evaluateRight(value, elm);
                }
			}, true);
            $rootScope.$watch("user", function(value){
                if(value) {
                    evaluateRight(scope.zeAuth, elm);
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
            }
        }
	}

});