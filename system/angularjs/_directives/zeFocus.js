app.directive("zeFocus", function($timeout){
	return {
		restrict: "A",
		link: function($scope, elm, attrs) {
            $scope.$watch(attrs.zeFocus, function (val) {
                if (angular.isDefined(val) && val) {
                    $timeout(function () {
                        elm[0].focus();
                    });
                }
            });
        }
	};
});