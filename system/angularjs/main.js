var app = angular.module("zeApp", ["ngRoute","ui.bootstrap", "ui.sortable","ngFileUpload", "chart.js"]);

var listModuleModalFunction = [] ;

app.controller("MainCtrl", ["$scope", "$location", "$rootScope", "zeHttp", "$interval", "menu",
	function ($scope, $location, $rootScope, zhttp, $interval, menu) {

		menu('essentiel', '');

		$rootScope.debug = false;
		$rootScope.defaultLang = "fr-fr";

		$rootScope.logout = logout;

		$scope.dropdown = false;
		$scope.showLabel = false;

		$scope.globalSearch = "";

		/********** Notification **********/
		$scope.notifications = {};
		$scope.showNotification = false;

		/************ Search Bar ***************/
		$scope.searchFill = "";

		/********** Left Menu Toggle **********/
		$scope.fullSizedMenu = true;

		/************ Search Bar ***************/
		$scope.startGlobalSearch = startGlobalSearch;

		/********** Notification **********/
		$scope.toggleNotification = toggleNotification;
		$scope.notificationsNotSeen = notificationsNotSeen;
		$scope.hasUnreadNotifications = hasUnreadNotifications;
		$scope.readNotification = readNotification;
		$scope.readAllNotificationsFrom = readAllNotificationsFrom;

		/********** Loading Effect Logo **********/
		$scope.loading = loading;

		/********** Left Menu Toggle **********/
		$scope.toggleMenuSize = toggleMenuSize;

		/********** Dropdown User menu *********/
		$scope.toggleDropdown = toggleDropdown;



		loadNotifications();

		$scope.$on("$locationChangeStart", function() {
			$rootScope.currentModule = $location.path().split("/")[2];
		});

		$interval(function(){
			loadNotifications();
		}, 30000);

		$interval(function(){
            zhttp.get("/zeapps/app/update_token");
		}, 300000);



		function loading(){
			if($rootScope.httpRequestCount > 0)
				return "loading";
			return false;
		}

		function toggleMenuSize(){
			$scope.fullSizedMenu = !$scope.fullSizedMenu;
		}

		function toggleNotification(){
			$scope.showNotification = !$scope.showNotification;
			$scope.dropdown = false;
			if($scope.showNotification){
				angular.forEach($scope.notifications, function(module){
					for (var i = 0; i < module.notifications.length; i++) {
						module.notifications[i].seen = 1;
					}
				});
                zhttp.post("/zeapps/notification/seenNotification", angular.toJson($scope.notifications));
			}

		}

		function loadNotifications(){
            zhttp.get("/zeapps/notification/getAllUnread").then(function (response) {
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
		}

		function notificationsNotSeen() {
			var total = 0;
			angular.forEach($scope.notifications, function(module){
				for (var i = 0; i < module.notifications.length; i++) {
					if (module.notifications[i].seen == 0)
						total++;
				}
			});
			return total;
		}

		function hasUnreadNotifications(){
			return Object.keys($scope.notifications).length;
		}

		function readNotification(notification){
			notification.read_state = 1;
            zhttp.post("/zeapps/notification/readNotification/"+notification.id).then(function(response){
				if(response.data && response.data != "false"){
					$scope.notifications[notification.module].notifications.splice($scope.notifications[notification.module].notifications.indexOf(notification),1);
					if(!$scope.notifications[notification.module].notifications.length)
						delete $scope.notifications[notification.module];
				}
			});

		}

		function readAllNotificationsFrom(moduleName){
            zhttp.post("/zeapps/notification/readAllNotificationFrom/"+moduleName).then(function(response){
				if(response.data && response.data != "false"){
					delete $scope.notifications[moduleName];
				}
			});
		}

		function toggleDropdown(){
			$scope.dropdown = !$scope.dropdown;
			$scope.showNotification = false;
		}

		function startGlobalSearch($event){
            if($event.which === 13){
            	var formatted_query = $scope.globalSearch.replace(/\s/g, "+");
                $location.url('/ng/com_zeapps/search/' + formatted_query);
            }
		}

		function logout() {
			window.document.location.href = "/logout";
		}
	}]);

// creation des routes
app.config(["$locationProvider", "$compileProvider", "$provide",
	function ($locationProvider, $compileProvider, $provide) {
	$locationProvider.html5Mode(true);
    $compileProvider.commentDirectivesEnabled(false);
    $compileProvider.cssClassDirectivesEnabled(false);
    $compileProvider.debugInfoEnabled(false);

    $provide.decorator("$http", ["$delegate", "$q", "$log", "$rootScope", "$templateCache",
		function ($delegate, $q, $log, $rootScope, $templateCache) {
        var $http = $delegate;

        //Copy every shortcut method
        angular.forEach(["get", "put", "post", "delete", "head", "jsonp"], function iterator(method) {
            _http[method] = function(url, data, config) {
                if(typeof data !== "string")
                    data = angular.toJson(data);
                return _http(angular.extend(config || {}, {
                    method: method,
                    url: url,
                    data: data
                }));
            };
        });

        return _http;



        //Extend the $http with the console output when in debug mode
        function _http(config) {
            var defer = $q.defer();
            var promise;

            config = config || {};

            if(config.url.indexOf("uib/template") > -1) {
                defer.resolve({data : $templateCache.get(config.url)});
                promise = defer.promise;
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
                                $log.info("URL : " + config.url);
                                if (config.data) {
                                    $log.warn("DATA SENT : ");
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
                                $log.error("URL : " + config.url);
                                if (config.data) {
                                    $log.warn("DATA SENT : ");
                                    $log.warn(config.data);
                                }
                                $log.debug(response.data);
                            }
                        }
                        defer.reject(response);
                    },
                    defer.notify
                );
                promise = defer.promise;
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
    }]);
}]);

app.run(["zeHttp", "zeHooks", "$rootScope", function(zhttp, zeHooks, $rootScope){
	moment.locale("fr");

    zhttp.app.get_context().then(function(response){
    	if(response.data && response.data != "false"){
    		angular.forEach(response.data, function(value, key){
    			if (key == "hooks") {
                    zeHooks.set(value);
                    $rootScope.daemon_hooks = zeHooks.get("zeappsDaemon_Hook");
				} else {
                    $rootScope[key] = value;
				}
			});
            $rootScope.contextLoaded = true;
		}
	});
}]);