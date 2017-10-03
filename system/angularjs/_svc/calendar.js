app.factory("zeCalendar", ["$location", function($location){
	var $elm;
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

	return {
		init: init,
        fill: fill
	};

	function init(data){
        $elm = $("ze-calendar");

        angular.forEach(Object.keys(data), function (key) {
            options[key] = data[key];
        });

        $elm.fullCalendar(options);
	}

	function fill(events){
        $elm.fullCalendar('removeEvents');
        $elm.fullCalendar('addEventSource', events);
        $elm.fullCalendar('rerenderEvents');
	}
}]);