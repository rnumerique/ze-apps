app.directive("ngDynamicController", ["$compile",function($compile) {
	return {
		scope: {
			name: "=ngDynamicController"
		},
		restrict: "A",
		priority: 100000,
		link: function(scope, elem) {
			elem.attr("ng-controller", scope.name);
			elem.removeAttr("ng-dynamic-controller");

			$compile(elem)(scope);
		}
	};
}]);