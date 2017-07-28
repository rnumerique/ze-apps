app.filter("trusted", function($sce){
	return function(html){
		return $sce.trustAsHtml(html);
	};
});