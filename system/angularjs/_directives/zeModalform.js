app.directive("zeModalform", ["$compile", "zeapps_modal", function($compile, zeapps_modal){

	return {
		restrict: "A",
		scope: {
            zeModalform: '&',
			edit: '=',
            template: '=',
			title: '@'
		},
		link: function($scope, elm){
            elm.attr("ng-click", "openModal()");
            elm.removeAttr("ze-modalform");
            $compile(elm)($scope);

		    $scope.openModal = openModal;

		    function openModal(){
		        var copy = {};

		        if($scope.edit) {
                    angular.forEach($scope.edit, function (value, key) {
                        copy[key] = value;
                    });
                }

		    	var options = {
                    template: $scope.template,
                    edit: copy,
                    title: $scope.title
				};

                zeapps_modal.loadModule("com_zeapps_core", "form_modal", options, function(objReturn) {
                    if($scope.edit) {
                        angular.forEach(objReturn, function (value, key) {
                            $scope.edit[key] = value;
                        });
                    }
                    $scope.zeModalform()(objReturn);
                });
			}
        }
	};

}]);