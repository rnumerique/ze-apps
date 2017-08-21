app.directive("zeFilters", function($timeout){
	return {
		restrict: "E",
		scope: {
			filters: "=",
			model: "=",
			update_view: "&update"
		},
		replace: true,
		templateUrl: "/zeapps/directives/zefilter",
		link: function($scope){
			$scope.shownFilter = false;

			$scope.clearFilter = clearFilter;
			$scope.isEmpty = isEmpty;

			function clearFilter(){
				$scope.model = {};
				$timeout(function(){ // to queue the function call so we are sure the controller scope has been correctly updated
                    $scope.update_view()();
				}, 0);
			}

			function isEmpty(){
				for(var prop in $scope.model) {
					if($scope.model.hasOwnProperty(prop))
						return false;
				}

                return JSON.stringify($scope.model) === JSON.stringify({});
			}
		}
	};
});