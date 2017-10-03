app.directive("zeBtn", ["$compile", function($compile){
	return {
        priority: 2,
		restrict: "E",
        template: function(elm, attrs){
            var html = elm.html();

            if(attrs.class)
                attrs.class += " ze-btn";
            else
                attrs.class = "ze-btn";

            return "<span "+attrs.text+">" + html + "</span>";
        },
        replace: true,
		link: {
        	pre: function($scope, elm, attrs){
                var color = attrs.color || "primary";
                var fa = attrs.fa || "font-awesome";
                var hint = attrs.hint || "";
                var direction = attrs.direction || "right";
                var alwaysOn = attrs.alwaysOn || false;

				var html = 	"<button type='button' class='btn btn-xs btn-"+color+"'>";

				if(alwaysOn){
				    if(direction === "right"){
                        html += "<i class='fa fa-fw fa-"+fa+"'></i> " + hint;
                    }
                    else{
                        html += hint + " <i class='fa fa-fw fa-"+fa+"'></i>";
                    }
                    html += "</button>";
                }
                else{
				    html += "<i class='fa fa-fw fa-"+fa+"'></i></button>" +
                            "<span class='hover-hint-wrap hover-hint-"+direction+" hover-hint-"+color+"'><span class='hover-hint'>"+hint+"</span></span>";
                }

                $compile(html)($scope, function(cloned){
                    elm.html(cloned);
                });
            }
        }
	};
}]);