app.config(["$provide",
	function ($provide) {
		$provide.decorator("zeHttp", ["$delegate", function($delegate){
			var zeHttp = $delegate;

			zeHttp.app = {
				search : search_app,
				get_context : getContext_app,
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
				},
				countries : {
					all : getAll_countries,
					modal : modal_countries
				},
				states : {
					modal : modal_states
				}
            };

			zeHttp.config = angular.extend(zeHttp.config || {}, {
				save : save_config
			});

			return zeHttp;

			// APP
			function getContext_app(){
				return zeHttp.get("/zeapps/app/get_context");
			}

			// SEARCH
            function search_app(query){
                return zeHttp.post("/zeapps/search/searchFor", query);
            }

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
			function modal_user(limit, offset, filters){
                return zeHttp.post("/zeapps/user/modal/" + limit + "/" + offset, filters);
			}
			function post_user(data){
                return zeHttp.post("/zeapps/user/save", data);
			}
			function delete_user(id){
                return zeHttp.delete("/zeapps/user/delete/" + id);
			}

            // COUNTRIES
            function getAll_countries(){
                return zeHttp.get("/zeapps/country/get_all/");
            }
            function modal_countries(limit, offset, filters){
                return zeHttp.post("/zeapps/country/modal/" + limit + "/" + offset, filters);
            }

            // STATES
            function modal_states(limit, offset, filters){
                return zeHttp.post("/zeapps/state/modal/" + limit + "/" + offset, filters);
            }

			// CONFIG
			function save_config(data){
				return zeHttp.post("/zeapps/config/save", data);
			}
		}]);
	}]);