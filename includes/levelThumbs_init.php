<?php function levelThumbs_imgInit() {
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
    }

    if (function_exists('add_image_size')) {
        add_image_size('img_fatscreen', levelThumbs_get_options_value('imgWidth_fatscreen'));
        add_image_size('img_fourthMq', levelThumbs_get_options_value('imgWidth_fourthMq'));
        add_image_size('img_thirdMq', levelThumbs_get_options_value('imgWidth_thirdMq'));
        add_image_size('img_secondMq', levelThumbs_get_options_value('imgWidth_secondMq'));
        add_image_size('img_firstMq', levelThumbs_get_options_value('imgWidth_firstMq'));
        add_image_size('img_noMq_R', levelThumbs_get_options_value('imgWidth_noMq_R'));
        add_image_size('img_noMq', levelThumbs_get_options_value('imgWidth_noMq'));
        add_image_size('img_placeholder', 80);
    }
}

add_action('after_setup_theme', 'levelThumbs_imgInit');

if(levelThumbs_get_boolean_options_value('srcset_filter')) {

    function levelThumbs_placeholderOption($sizes) {
        return array_merge( $sizes, array(
            'img_placeholder' => __('Srcset placeholder'),
        ));
    }

    add_filter('image_size_names_choose', 'levelThumbs_placeholderOption');
    add_filter('the_content', 'levelThumbs_srcset_the_content_images');
}