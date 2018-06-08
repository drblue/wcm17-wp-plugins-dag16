<?php
/*
Plugin Name: My Star Wars Widget
Description: This plugin adds a widget for displaying various trivia about Star Wars.
Author: Johan Nordström
Version: 0.1
Author URI: http://www.whatsthepoint.se/
*/

require(plugin_dir_path(__FILE__) . '/swapi.php');
require(plugin_dir_path(__FILE__) . '/My_Star_Wars_Widget.php');

function msw_widget_init() {
	register_widget('My_Star_Wars_Widget');
}
add_action('widgets_init', 'msw_widget_init');

function msw_enqueue_scripts() {
	wp_enqueue_script('msw-script', plugin_dir_url(__FILE__) . 'assets/js/msw-script.js', ['jquery'], true);

	wp_localize_script('msw-script', 'msw_script_obj', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'msw_enqueue_scripts');

function msw_ajax_get_people() {
	// get star wars characters from SWAPI
	echo swapi_people();

	// we're done
	wp_die();
}
add_action('wp_ajax_msw_get_people', 'msw_ajax_get_people'); // adds ajax-action msw_get_people when logged in
add_action('wp_ajax_nopriv_msw_get_people', 'msw_ajax_get_people'); // adds ajax-action msw_get_people when NOT logged in
