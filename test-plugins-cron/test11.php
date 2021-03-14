<?php
/**
 * Plugin Name: Test 11
 * Description: Getting course dollar with Cron!
 * Author: Zhizhnevskiy
 **/

// Добавлять новый интервал Cron нужно через фильтр cron_schedules.
add_filter( 'cron_schedules', 'cron_add_five' );
function cron_add_five( $schedules ) {
    $schedules['five_min'] = array(
        'interval' => 60 * 5,
        'display' => 'Раз в 5 минут'
    );
    return $schedules;
}

// Регистрируем расписание при активации плагина
register_activation_hook(__FILE__, 'activation_geting_course_dollar');
function activation_geting_course_dollar() {
    wp_clear_scheduled_hook( 'geting_course_dollar' );
    wp_schedule_event( time(), 'five_min', 'geting_course_dollar');
}

// Удаляем расписание при деактивации плагина
register_deactivation_hook( __FILE__, 'deactivation_geting_course_dollar');
function deactivation_geting_course_dollar() {
    wp_clear_scheduled_hook('geting_course_dollar');
}

// Проверка существования расписания во время работы плагина на всякий пожарный случай
if( ! wp_next_scheduled( 'geting_course_dollar' ) ) {
    wp_schedule_event( time(), 'five_min', 'geting_course_dollar');
}

// Хук и функция, которая будет выполняться по Крону
add_action( 'geting_course_dollar', 'get_real_course_dollar' );
function get_real_course_dollar(){
    include 'inc/simple_html_dom.php';
    $html = file_get_html( 'https://news.yandex.ru/quotes/1.html' );
    $value = $html->find('.quote_current_yes', 0)->find('.quote__value',0)->plaintext;
    $date = $html->find('.quote_current_yes', 0)->find('.quote__date',0)->plaintext;
    $course = array( 'dollar' => $value, 'date' => $date, 'check' => current_time('mysql',1) );
    update_option( 'i_price_course_dollar', $course, 'no' );
}

// Выводит данные курса
function the_course_dollar( $data = null ){
    echo get_course_dollar( $data );
}

// Возвращает данные курса
function get_course_dollar( $data = null ){
    $course = get_option('i_price_course_dollar');
    if ( !$data || $data == 'dollar') return $course['dollar'];
    if ( $data == 'date') return $course['date'];
    if ( $data == 'check') return $course['check'];
}