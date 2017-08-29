app.filter("i8n", function(lang){
	return function(item){
		return lang.translate(item);
	};
});