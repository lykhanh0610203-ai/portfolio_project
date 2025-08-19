<?php
// Shortcode: [mobile_mockup]
function shortcode_mobile_mockup()
{
    // Lấy ID bài viết hiện tại
    $post_id = get_the_ID();
    // Lấy giá trị từ custom field 'anh_san_pham_dang_mobile'
    $mobile_image = get_post_meta($post_id, 'anh_san_pham_dang_mobile', true);

    // Kiểm tra nếu ACF trả về Image ID thay vì URL
    if (is_numeric($mobile_image)) {
        $mobile_image_url = wp_get_attachment_url($mobile_image);
    } else {
        $mobile_image_url = $mobile_image;
    }

    // Nếu không có URL ảnh, sử dụng ảnh mặc định (nếu cần)
    $mobile_image_url = !empty($mobile_image_url) ? esc_url($mobile_image_url) : '';

    // Định nghĩa đường dẫn động cho các ảnh
    $phone_time_url = esc_url(get_theme_file_uri('/assets/img/Group-627850.png')); // Ảnh thanh trạng thái
    $phone_frame_url = esc_url(get_theme_file_uri('/assets/img/mobile.svg')); // Ảnh khung điện thoại
    $mockup_url = esc_url(wp_get_attachment_url(123)); // Thay 123 bằng ID của ảnh mockup trong thư viện media

    // Nếu ảnh mockup không tồn tại, sử dụng đường dẫn mặc định
    $mockup_url = !empty($mockup_url) ? $mockup_url : esc_url(get_theme_file_uri('/assets/img/vecteezy_white-smartphone-mockup-blank-screen-isolated-on-transparent_42538623-1.svg'));

    ob_start();
    ?>
    <div class="mockup_wrapper">
        <div class="screen_content">
            <img class="phone_time" src="<?php echo $phone_time_url; ?>" alt="status bar">
            <img class="phone_frame" src="<?php echo $phone_frame_url; ?>" alt="Phone frame">
            <div class="image_theme">
                <img src="<?php echo $mobile_image_url; ?>" alt="Mobile product image">
            </div>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('mobile_mockup', 'shortcode_mobile_mockup');
?>