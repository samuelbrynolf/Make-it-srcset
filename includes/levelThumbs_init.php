<?php

add_image_size('echoImg', levelThumbs_get_options_value('echo_query'));
add_image_size('deltaImg', levelThumbs_get_options_value('delta_query'));
add_image_size('charlieImg', levelThumbs_get_options_value('charlie_query'));
add_image_size('betaImg', levelThumbs_get_options_value('beta_query'));
add_image_size('alphaImg', 480);
add_image_size('alphaImg_half', 160);
add_image_size('alphaImg_third', 110);
add_image_size('alphaImg_quart', 80);

add_filter('image_size_names_choose', 'levelThumbs_display_image_size_names_muploader', 11, 1);

if(levelThumbs_get_boolean_options_value('srcset_filter') == '1') {
    add_filter('the_content', 'levelThumbs_srcset_the_content_images');
}