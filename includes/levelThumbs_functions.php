<?php function levelThumbs_srcset_image(
$levelThumbs_attachment_id = null, // get_post_thumbnail_id($post->ID)
$srcsetSize_noMq = null,
$srcsetSize_firstMq = null,
$srcsetSize_secondMq = null,
$srcsetSize_thirdMq = null,
$srcsetSize_fourthMq = null,
$levelThumbs_filter_the_content = false){

    $srcsetSize_noMq = (is_null($srcsetSize_noMq)) ? levelThumbs_get_options_value('srcsetSize_noMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_noMq);
    $srcsetSize_firstMq = (is_null($srcsetSize_firstMq)) ? levelThumbs_get_options_value('srcsetSize_firstMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_firstMq);
    $srcsetSize_secondMq = (is_null($srcsetSize_secondMq)) ? levelThumbs_get_options_value('srcsetSize_secondMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_secondMq);
    $srcsetSize_thirdMq = (is_null($srcsetSize_thirdMq)) ? levelThumbs_get_options_value('srcsetSize_thirdMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_thirdMq);
    $srcsetSize_fourthMq = (is_null($srcsetSize_fourthMq)) ? levelThumbs_get_options_value('srcsetSize_fourthMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_fourthMq);

    if (is_numeric($levelThumbs_attachment_id) && isset($levelThumbs_attachment_id)) {
        $img_fatscreen = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_fatscreen');
        $img_fourthMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_fourthMq');
        $img_thirdMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_thirdMq');
        $img_secondMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_secondMq');
        $img_firstMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_firstMq');
        $img_noMq_R = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_noMq');
        $img_noMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_noMq_half');
        $img_placeholder = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_placeholder');
        $img_fallback_placeholder = wp_get_attachment_image_src($levelThumbs_attachment_id, 'thumbnail');
        $alt = get_post_meta($levelThumbs_attachment_id, '_wp_attachment_image_alt', true);
    } else {
        echo '<p>Oups! levelThumbs_srcset_image(); first passed value must be the ID of an attached image. No passed values? The function assumes you want the post featured image. Read up on <a href="#">Link</a></p>';
        return;
    }

    $levelThumbs_openImgTag = '<img class="a-levelThumb_img'.(levelThumbs_get_boolean_options_value('lazyload') == '1'?' lazyload':'').'" src="'.($img_placeholder[3] === true ? $img_placeholder[0] : $img_fallback_placeholder[0]).'" alt="'.$alt.'" '.(levelThumbs_get_boolean_options_value('lazyload') == '1'?'data-srcset':'srcset').'=';
    if($img_placeholder[3] === true) {
        $levelThumbs_srcsetImages =
            $img_fatscreen[0] . ' ' . $img_fatscreen[1] . 'w, ' .
            $img_fourthMq[0] . ' ' . $img_fourthMq[1] . 'w, ' .
            $img_thirdMq[0] . ' ' . $img_thirdMq[1] . 'w, ' .
            $img_secondMq[0] . ' ' . $img_secondMq[1] . 'w, ' .
            $img_firstMq[0] . ' ' . $img_firstMq[1] . 'w, ' .
            $img_noMq_R[0] . ' ' . $img_noMq_R[1] . 'w, ' .
            $img_noMq[0] . ' ' . $img_noMq[1] . 'w, ' .
            $img_placeholder[0] . ' ' . $img_placeholder[1] . 'w';
    } else {
        $img_fatscreen = wp_get_attachment_image_src($levelThumbs_attachment_id, 'full');
        $img_defaultLarge = wp_get_attachment_image_src($levelThumbs_attachment_id, 'large');
        $img_defaultMedium = wp_get_attachment_image_src($levelThumbs_attachment_id, 'medium');

        $levelThumbs_srcsetImages =
            $img_fatscreen[0] . ' ' . $img_fatscreen[1] . 'w, ' .
            $img_defaultLarge[0] . ' ' . $img_defaultLarge[1] . 'w, ' .
            $img_defaultMedium[0] . ' ' . $img_defaultMedium[1] . 'w, ' .
            $img_fallback_placeholder[0] . ' ' . $img_fallback_placeholder[1] . 'w';
    }
    $levelThumbs_srcsetSizes = '(min-width: '.$img_fourthMq[1].'px) '.$srcsetSize_fourthMq.'vw, (min-width: '.$img_thirdMq[1].'px) '.$srcsetSize_thirdMq.'vw, (min-width: '.$img_secondMq[1].'px) '.$srcsetSize_secondMq.'vw, (min-width: '.$img_firstMq[1].'px) '.$srcsetSize_firstMq.'vw, '. $srcsetSize_noMq.'vw';
    $levelThumbs_closeImgTag = '/>';

    if($levelThumbs_filter_the_content) {
        $levelThumbs_srcsetAttributes = array($levelThumbs_srcsetImages, $levelThumbs_srcsetSizes);
        return $levelThumbs_srcsetAttributes;
    } else {
        echo $levelThumbs_openImgTag.'"'.$levelThumbs_srcsetImages.'" sizes="'.$levelThumbs_srcsetSizes.'"'.$levelThumbs_closeImgTag;
    }
}

function levelThumbs_srcset_the_content_images($content){
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));

    $imgs = $document->getElementsByTagName("img");
    foreach($imgs as $img){
        $levelThumbs_attachment_classes = $img->getAttribute("class");
        $levelThumbs_attachment_id = preg_replace("/[^0-9]/","",$levelThumbs_attachment_classes);
        $levelThumbs_srcset_html = levelThumbs_srcset_image($levelThumbs_attachment_id, null, null, null, null, null, true);

        $img -> removeAttribute("width");
        $img -> removeAttribute("height");
        if(levelThumbs_get_boolean_options_value('lazyload')){
            $img->setAttribute("class", "lazyload a-levelThumb_img $levelThumbs_attachment_classes");
            $img->setAttribute("data-srcset", $levelThumbs_srcset_html[0]);
        } else {
            $img->setAttribute("srcset", $levelThumbs_srcset_html[0]);
        }
        $img->setAttribute("sizes", $levelThumbs_srcset_html[1]);
    }

    $levelThumbs_filtered_html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
    return $levelThumbs_filtered_html;
}

function levelThumbs_shortcode($atts){
    extract(shortcode_atts(
        array(
            'image_id' => null,
            'sc_srcsetSize_noMq' => null,
            'sc_srcsetSize_firstMq' => null,
            'sc_srcsetSize_secondMq' => null,
            'sc_srcsetSize_thirdMq' => null,
            'sc_srcsetSize_fourthMq' => null
        ), $atts));

    $levelThumbs_shortcode_srcset = levelThumbs_srcset_image($image_id, $sc_srcsetSize_noMq, $sc_srcsetSize_firstMq, $sc_srcsetSize_secondMq, $sc_srcsetSize_thirdMq, $sc_srcsetSize_fourthMq);
    return $levelThumbs_shortcode_srcset;
}
add_shortcode( 'Srcset-image', 'levelThumbs_shortcode' );