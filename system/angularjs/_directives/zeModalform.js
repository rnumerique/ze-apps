app.directive("zeModalform", function($compile, zeapps_modal){

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
		    	var options = {
                    template: $scope.template,
                    edit: $scope.edit,
                    title: $scope.title
				};

                zeapps_modal.loadModule("com_zeapps_core", "form_modal", options, function(objReturn) {
                    console.log(objReturn);
                    $scope.zeModalform()(objReturn);
                });
			}
        }
	};

});