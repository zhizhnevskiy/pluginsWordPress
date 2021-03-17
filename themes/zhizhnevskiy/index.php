<?php
/**
 * The main template file
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

// циклы вывода записей
// если записи найдены
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';

		echo get_the_excerpt();
	}
} // если записей не найдено
else {
	echo ' <p>Записей нет...</p>';
}

get_sidebar();

get_footer();
