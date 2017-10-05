app.controller("ComZeAppsProfileNotificationsCtrl", ["$scope", "zeHttp", "$interval",
	function ($scope, zhttp, $interval) {

		$scope.notifications = {};

		$scope.hasNotifications = hasNotifications;

		loadNotifications();

		$interval(function(){
			loadNotifications();
		}, 30000);

		function loadNotifications(){
            zhttp.get("/zeapps/notification/getAll").then(function (response) {
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

		function hasNotifications(){
			return Object.keys($scope.notifications).length;
		}

	}]);