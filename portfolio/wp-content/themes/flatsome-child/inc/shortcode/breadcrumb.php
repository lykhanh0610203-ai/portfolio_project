<?php
function dynamic_breadcrumb_shortcode()
{
    $breadcrumb = array();
    $delimiter = ' / ';

    // Trang chủ luôn có
    $breadcrumb[] = '<a href="' . home_url() . '">Trang chủ</a>';

    if (is_page()) {
        global $post;
        $ancestors = get_post_ancestors($post);
        $ancestors = array_reverse($ancestors);

        // Lấy các trang cha
        foreach ($ancestors as $ancestor_id) {
            $breadcrumb[] = '<a href="' . get_permalink($ancestor_id) . '">' . get_the_title($ancestor_id) . '</a>';
        }

        // Trang hiện tại
        $breadcrumb[] = '<strong>' . get_the_title($post) . '</strong>';

    } elseif (is_single()) {
        // Nếu là bài viết
        $cat = get_the_category();
        if ($cat && isset($cat[0])) {
            $breadcrumb[] = '<a href="' . get_category_link($cat[0]->term_id) . '">' . $cat[0]->name . '</a>';
        }
        $breadcrumb[] = '<strong>' . get_the_title() . '</strong>';

    } elseif (is_category()) {
        $breadcrumb[] = '<strong>' . single_cat_title('', false) . '</strong>';

    } elseif (is_tag()) {
        $breadcrumb[] = '<strong>Thẻ: ' . single_tag_title('', false) . '</strong>';

    } elseif (is_search()) {
        $breadcrumb[] = '<strong>Kết quả tìm kiếm cho: "' . get_search_query() . '"</strong>';

    } elseif (is_404()) {
        $breadcrumb[] = '<strong>Không tìm thấy trang</strong>';
    }

    return implode($delimiter, $breadcrumb);
}
add_shortcode('dynamic_breadcrumb', 'dynamic_breadcrumb_shortcode');