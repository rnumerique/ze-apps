var app = angular.module('zeApp', ['ngSanitize','ngRoute','ui.bootstrap', 'ui.sortable','checklist-model', 'digitalfondue.dftabmenu', 'ngFileUpload', 'chart.js']);


app.controller('MainCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http', '$interval',
    function ($scope, $route, $routeParams, $location, $rootScope, $http, $interval) {

        $scope.notifications = {};
        $rootScope.toasts = [];
        $rootScope.debug = false;


        $scope.$on('$locationChangeStart', function() {
            $rootScope.currentModule = $location.path().split('/')[2];
        });

        $rootScope.defaultLang = 'fr-fr';
        
        $scope.dropdown = false;
        $scope.showNotification = false;
        $scope.showLabel = false;


        $rootScope.logout = function () {
            window.document.location.href = '/logout';
        };

        $scope.loadMenu = function(argMenu, argItemActive) {
            $scope["menu"] = argMenu ;
            $scope["menu_active"] = argItemActive ;

            $("#left-menu .nav a").blur();
        };

        /********** Debug Mode **********/

        $http.get('/zeapps/config/get/zeapps_debug').then(function(response){
            if(response.data && response.data != false){
                $rootScope.debug = !!parseInt(response.data.value);
            }
        });

        /********** Loading Effect Logo **********/

        $scope.loading = function(){
            if($rootScope.httpRequestCount > 0)
                return 'loading';
            return false;
        };

        /********** Left Menu Toggle **********/

        $scope.fullSizedMenu = true;

        $scope.toggleMenuSize = function(){
            $scope.fullSizedMenu = !$scope.fullSizedMenu;
        };


        /********** Notification **********/

        $scope.toggleNotification = function(){
            $scope.showNotification = !$scope.showNotification;
            $scope.dropdown = false;
            if($scope.showNotification){
                angular.forEach($scope.notifications, function(module){
                    for (var i = 0; i < module.notifications.length; i++) {
                        module.notifications[i].seen = 1;
                    }
                });
                $http.post('/zeapps/notification/seenNotification', angular.toJson($scope.notifications));
            }

        };

        var loadNotifications = function(){
            $http.get('/zeapps/notification/getAllUnread').then(function (response) {
                if (response.data && response.data != false) {
                    var notifications = {};
                    for(var i=0; i < response.data.length; i++){
                        if(notifications[response.data[i].module] == undefined) {
                            notifications[response.data[i].module] = {};
                            notifications[response.data[i].module].notifications = [];
                            notifications[response.data[i].module].color = response.data[i].color;
                        }
                        notifications[response.data[i].module].notifications.push(response.data[i]);
                    }
                    $scope.notifications = notifications;
                }
            });
        };

        loadNotifications();

        $interval(function(){
            loadNotifications();
        }, 30000);

        $interval(function(){
            $http.get('/zeapps/app/update_token');
        }, 300000);

        $scope.notificationsNotSeen = function() {
            var total = 0;
            angular.forEach($scope.notifications, function(module){
                for (var i = 0; i < module.notifications.length; i++) {
                    if (module.notifications[i].seen == 0)
                        total++;
                }
            });
            return total;
        };

        $scope.hasUnreadNotifications = function(){
            return Object.keys($scope.notifications).length;
        };

        $scope.readNotification = function(notification){
            notification.read_state = 1;
            $http.post('/zeapps/notification/readNotification/'+notification.id).then(function(response){
                if(response.data && response.data != "false"){
                    $scope.notifications[notification.module].notifications.splice($scope.notifications[notification.module].notifications.indexOf(notification),1);
                    if(!$scope.notifications[notification.module].notifications.length)
                        delete $scope.notifications[notification.module];
                }
            });

        };

        $scope.readAllNotificationsFrom = function(moduleName){
            $http.post('/zeapps/notification/readAllNotificationFrom/'+moduleName).then(function(response){
                if(response.data && response.data != "false"){
                    delete $scope.notifications[moduleName];
                }
            });
        };


        /********** Dropdown User menu *********/

        $scope.toggleDropdown = function(){
            $scope.dropdown = !$scope.dropdown;
            $scope.showNotification = false;
        };


        /************ Search Bar ***************/

        $scope.searchFill = "";

        $scope.search = function(){
            $http.post('/zeapps/search/generalSearch');
        }

    }]);

// creation des routes
app.config(['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);
    }]);


app.config(['$provide',
    function ($provide) {

        $provide.decorator('$http', function ($delegate, $q, $log, $rootScope, $templateCache) {
            var $http = $delegate;

            //Extend the $http with the console output when in debug mode
            function _http(config) {
                var defer = $q.defer();

                config = config || {};

                if(config.url.indexOf('uib/template') > -1) {
                    defer.resolve({data : $templateCache.get(config.url)});
                    var promise = defer.promise;
                }
                else {

                    config.notify = defer.notify;

                    $http(config).then(
                        function (response) {
                            if ($rootScope.debug) {
                                var data = angular.fromJson(config.data);
                                // Answers with a cache property in the config data are template calls
                                // We choose to ignore those for console clarity
                                if(!data || data.cache == undefined) {
                                    $log.info('URL : ' + config.url);
                                    if (config.data) {
                                        $log.warn('DATA SENT : ');
                                        $log.warn(config.data);
                                    }
                                    $log.debug(response.data);
                                }
                            }
                            defer.resolve(response);
                        },
                        function (response) {
                            if ($rootScope.debug) {
                                var data = angular.fromJson(config.data);
                                // Answers with a cache property in the config data are template calls
                                // We choose to ignore those for console clarity
                                if(!data || data.cache == undefined) {
                                    $log.error('URL : ' + config.url);
                                    if (config.data) {
                                        $log.warn('DATA SENT : ');
                                        $log.warn(config.data);
                                    }
                                    $log.debug(response.data);
                                }
                            }
                            defer.reject(response);
                        },
                        defer.notify
                    );
                    var promise = defer.promise;
                }

                //recreate the success/error methods
                promise.success = function(fn) {
                    promise.then(function(response) {
                        fn(response.data, response.status, response.headers, config);
                    });
                    return promise;
                };

                promise.error = function(fn) {
                    promise.then(null, function(response) {
                        fn(response.data, response.status, response.headers, config);
                    });
                    return promise;
                };

                return promise;
            }

            //Copy every shortcut method
            angular.forEach(['get', 'put', 'post', 'delete', 'head', 'jsonp'], function iterator(method) {
                _http[method] = function(url, data, config) {
                    if(typeof data !== 'string')
                        data = angular.toJson(data);
                    return _http(angular.extend(config || {}, {
                        method: method,
                        url: url,
                        data: data
                    }));
                };
            });

            return _http;
        });

    }]);

app.run(function(zeHttp, zeHooks, $rootScope){
    zeHttp.hooks.get_all().then(function(response){
        if(response.data && response.data != 'false'){
            zeHooks.set(response.data);
        }
    });
    zeHttp.get('/zeapps/user/getCurrentUser').then(function (response) {
        if (response.status == 200) {
            $rootScope.user = response.data;
        }
    });
});


// defini les caracteres separateur pour remplacer les / dans les url
var charSepUrlSlash = "999sep999sep999" ;
var charSepUrlSlashRegExp = /999sep999sep999/g ;