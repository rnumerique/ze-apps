app.directive("zeToast", ["$timeout", function($timeout){
    return {
        restrict: "E",
        replace: true,
        template: 	"<div class='alert alert-{{level}} alert-dismissible' role='alert' ng-mouseenter='pause()' ng-mouseleave='start()'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close' ng-click='close()'><span aria-hidden='true'>&times;</span></button>"+
                        "{{msg}}"+
                    "</div>",
        link: function($scope, elm, attrs){
            var delay;

            $scope.level = attrs.level;
            $scope.msg = attrs.msg;
            $scope.start = start;
            $scope.pause = pause;
            $scope.close = close;

            start();

            function start() {
                delay = $timeout(function () {
                    elm.fadeOut(800, function () {
                        elm.alert("close");
                    });
                }, 5000);
            }

            function pause(){
                $timeout.cancel(delay);
            }

            function close(){
                $timeout.cancel(delay);
            }
        }
    };
}]);