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
				function(data) {
					console.log("WCM Calendar Widget - Succesfully got events back from Wordpress:", data);
				}
			);
		});

	});

})( jQuery );
