app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider

            .when('/', {
                redirectTo: '/ng/com_zeapps_contact/companies/'
            })

            .when('/ng/', {
                redirectTo: '/ng/com_zeapps/config'
            })

            .when('/ng/com_zeapps/config', {
                templateUrl: '/zeapps/config/',
                controller: 'ComZeAppsConfigCtrl'
            })


            .when('/ng/com_zeapps/users', {
                templateUrl: '/zeapps/user/',
                controller: 'ComZeAppsUsersCtrl'
            })
            .when('/ng/com_zeapps/users/view/:id?', {
                templateUrl: '/zeapps/user/form ',
                controller: 'ComZeAppsUsersFormCtrl'
            })


            .when('/ng/com_zeapps/groups', {
                templateUrl: '/zeapps/group/',
                controller: 'ComZeAppsGroupsCtrl'
            })
            .when('/ng/com_zeapps/groups/view/:id?', {
                templateUrl: '/zeapps/group/form ',
                controller: 'ComZeAppsGroupsFormCtrl'
            })



            .when('/ng/com_zeapps/profile/view', {
                templateUrl:'/zeapps/profile/view',
                controller: 'ComZeAppsProfileViewCtrl'
            })

            .when('/ng/com_zeapps/profile/edit', {
                templateUrl:'/zeapps/profile/form',
                controller: 'ComZeAppsProfileFormCtrl'
            })

            .when('/ng/com_zeapps/profile/notifications', {
                templateUrl:'/zeapps/profile/notifications',
                controller: 'ComZeAppsProfileNotificationsCtrl'
            })



            .when('/ng/com_zeapps/modules', {
                templateUrl:'/zeapps/modules/',
                controller: 'ComZeAppsModulesCtrl'
            })

            .when('/ng/com_zeapps/logout', {
                controller: 'ComZeAppsLogoutCtrl',
                templateUrl: '/assets/index.html'
            })

            .otherwise({
                redirectTo : '/ng/com_zeapps_contact/companies/'
            })

        ;
    }]);

