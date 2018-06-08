<?php

function swapi_films() {
	$response = wp_remote_get('https://swapi.co/api/films/');
	$output = "";

	if ($response['response']['code'] === 200) {
		// all ok
		$body = json_decode($response['body']);

		$output .= "<ul>";

		/**
		 * sort films based on episode_id
		 */
		$films = $body->results;
		$episodes = array_map(function($film) {
			return $film->episode_id;
		}, $films);

		array_multisort($episodes, SORT_NUMERIC, $films);

		// loop through all results
		foreach ($films as $film) {
			$output .= "<li>{$film->title} <i>{$film->release_date}</i></li>";
		}
		$output .= "</ul>";

	} else {
		$output .= "Something went very wrong, didn't get OK back from query.";
	}

	return $output;
}

function swapi_people() {
	$output = get_transient('swapi_people_output');
	if ($output !== false) {
		return $output;
	}

	$output = "<ul>";

	$response = wp_remote_get('https://swapi.co/api/people/');
	$result = swapi_people_decode($response);
	$output .= $result['output'];

	while ($result['next'] !== null) {
		$response = wp_remote_get($result['next']);
		$result = swapi_people_decode($response);
		$output .= $result['output'];
	}
	$output .= "</ul>";

	set_transient('swapi_people_output', $output, 2 * WEEK_IN_SECONDS);
	return $output;
}

function swapi_people_decode($response) {
	$output = "";

	if ($response['response']['code'] === 200) {
		// all ok
		$body = json_decode($response['body']);

		// loop through all results
		foreach ($body->results as $person) {
			$output .= "<li>{$person->name} <i>{$person->birth_year}</i>";

			$starship_count = count($person->starships);
			if ($starship_count > 0) {
				// $output .= " ({$starship_count} " . pluralize($starship_count, 1, 'starship', 'starships') . ")";
				$output .= " ({$starship_count} " . pluralize_many($starship_count, [1 => 'starship', 2 => 'starships', 5 => 'too many']) . ")";
			}
			$output .= "</li>";
		}

	} else {
		$output .= "Something went very wrong, didn't get OK back from query.";
	}

	$result = [
		'output' => $output,
		'next' => $body->next,
	];

	return $result;
}


function pluralize($count, $plural_break, $singular, $plural) {
	if ($count > $plural_break) {
		return $plural;
	} else {
		return $singular;
	}
}

function pluralize_many($count, $strings) {
	$desc = array_reverse($strings);
	foreach ($desc as $val => $string) {
		if ($count >= $val) {
			return $string;
		}
	}

	return;
}
