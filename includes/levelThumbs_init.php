<?php

add_image_size('superlargeImg', levelThumbs_get_options_value('superlarge'));
add_image_size('img_fourthMq', levelThumbs_get_options_value('imgSize_fourthMq'));
add_image_size('img_thirdMq', levelThumbs_get_options_value('imgSize_thirdMq'));
add_image_size('img_secondMq', levelThumbs_get_options_value('imgSize_secondMq'));
add_image_size('img_firstMq', levelThumbs_get_options_value('imgSize_firstMq'));
add_image_size('img_noMq', 480);
add_image_size('img_noMq_half', 160);
add_image_size('img_noMq_third', 110);
add_image_size('img_placeholder', 80);

add_filter('image_size_names_choose', 'levelThumbs_display_image_size_names_muploader', 11, 1);

if(levelThumbs_get_boolean_options_value('srcset_filter') == '1') {
    add_filter('the_content', 'levelThumbs_srcset_the_content_images');
}