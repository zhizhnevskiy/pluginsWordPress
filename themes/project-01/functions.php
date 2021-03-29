<?php
/**
 * Functions and definitions
 */

// This function queues the Normalize.css file for use
// The first parameter is the name of the stylesheet, the second is the URL
// Here we are using the online version of the css file

function add_normalize_CSS() {
    wp_enqueue_style( 'normalize-styles', "https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css");
}

// Add menus
add_theme_support('menus');

// Registering Menu Display Areas
add_action('init', 'add_Main_Nav');

function add_Main_Nav()
{
    register_nav_menus(
        array( // id area => area name
            'header_menu' => 'Header menu'
        )
    );
}

// add sidebar
add_action('widgets_init', 'add_widget_Support');

function add_widget_Support()
{
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}