app.directive("zeModalselection", function($compile, zeapps_modal){

	return {
		restrict: "A",
		scope: {
            zeModalselection: '&',
			http: '=',
            fields: '=',
			title: '@'
		},
		link: function($scope, elm){
            elm.attr("ng-click", "openModal()");
            elm.removeAttr("ze-modalselection");
            $compile(elm)($scope);

		    $scope.openModal = openModal;

		    function openModal(){
		    	var options = {
		    		http: $scope.http,
					fields: $scope.fields,
                    title: $scope.title
				};

                zeapps_modal.loadModule("com_zeapps_core", "search_modal", options, function(objReturn) {
                    $scope.zeModalselection()(objReturn);
                });
			}
        }
	};

});