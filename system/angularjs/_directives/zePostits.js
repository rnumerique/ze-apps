app.directive("zePostits", [function(){
	return {
		restrict: "E",
		scope: {
			postits: "="
		},
        replace: true,
        templateUrl: "/zeapps/directives/zepostits"
	};
}])

	.filter("postitFilter", ["$filter", function($filter){
		return function(input, filter, args){
			if(filter) {
                if(Array.isArray(args)) {
                	args.unshift(input);
                }
                else{
                	args = [];
                	args.push(input);
				}

                return $filter(filter).apply(undefined, args);
            }
            else{
				return input;
			}
		}
	}]);