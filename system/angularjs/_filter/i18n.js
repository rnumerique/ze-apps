app.filter("i8n", ["lang", function(lang){
	return function(item){
		return lang.translate(item);
	};
}]);