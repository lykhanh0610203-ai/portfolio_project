<?php
//Declare all of shortcode
$shortcode_files = glob(get_stylesheet_directory() . '/inc/shortcode/*.php');

foreach ($shortcode_files as $file) {
    require_once $file;
}
