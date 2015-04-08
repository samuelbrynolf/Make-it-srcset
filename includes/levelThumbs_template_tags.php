<?php function levelThumbs_srcset_thumbnail(
    $alpha_vw = '100vw',
    $beta_vw = '50vw',
    $charlie_vw = '33vw',
    $delta_vw = '33vw',
    $echo_vw = '20vw'
    ) {

    global $post;

    if (function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
        $echoImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'echoImg');
        $deltaImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'deltaImg');
        $charlieImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'charlieImg');
        $betaImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'betaImg');
        $alphaImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'alphaImg');
        $alphaImg_half = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'alphaImg_half');
        $alphaImg_third = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'alphaImg_third');
        $alphaImg_quart = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'alphaImg_quart');
        $title = get_post(get_post_thumbnail_id())->post_title;

        echo '<img src="'.$alphaImg_quart[0].'"'.(levelThumbs_get_boolean_options_value('lazyload') == '1'?' data-srcset':'srcset').'="'.
            $echoImg[0].' '.$echoImg[1].'w, '.
            $deltaImg[0].' '.$deltaImg[1].'w, '.
            $charlieImg[0].' '.$charlieImg[1].'w, '.
            $betaImg[0].' '.$betaImg[1].'w, '.
            $alphaImg[0].' '.$alphaImg[1].'w, '.
            $alphaImg_half[0].' '.$alphaImg_half[1].'w, '.
            $alphaImg_third[0].' '.$alphaImg_third[1].'w, '.
            $alphaImg_quart[0].' '.$alphaImg_quart[1].'w"'.
            ' sizes="(min-width: '.$echoImg[1].'px) '.$echo_vw.', (min-width: '.$deltaImg[1].'px) '.$delta_vw.', (min-width: '.$charlieImg[1].'px) '.$charlie_vw.', (min-width: '.$betaImg[1].'px) '.$beta_vw.', '. $alpha_vw.'" alt="'.$title.'" class="a-levelThumb_img'.(levelThumbs_get_boolean_options_value('lazyload') == '1'?' lazyload':'').'"/>';
    }
}