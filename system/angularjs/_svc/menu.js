app.service("menu", function($rootScope){
	return load;
	
	function load(menu, item){
        $rootScope.menu = menu ;
        $rootScope.menu_active = item ;

        $("#left-menu .nav a").blur();
	}
});