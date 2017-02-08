app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider

            .when('/', {
                redirectTo: '/ng/com_zeapps/config'
            })

            .when('/ng/', {
                redirectTo: '/ng/com_zeapps/config'
            })

            .when('/ng/com_zeapps/config', {
                templateUrl: '/ze-apps/config/',
                controller: 'ComZeAppsConfigCtrl'
            })

            .when('/zeapps/logout', {
                controller: 'ComZeAppsLogoutCtrl',
                templateUrl: '/assets/index.html'
            })

            .otherwise({
                redirectTo : '/'
            })

        ;
    }]);

