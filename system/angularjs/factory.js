app.config(["$provide",
	function ($provide) {
		$provide.decorator("zeHttp", function($delegate){
			var zeHttp = $delegate;

			zeHttp.app = {
				hooks : {
                    all : getAll_hooks
                },
				groups : {
					all : getAll_groups,
					post : post_groups,
					del : delete_groups
				},
				user : {
					get : get_user,
					get_context : getContext_user,
					all : getAll_user,
					modal : modal_user,
					post : post_user,
					del : delete_user
				}
            };

			zeHttp.config = angular.extend(zeHttp.config || {}, {
				save : save_config
			});

			return zeHttp;

			// HOOKS
			function getAll_hooks(){
				return zeHttp.get("/zeapps/hooks/get_all");
			}

			// GROUPS
			function getAll_groups(){
                return zeHttp.get("/zeapps/group/all");
			}
			function post_groups(data){
                return zeHttp.post("/zeapps/group/save", data);
			}
			function delete_groups(id){
                return zeHttp.delete("/zeapps/group/delete/" + id);
			}

			// USER
			function get_user(id){
                return zeHttp.get("/zeapps/user/get/" + id);
			}
			function getContext_user(){
                return zeHttp.get("/zeapps/user/get_context/");
			}
			function getAll_user(){
                return zeHttp.get("/zeapps/user/all");
			}
			function modal_user(){
                return zeHttp.get("/zeapps/user/modal");
			}
			function post_user(data){
                return zeHttp.post("/zeapps/user/save", data);
			}
			function delete_user(id){
                return zeHttp.delete("/zeapps/user/delete/" + id);
			}

			// CONFIG
			function save_config(data){
				return zeHttp.post("/zeapps/config/save", data);
			}
		});
	}]);