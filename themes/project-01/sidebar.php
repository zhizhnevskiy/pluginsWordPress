<?php
/**
 * The sidebar containing the main widget area.
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (is_active_sidebar('sidebar')) : ?>

    <aside id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
        <?php dynamic_sidebar('sidebar'); ?>
    </aside>

<?php endif;