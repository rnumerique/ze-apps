app.config(["$routeProvider",
	function ($routeProvider) {
		$routeProvider
			// DEFAULT
			.when("/", {
				redirectTo: "/ng/com_zeapps_project/project"
			})
			.when("/ng/", {
				redirectTo: "/ng/com_zeapps/config"
			})

            // CONFIG
			.when("/ng/com_zeapps/config", {
				templateUrl: "/zeapps/config/",
				controller: "ComZeAppsConfigCtrl"
			})

            // USERS
			.when("/ng/com_zeapps/users", {
				templateUrl: "/zeapps/user/view",
				controller: "ComZeAppsUsersCtrl"
			})
			.when("/ng/com_zeapps/users/view/:id?", {
				templateUrl: "/zeapps/user/form ",
				controller: "ComZeAppsUsersFormCtrl"
			})

			// GROUPS
			.when("/ng/com_zeapps/groups", {
				templateUrl: "/zeapps/group/view",
				controller: "ComZeAppsGroupsCtrl"
			})

			// PROFILE
			.when("/ng/com_zeapps/profile/view", {
				templateUrl:"/zeapps/profile/view",
				controller: "ComZeAppsProfileViewCtrl"
			})
			.when("/ng/com_zeapps/profile/edit", {
				templateUrl:"/zeapps/profile/form",
				controller: "ComZeAppsProfileFormCtrl"
			})
			.when("/ng/com_zeapps/profile/notifications", {
				templateUrl:"/zeapps/profile/notifications",
				controller: "ComZeAppsProfileNotificationsCtrl"
			})

			// MODULES
			.when("/ng/com_zeapps/modules", {
				templateUrl:"/zeapps/modules/",
				controller: "ComZeAppsModulesCtrl"
			})

			// LOGOUT
			.when("/ng/com_zeapps/logout", {
				controller: "ComZeAppsLogoutCtrl",
				templateUrl: "/assets/index.html"
			})

			// 404
			.otherwise({
				redirectTo : "/ng/com_zeapps_project/project"
			})
		;
	}]);

