app.directive("zeFilters", function(){
	return {
		restrict: "E",
		scope: {
			model: "=",
			options: "="
		},
		replace: true,
		templateUrl: "/zeapps/directives/zefilter",
		link: function($scope){
			$scope.shownFilter = false;

			$scope.clearFilter = clearFilter;
			$scope.canReset = canReset;

			function clearFilter(){
				$scope.model = {};
			}

			function canReset(){
				var isEmpty = true;
				Object.keys($scope.model).map(function(key){
					if($scope.model[key] != '')
						isEmpty = false;
				});
				return !isEmpty;
			}
		}
	};
});