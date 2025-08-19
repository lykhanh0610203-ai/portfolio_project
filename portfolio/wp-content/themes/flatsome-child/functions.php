<?php
add_filter('use_widgets_block_editor', '__return_false');
add_filter('use_block_editor_for_post_type', '__return_false');

require_once get_stylesheet_directory() . '/inc/init.php';


function replace_excerpt_ellipsis($excerpt)
{
    return str_replace('[...]', '...', $excerpt);
}
add_filter('the_excerpt', 'replace_excerpt_ellipsis');
add_filter('get_the_excerpt', 'replace_excerpt_ellipsis');

