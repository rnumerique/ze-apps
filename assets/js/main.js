//var app = angular.module('zeApp', ['ngRoute', 'ngAnimate', 'services', 'checklist-model', 'ckeditor']) ;
var app = angular.module('zeApp', ['ngSanitize','ngRoute','ui.bootstrap', 'ui.sortable','checklist-model', 'digitalfondue.dftabmenu', 'ngFileUpload']);


app.controller('MainCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http', '$interval',
    function ($scope, $route, $routeParams, $location, $rootScope, $http, $interval) {

        // pour charger la vue par défaut
        //$location.path('/ng/com_zeapps_contact/companies');

        $scope.notifications = {};
        $rootScope.toasts = [];


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





        /********** Update token to update time limit of session **********/
        var updateTokenEvery5Minutes = function(){
            $http.get('/zeapps/app/update_token').then(function (response) {
                if (response.data && response.data != false) {

                }
            });
        };

        updateTokenEvery5Minutes();

        $interval(function(){
            updateTokenEvery5Minutes();
        }, 300000);





        /********** Notification **********/

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
                $http.post('/ze-apps/notification/seenNotification', $scope.notifications);
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
            $http.post('/ze-apps/notification/readNotification/'+notification.id).then(function(response){
                if(response.data && response.data != "false"){
                    $scope.notifications[notification.module].notifications.splice($scope.notifications[notification.module].notifications.indexOf(notification),1);
                    if(!$scope.notifications[notification.module].notifications.length)
                        delete $scope.notifications[notification.module];
                }
            });

        };

        $scope.readAllNotificationsFrom = function(moduleName){
            $http.post('/ze-apps/notification/readAllNotificationFrom/'+moduleName).then(function(response){
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




        var getCurentUser = function () {
            var options = {};
            $http.post('/zeapps/user/getCurrentUser', options).then(function (response) {
                if (response.status == 200) {
                    $scope.user = response.data;
                    $rootScope.userLang = response.data.lang;
                }
            });
        };
        getCurentUser() ;



        /************ Search Bar ***************/

        $scope.searchFill = "";

        $scope.search = function(){
            $http.post('/ze-apps/search/generalSearch');
        }

    }]);

// creation des routes
app.config(['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);
    }]);


// defini les caracteres separateur pour remplacer les / dans les url
var charSepUrlSlash = "999sep999sep999" ;
var charSepUrlSlashRegExp = /999sep999sep999/g ;
