app.directive("zeToast", function(){
    return {
        restrict: "E",
        replace: true,
        template: 	"<div class='alert alert-{{level}} alert-dismissible' role='alert'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
                        "{{msg}}"+
                    "</div>",
        link: function($scope, elm, attrs){
            $scope.level = attrs.level;
            $scope.msg = attrs.msg;

            elm.delay(10000).fadeOut(800, function(){
                elm.alert("close");
            });
        }
    };
});