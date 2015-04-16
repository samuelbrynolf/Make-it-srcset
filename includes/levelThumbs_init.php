<?php

add_image_size('echoImg', levelThumbs_get_options_value('echo_query'));
add_image_size('deltaImg', levelThumbs_get_options_value('delta_query'));
add_image_size('charlieImg', levelThumbs_get_options_value('charlie_query'));
add_image_size('betaImg', levelThumbs_get_options_value('beta_query'));
add_image_size('alphaImg', 480);
add_image_size('alphaImg_half', 160);
add_image_size('alphaImg_third', 110);
add_image_size('alphaImg_quart', 80);

function levelThumbs_display_image_size_names_muploader($sizes) {
    $new_sizes = array();
    $added_sizes = get_intermediate_image_sizes();

    foreach( $added_sizes as $key => $value) {
        $new_sizes[$value] = $value;
    }

    $new_sizes = array_merge( $new_sizes, $sizes );
    return $new_sizes;
}
add_filter('image_size_names_choose', 'levelThumbs_display_image_size_names_muploader', 11, 1);

function register_shortcodes(){
    add_shortcode('recent-posts', 'recent_posts_function');
}