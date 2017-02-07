app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider

            .when('/zeapps/logout', {
                controller: 'ComZeAppsLogoutCtrl',
                templateUrl: '/assets/index.html',
            })
        ;
    }]);

