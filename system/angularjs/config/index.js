app.controller('ComZeAppsConfigCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http', 'zeHttp',
    function ($scope, $route, $routeParams, $location, $rootScope, $http, zeHttp) {

        $scope.$parent.loadMenu("com_ze_apps_config", "com_ze_apps_config");


        $scope.emptyCache = function(){
            $http.get('/zeapps/config/emptyCache/').then(function(response){
                if(response.data && response.data != "false"){
                    document.location.reload(true);
                }
            });
        };

        $scope.success = function(){
            var data = {};

            data['id'] = 'zeapps_debug';
            data['value'] = $rootScope.debug ? 1 : 0;

            var formatted_data = angular.toJson(data);
            zeHttp.post('/zeapps/config/save', formatted_data);
        }

    }]);