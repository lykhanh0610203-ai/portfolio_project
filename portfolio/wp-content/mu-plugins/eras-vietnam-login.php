<?php
/*
Plugin Name: Eras Log in page Plugin
Description: Thay thế wp-login.php bằng một file tùy chỉnh.
Version: 1.0
Author: DFK
*/

function my_mu_plugin_setup() {
    if (get_locale() === 'vi') {
        load_textdomain('eras-vietnam', WP_CONTENT_DIR . '/mu-plugins/include/language/vi.mo');
    }
}
add_action('init', 'my_mu_plugin_setup');


function custom_login_override() {
    // Đường dẫn đến file wp-login-custom.php trong thư mục mu-plugins
    $custom_login_file_mu_plugins_from = WP_CONTENT_DIR . '/mu-plugins/include/wp-login-custom.php';
    
    // Đường dẫn đến thư mục plugins
    $custom_login_file_plugins_to = ABSPATH . '/wp-login.php';

    // Sao chép file nếu nó chưa tồn tại trong thư mục plugins
    if (file_exists($custom_login_file_mu_plugins_from)) {
        copy($custom_login_file_mu_plugins_from, $custom_login_file_plugins_to);
    }  
}
add_action('init', 'custom_login_override');