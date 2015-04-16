<?php function levelThumbs_srcset_image(
$levelThumbs_attachment_id = '', // get_post_thumbnail_id($post->ID)
$alpha_vw = '100vw',
$beta_vw = '50vw',
$charlie_vw = '33vw',
$delta_vw = '33vw',
$echo_vw = '20vw',
$levelThumbs_filter_the_content = false){

    if (is_numeric($levelThumbs_attachment_id) && isset($levelThumbs_attachment_id)) {
        $echoImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'echoImg');
        $deltaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'deltaImg');
        $charlieImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'charlieImg');
        $betaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'betaImg');
        $alphaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg');
        $alphaImg_half = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_half');
        $alphaImg_third = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_third');
        $alphaImg_quart = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_quart');
        $title = get_post(get_post_thumbnail_id())->post_title;
    } else {
        echo '<p>Oups! levelThumbs_srcset_image(); first passed value must be the ID of an attached image. No passed values? The function assumes you want the post featured image. Read up on <a href="#">Link</a></p>';
        return;
    }

    $levelThumbs_openImgTag = '<img class="a-levelThumb_img'.(levelThumbs_get_boolean_options_value('lazyload') == '1'?' lazyload':'').'" src="'.$alphaImg_quart[0].'" alt="'.$title.'"'.(levelThumbs_get_boolean_options_value('lazyload') == '1'?' data-srcset':'srcset').'=';
    $levelThumbs_srcSetValues =
        $echoImg[0].' '.$echoImg[1].'w, '.
        $deltaImg[0].' '.$deltaImg[1].'w, '.
        $charlieImg[0].' '.$charlieImg[1].'w, '.
        $betaImg[0].' '.$betaImg[1].'w, '.
        $alphaImg[0].' '.$alphaImg[1].'w, '.
        $alphaImg_half[0].' '.$alphaImg_half[1].'w, '.
        $alphaImg_third[0].' '.$alphaImg_third[1].'w, '.
        $alphaImg_quart[0].' '.$alphaImg_quart[1].'w"'.
        ' sizes="(min-width: '.$echoImg[1].'px) '.$echo_vw.', (min-width: '.$deltaImg[1].'px) '.$delta_vw.', (min-width: '.$charlieImg[1].'px) '.$charlie_vw.', (min-width: '.$betaImg[1].'px) '.$beta_vw.', '. $alpha_vw;
    $levelThumbs_closeImgTag = '/>';

    if($levelThumbs_filter_the_content) {
        return $levelThumbs_srcSetValues;
    } else {
        echo $levelThumbs_openImgTag . '"'.$levelThumbs_srcSetValues.'"' . $levelThumbs_closeImgTag;
    }
}

function add_responsive_class($content){

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));

    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {
        $levelThumbs_attachment_classes = $img->getAttribute('class');
        $levelThumbs_attachment_id = preg_replace("/[^0-9]/","",$levelThumbs_attachment_classes);
        $levelThumbs_srcSet_html = levelThumbs_srcset_image($levelThumbs_attachment_id, '1vw', '40vw', '1vw', '40vw', '1vw', true);

        $img -> removeAttribute("width");
        $img -> removeAttribute("height");
        if(levelThumbs_get_boolean_options_value('lazyload')){
            $img->setAttribute("class", "lazyload $levelThumbs_attachment_classes");
            $img->setAttribute("data-srcset", $levelThumbs_srcSet_html);
        } else {
            $img->setAttribute("srcset", $levelThumbs_srcSet_html);
        }

    }

    $levelThumbs_filtered_html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
    return $levelThumbs_filtered_html;
}
add_filter('the_content', 'add_responsive_class');


// https://developer.wordpress.org/reference/hooks/image_send_to_editor/
// http://stv.whtly.com/2010/12/05/wordpress-append-image-dimensions-as-class-names/
// shortcode http://wordpress.stackexchange.com/questions/28673/need-help-building-a-filter-to-edit-the-output-of-image-send-to-editor
// preg_replace? https://wordpress.org/ideas/topic/add-rel-or-class-to-image-links
// hottip! https://codex.wordpress.org/Plugin_API/Filter_Reference/attachment_fields_to_edit + http://code.tutsplus.com/tutorials/creating-custom-fields-for-attachments-in-wordpress--net-13076