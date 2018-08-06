(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$('.widget_wcm_calendar_widget .wcm_calendar_events').each(function(index, widget) {
			var $widget = $(widget),
			calendarId = $widget.data('calendarid');

			console.log("WCM Calendar Widget - Getting events for calendar:", calendarId);
			$.post(
				wcm_calendar_settings.ajax_url,
				{
					action: 'wcm_calendar_get_events',
					calendarId: calendarId,
				},
				function(response) {
					if (response.success === true) {
						var events = response.data.events,
							output = "<ul>";

						events.forEach(function(event) {
							var event_start = new Date(event.start);
							var start = event_start.getFullYear() + "-" + (event_start.getMonth()+1) + "-" + event_start.getDate() + " " + event_start.getHours() + ":" + event_start.getMinutes(); // 2018-08-06 09:00

							output += "<li>" + start + " - " + event.summary + " (" + event.location + ")</li>";
						});

						output += "</ul>";
						$widget.html(output);
					}
				}
			);
		});

	});

})( jQuery );
