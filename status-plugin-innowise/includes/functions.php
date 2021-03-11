<?php
/*
 * Добавляю новое меню в Админ Консоль
 */

// Хук событие 'admin_menu', запускаю функцию 'Add_My_Admin_Link()'
add_action('admin_menu', 'Add_My_Admin_Link');
add_filter( 'rwmb_meta_boxes', 'prefix_meta_boxes' );

// Добавляю новую ссылку в меню Админ Консоли
function Add_My_Admin_Link()
{
    add_menu_page(
        'Page', // Название страниц (Title)
        'Status Page', // Текст ссылки в меню
        'manage_options', // Требование к возможности видеть ссылку
        'status-plugin-innowise/includes/page-status.php' // 'slug' - файл отобразится по нажатию на ссылку
    );
}

function prefix_meta_boxes( $meta_boxes ) {

    $meta_boxes[] = array(
        'title'  => 'Test Meta Box',
        'fields' => array(
            array(
                'id'   => 'name',
                'name' => 'Name',
                'type' => 'text',
            ),
            array(
                'id'      => 'gender',
                'name'    => 'Gender',
                'type'    => 'radio',
                'options' => array(
                    'm' => 'Male',
                    'f' => 'Female',
                ),
            ),
            array(
                'id'   => 'email',
                'name' => 'Email',
                'type' => 'email',
            ),
            array(
                'id'   => 'bio',
                'name' => 'Biography',
                'type' => 'textarea',
            ),
        ),
    );

    return $meta_boxes;
}