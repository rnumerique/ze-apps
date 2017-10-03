app.service("toasts", ["$rootScope", "$compile", function($rootScope, $compile){
	return add;
	
	function add(level, msg){
		var html = "<ze-toast data-level=\""+level+"\" data-msg=\""+msg+"\"></ze-toast>";

        $compile(html)($rootScope, function(cloned){
            $('toasts').prepend(cloned);
        });
	}
}]);