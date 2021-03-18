<?php
/**
 * Plugin Name: Test 16
 * Description: Getting course dollar for Course Widget!
 * Author: Zhizhnevskiy
 **/

// Прикрепим функцию к событию 'my_action'
//add_action( 'my_course', 'my_action_course_function' );

// Добавлять новый интервал Cron нужно через фильтр cron_schedules.
add_filter( 'cron_schedules', 'cron_add_two_hours' );
function cron_add_two_hours( $schedules ) {
	$schedules['two_hours'] = array(
		'interval' => 60 * 120,
		'display'  => 'Every two hours'
	);

	return $schedules;
}

// Регистрируем расписание при активации плагина
register_activation_hook( __FILE__, 'activation_geting_course_dollar' );
function activation_geting_course_dollar() {
	wp_clear_scheduled_hook( 'geting_course_dollar' );
	wp_schedule_event( time(), 'two_hours', 'geting_course_dollar' );
}

// Удаляем расписание при деактивации плагина
register_deactivation_hook( __FILE__, 'deactivation_geting_course_dollar' );
function deactivation_geting_course_dollar() {
	wp_clear_scheduled_hook( 'geting_course_dollar' );
}

// Проверка существования расписания во время работы плагина на всякий пожарный случай
if ( ! wp_next_scheduled( 'geting_course_dollar' ) ) {
	wp_schedule_event( time(), 'two_hours', 'geting_course_dollar' );
}

// Хук и функция, которая будет выполняться по Крону
add_action( 'geting_course_dollar', 'get_real_course_dollar' );

function get_real_course_dollar() {

	$USD        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2' );
	$course_USD = json_decode( $USD, true );

	$RUB        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/RUB?parammode=2' );
	$course_RUB = json_decode( $RUB, true );

	$EUR        = file_get_contents( 'https://www.nbrb.by/api/exrates/rates/EUR?parammode=2' );
	$course_EUR = json_decode( $EUR, true );

	global $wpdb;

	$wpdb->insert(
		$wpdb->prefix . 'course', // указываем таблицу
		array( // 'название_колонки' => 'значение'
			'RUB' => $course_RUB['Cur_OfficialRate'],
			'USD' => $course_USD['Cur_OfficialRate'],
			'EUR' => $course_EUR['Cur_OfficialRate']
		)
	);
}

