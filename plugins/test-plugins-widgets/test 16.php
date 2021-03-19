<?php
/**
 * Plugin Name: Test 16
 * Description: Getting course dollar for Course Widget!
 * Author: Zhizhnevskiy
 **/

// Add a new Cron interval through the cron_schedules filter
add_filter( 'cron_schedules', 'cron_add_two_hours' );
function cron_add_two_hours( $schedules ) {
	$schedules['two_hours'] = array(
		'interval' => 60 * 120,
		'display'  => 'Every two hours'
	);

	return $schedules;
}

// Registering the schedule when activating the plugin
register_activation_hook( __FILE__, 'activation_geting_course_dollar' );
function activation_geting_course_dollar() {
	wp_clear_scheduled_hook( 'geting_course_dollar' );
	wp_schedule_event( time(), 'two_hours', 'geting_course_dollar' );
}

// Delete the schedule when deactivating the plugin
register_deactivation_hook( __FILE__, 'deactivation_geting_course_dollar' );
function deactivation_geting_course_dollar() {
	wp_clear_scheduled_hook( 'geting_course_dollar' );
}

// Checking the existence of the schedule while the plugin is running, just in case of fire
if ( ! wp_next_scheduled( 'geting_course_dollar' ) ) {
	wp_schedule_event( time(), 'two_hours', 'geting_course_dollar' );
}

// Hook and function to be executed by Cron
add_action( 'geting_course_dollar', 'get_real_course' );

function get_real_course() {

	$USD        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2' );
	$course_USD = json_decode( $USD, true );

	$RUB        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/RUB?parammode=2' );
	$course_RUB = json_decode( $RUB, true );

	$EUR        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/EUR?parammode=2' );
	$course_EUR = json_decode( $EUR, true );

	global $wpdb;

	$wpdb->insert(
		$wpdb->prefix . 'course', // indicate the table
		array( // 'column_name' => 'value'
			'RUB' => $course_RUB['Cur_OfficialRate'],
			'USD' => $course_USD['Cur_OfficialRate'],
			'EUR' => $course_EUR['Cur_OfficialRate']
		)
	);
}