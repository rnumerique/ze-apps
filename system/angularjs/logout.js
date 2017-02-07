app.controller('ComZeAppsLogoutCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http',
    function ($scope, $route, $routeParams, $location, $rootScope, $http) {
        window.document.location.href = '/zeapps/auth/logout' ;
    }]);