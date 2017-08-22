app.directive("zeModalsearch", function($compile, zeapps_modal){

	return {
		restrict: "A",
		scope: {
            zeModalsearch: '&',
			http: '=',
            fields: '=',
			model: '=',
			filters: '=',
			templateNew: '=',
			title: '@'
		},
		template: 	"<div class=\"input-group\">" +
						"<input type=\"text\" ng-model=\"model\" class=\"form-control\" disabled>" +
						"<span class=\"input-group-btn\">" +
							"<button class=\"btn btn-default\" type=\"button\" ng-click=\"clear()\"" +
							"ng-show=\"model != '' && model != undefined\">x" +
							"</button>" +
							"<button class=\"btn btn-default\" type=\"button\" ng-click='openModal()'>...</button>" +
						"</span>" +
					"</div>",
		link: function($scope){
		    $scope.openModal = openModal;
		    $scope.clear = clear;

		    function clear(){
                $scope.zeModalsearch()(false);
			}

		    function openModal(){
		    	var options = {
		    		http: $scope.http,
					fields: $scope.fields,
                    title: $scope.title,
					filters: $scope.filters,
					template: $scope.templateNew
				};

                zeapps_modal.loadModule("com_zeapps_core", "search_modal", options, function(objReturn) {
                	if(objReturn.id !== undefined) {
                        $scope.zeModalsearch()(objReturn);
                    }
                    else{
                		var formatted_data = angular.toJson(objReturn);
                		$scope.http.save(formatted_data).then(function(response){
                			if(response.data && response.data != "false"){
                				objReturn.id = response.data;
                                $scope.zeModalsearch()(objReturn);
							}
						})
					}
                });
			}
        }
	};

});