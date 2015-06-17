<?php

// Add needed image formats ------------------------------------------------------------------

function levelThumbs_imgInit() {
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
    }

    if (function_exists('add_image_size')) {
        add_image_size('img_fatscreen', levelThumbs_get_option_string('imgWidth_fatscreen'));
        add_image_size('img_fourthMq', levelThumbs_get_option_string('imgWidth_fourthMq'));
        add_image_size('img_thirdMq', levelThumbs_get_option_string('imgWidth_thirdMq'));
        add_image_size('img_secondMq', levelThumbs_get_option_string('imgWidth_secondMq'));
        add_image_size('img_firstMq', levelThumbs_get_option_string('imgWidth_firstMq'));
        add_image_size('img_noMq_R', levelThumbs_get_option_string('imgWidth_noMq_R'));
        add_image_size('img_noMq', levelThumbs_get_option_string('imgWidth_noMq'));
    }
}

add_action('after_setup_theme', 'levelThumbs_imgInit');



// Srcset HTML-builder (for shortcodes and add_filter for the_content) / Template tag ------------------------------------------------------------------

function levelThumbs_srcset_image(
$levelThumbs_attachment_id = null, // get_post_thumbnail_id($post->ID)
$srcsetSize_noMq = null,
$srcsetSize_firstMq = null,
$srcsetSize_secondMq = null,
$srcsetSize_thirdMq = null,
$srcsetSize_fourthMq = null,
$levelThumbs_filter_the_content = false){

    // Vars: Set srcset sizes
    $srcsetSize_noMq = (is_null($srcsetSize_noMq)) ? levelThumbs_get_option_string('srcsetSize_noMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_noMq);
    $srcsetSize_firstMq = (is_null($srcsetSize_firstMq)) ? levelThumbs_get_option_string('srcsetSize_firstMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_firstMq);
    $srcsetSize_secondMq = (is_null($srcsetSize_secondMq)) ? levelThumbs_get_option_string('srcsetSize_secondMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_secondMq);
    $srcsetSize_thirdMq = (is_null($srcsetSize_thirdMq)) ? levelThumbs_get_option_string('srcsetSize_thirdMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_thirdMq);
    $srcsetSize_fourthMq = (is_null($srcsetSize_fourthMq)) ? levelThumbs_get_option_string('srcsetSize_fourthMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_fourthMq);

    // Vars: Set imageformats if there is an attachment ID passed, if not give a link to documentation
    if (is_numeric($levelThumbs_attachment_id) && isset($levelThumbs_attachment_id)) {
        $img_fatscreen = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_fatscreen');
        $img_fourthMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_fourthMq');
        $img_thirdMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_thirdMq');
        $img_secondMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_secondMq');
        $img_firstMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_firstMq');
        $img_noMq_R = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_noMq');
        $img_noMq = wp_get_attachment_image_src($levelThumbs_attachment_id, 'img_noMq_half');
        $alt = get_post_meta($levelThumbs_attachment_id, '_wp_attachment_image_alt', true);
    } else {
        echo '<p>Hi! levelThumbs_srcset_image() / [Srcset-image] - shortcode needs the attachment ID for the image you want to show. Read up on <a href="#">Link</a></p>';
        return;
    }

    // Build needed html-strings: Open img tag
    $levelThumbs_openImgTag = '<img class="a-levelThumb_img levelThumb_omitSrc'.(levelThumbs_get_option_boolean('lazyload') ? ' lazyload':'').'"'.($alt ? ' alt="'.$alt.'"' : '').(levelThumbs_get_option_boolean('lazyload') ? ' data-srcset':' srcset').'=';

    if($img_noMq[3]) {

        // Attachment has needed imageformats - use them
        $levelThumbs_srcsetImages =
            $img_fatscreen[0] . ' ' . $img_fatscreen[1] . 'w, ' .
            $img_fourthMq[0] . ' ' . $img_fourthMq[1] . 'w, ' .
            $img_thirdMq[0] . ' ' . $img_thirdMq[1] . 'w, ' .
            $img_secondMq[0] . ' ' . $img_secondMq[1] . 'w, ' .
            $img_firstMq[0] . ' ' . $img_firstMq[1] . 'w, ' .
            $img_noMq_R[0] . ' ' . $img_noMq_R[1] . 'w, ' .
            $img_noMq[0] . ' ' . $img_noMq[1] . 'w';
    } else {

        // Attachment has not needed imageformats (aka uploaded before plugin was active) - use built in wp-formats
        $img_fatscreen = wp_get_attachment_image_src($levelThumbs_attachment_id, 'full');
        $img_defaultLarge = wp_get_attachment_image_src($levelThumbs_attachment_id, 'large');
        $img_defaultMedium = wp_get_attachment_image_src($levelThumbs_attachment_id, 'medium');
        $img_defaultThumb = wp_get_attachment_image_src($levelThumbs_attachment_id, 'thumbnail');

        $levelThumbs_srcsetImages =
            $img_fatscreen[0] . ' ' . $img_fatscreen[1] . 'w, ' .
            $img_defaultLarge[0] . ' ' . $img_defaultLarge[1] . 'w, ' .
            $img_defaultMedium[0] . ' ' . $img_defaultMedium[1] . 'w, ' .
            $img_defaultThumb[0] . ' ' . $img_defaultThumb[1] . 'w';
    }

    // Build needed html-strings: Srcset-sizes and mediaqueries
    $levelThumbs_srcsetSizes = '(min-width: '.$img_fourthMq[1].'px) '.$srcsetSize_fourthMq.'vw, (min-width: '.$img_thirdMq[1].'px) '.$srcsetSize_thirdMq.'vw, (min-width: '.$img_secondMq[1].'px) '.$srcsetSize_secondMq.'vw, (min-width: '.$img_firstMq[1].'px) '.$srcsetSize_firstMq.'vw, '. $srcsetSize_noMq.'vw';

    // Build needed html-strings: Close img
    $levelThumbs_closeImgTag = '/>';

    // Build needed html-strings: Fallback img in noscript-tag
    $levelThumbs_noscriptTag = '<noscript><img class="a-levelThumb_img levelThumb_nojs" src="'.($img_noMq[3] ? $img_secondMq[0] : $img_defaultLarge[0]).'"'.($alt ? ' alt="'.$alt.'"' : '').'/></noscript>';

    // Give two outputs for this function (add_filter for the_content only needs srcset specific attributes)
    if($levelThumbs_filter_the_content) {
        $levelThumbs_srcsetAttributes = array($levelThumbs_srcsetImages, $levelThumbs_srcsetSizes);
        return $levelThumbs_srcsetAttributes;
    } else {
        echo $levelThumbs_openImgTag.'"'.$levelThumbs_srcsetImages.'" sizes="'.$levelThumbs_srcsetSizes.'"'.$levelThumbs_closeImgTag.$levelThumbs_noscriptTag;
    }
}



// Filter the_content with add_filter ------------------------------------------------------------------

if(levelThumbs_get_option_string('wysiwyg') == 'filter') {
    add_filter('the_content', 'levelThumbs_srcset_the_content_images');
}

function levelThumbs_srcset_the_content_images($content){

    // No content? Quit.
    if(!$content){
        return;
    }

    // Build a new DOMDocument and set needed vars
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));
    $imgs = $document->getElementsByTagName("img");

    foreach($imgs as $img){

        // Loop each image in new DOMDocument. Save wp-standard classes, attachment ID to get needed srcset strings. Save those strings.
        $levelThumbs_attachment_classes = $img->getAttribute("class");
        $levelThumbs_attachment_id = preg_replace("/[^0-9]/","",$levelThumbs_attachment_classes);
        $levelThumbs_srcset_html = levelThumbs_srcset_image($levelThumbs_attachment_id, null, null, null, null, null, true);

        // Manipulate images with classes and set srcset-attributes
        $img -> removeAttribute("width");
        $img -> removeAttribute("height");
        if(levelThumbs_get_option_boolean('lazyload')){
            $img->setAttribute("class", "lazyload a-levelThumb_img $levelThumbs_attachment_classes");
            $img->setAttribute("data-srcset", $levelThumbs_srcset_html[0]);
        } else {
            $img->setAttribute("class", "a-levelThumb_img $levelThumbs_attachment_classes");
            $img->setAttribute("srcset", $levelThumbs_srcset_html[0]);
        }
        $img->setAttribute("sizes", $levelThumbs_srcset_html[1]);
    }

    // No need for additional html / body-tags (quick and dirty preg_replace). Save it and set it as document
    $levelThumbs_filtered_html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));

    return $levelThumbs_filtered_html;
}



// Shortcode ------------------------------------------------------------------

if(levelThumbs_get_option_string('wysiwyg') == 'shortcode') {
    add_shortcode('Srcset-image', 'levelThumbs_shortcode');
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