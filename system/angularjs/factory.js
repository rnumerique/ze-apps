app.config(["$provide",
	function ($provide) {
		$provide.decorator("zeHttp", function($delegate){
			var zeHttp = $delegate;

			zeHttp.hooks = {
				get_all : getAll_hooks
			};

			zeHttp.config = angular.extend(zeHttp.config || {}, {
				save : save_config
			});

			return zeHttp;

			function getAll_hooks(){
				return zeHttp.get("/zeapps/hooks/get_all");
			}

			function save_config(data){
				return zeHttp.post("/zeapps/config/save", data);
			}
		});
	}]);