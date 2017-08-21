app.directive("zeBtn", function($compile){
	return {
        priority: 2,
		restrict: "E",
		link: {
        	pre: function($scope, elm, attrs){
                var color = attrs.color || "primary";
                var fa = attrs.fa || "font-awesome";
                var hint = attrs.hint || "";
                var direction = attrs.direction || "right";
                var alwaysOn = attrs.alwaysOn || false;

				var html = 	"<button type='button' class='btn btn-xs btn-"+color+"'>";

				if(alwaysOn){
				    if(direction === "right"){
                        html += "<i class='fa fa-fw fa-"+fa+"'></i> " + hint;
                    }
                    else{
                        html += hint + " <i class='fa fa-fw fa-"+fa+"'></i>";
                    }
                }
                else{
				    html += "<i class='fa fa-fw fa-"+fa+"'></i>" +
                            "<span class='hover-hint-wrap hover-hint-"+direction+"'><span class='hover-hint'>"+hint+"</span></span>";
                }

                html += "</button>";

                $compile(html)($scope, function(cloned){
                    elm.html(cloned);
                });
            }
        }
	};
});