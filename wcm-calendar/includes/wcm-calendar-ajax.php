<?php

require_once(dirname(__FILE__) . '/../.secret.php');
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

// respond to ajax-request for action 'wcm_calendar_get_events'
function ajax_get_events() {
	$calendarId = $_POST['calendarId'];

	// create Google API Client
	$client = new Google_Client();
	$client->setApplicationName("WCM Calendar WordPress Plugin");
	$client->setDeveloperKey(GOOGLE_API_KEY);

	$service = new Google_Service_Calendar($client);
	$events = $service->events->listEvents($calendarId);

	var_dump($events);
	die();

	wp_send_json_success(['calendarId' => $calendarId]);
}
add_action('wp_ajax_wcm_calendar_get_events', 'ajax_get_events');  // for logged in users
add_action('wp_ajax_nopriv_wcm_calendar_get_events', 'ajax_get_events'); // for normal users
