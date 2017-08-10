app.directive("zeBtn", function($compile){
	return {
        priority: 2,
		restrict: "E",
		link: {
        	pre: function($scope, elm, attrs){
                var color = attrs.color || "primary";
                var fa = attrs.fa || "font-awesome";
                var hint = attrs.hint || "";
                var direction = attrs.direction || "left";

				var html = 	"<button type='button' class='btn btn-xs btn-"+color+"'>" +
                    			"<i class='fa fa-fw fa-"+fa+"'></i>" +
                    			"<span class='hover-hint-wrap hover-hint-"+direction+"'><span class='hover-hint'>"+hint+"</span></span>" +
                    		"</button>";

                $compile(html)($scope, function(cloned){
                    elm.html(cloned);
                });
            }
        }
	};
});