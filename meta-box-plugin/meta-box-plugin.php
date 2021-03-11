<?php
/**
 * Plugin Name: Meta Box
 * Description: Добавляем Meta Box
 **/

## Добавляем блоки в основную колонку на страницах постов и пост. страниц
add_action('add_meta_boxes', 'status_meta_box');
function status_meta_box()
{
    $screens = array('post', 'page');
    add_meta_box('myplugin_sectionid', 'Page Status', 'meta_box_callback', $screens);
}

// HTML код блока
function meta_box_callback($post, $meta)
{
    $screens = $meta['args'];

    // Используем nonce для верификации
    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    // значение поля
    $value = get_post_meta($post->ID, 'my_meta_key', 1);

    // Поля формы для введения данных
    //echo '<label for="myplugin_new_field">' . __("Description for this field", 'myplugin_textdomain') . '</label> ';
    //echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . $value . '" size="25" />';
    ?>
    <form  action="functions.php">
        <p>Please select your status page:</p>
        <div>
            <input type="radio" id="myplugin_new_field" name="myplugin_new_field" value="open">
            <label for="myplugin_new_field">Open</label>
            <br><br>
            <input type="radio" id="myplugin_new_field" name="myplugin_new_field" value="personal">
            <label for="myplugin_new_field">Personal</label>
            <br><br>
            <input type="radio" id="myplugin_new_field" name="myplugin_new_field" value="password protected">
            <label for="myplugin_new_field">Password protected</label>
            <br><br>
        </div>
    </form>
<?php
}

## Сохраняем данные, когда пост сохраняется
add_action('save_post', 'myplugin_save_postdata');
function myplugin_save_postdata($post_id)
{
    // Убедимся что поле установлено.
    if (!isset($_POST['myplugin_new_field']))
        return;

    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if (!wp_verify_nonce($_POST['myplugin_noncename'], plugin_basename(__FILE__)))
        return;

    // если это автосохранение ничего не делаем
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // проверяем права юзера
    if (!current_user_can('edit_post', $post_id))
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $my_data = sanitize_text_field($_POST['myplugin_new_field']);

    // Обновляем данные в базе данных.
    update_post_meta($post_id, 'my_meta_key', $my_data);
}