app.factory("zeHooks", [function(){

	var hooks = [];

	return {
		set: set,
		get: get
	};


	function set(data){
		angular.forEach(data, function(line){
			if(!hooks[line.hook])
				hooks[line.hook] = [];
			hooks[line.hook].push(line);
		});
	}

	function get(hook){
		return hooks[hook] || [];
	}

}]);