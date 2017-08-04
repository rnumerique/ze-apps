app.directive("calendar", function($location){
	return {
		restrict: "E",
		scope: {
			model: "="
		},
		link: function($scope, elm){
			var $elm  = $(elm);

			var options = {
				header: {
					left: "prev,next today",
					center: "title",
					right: "month,basicWeek,listDay"
				},
				buttonText: {
					listWeek: "Semaine",
					listDay: "Journée"
				},
				locale: "fr",
				editable: false,
				eventOrder: "order,title",
                clickDayView: "listDay",
				dayClick: function(date, jsEvent, view){
                    $elm.fullCalendar('gotoDate', date);
                    $elm.fullCalendar('changeView', view.calendar.overrides.clickDayView);
				},
				eventClick: function(calEvent){
					if(calEvent.url) {
                        $location.url(calEvent.url);
                    }
				}
			};

			if($scope.model) {
				angular.forEach(Object.keys($scope.model), function (key) {
					options[key] = $scope.model[key];
				});
			}

            $elm.fullCalendar(options);

			$scope.$watch("model", function(model, oldModel){
				if(model && model != oldModel){
                    $elm.fullCalendar('removeEvents');
                    $elm.fullCalendar('addEventSource', $scope.model.events);
                    $elm.fullCalendar('rerenderEvents');
				}
			}, true)
		}
	};
});