<?php

// Add async attributes to mis_enqueue_scripts-files ------------------------------------------------------------------

function mis_async_forscript($url){
    if (strpos($url, '#mis_asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#mis_asyncload', '', $url);
    else
        return str_replace('#mis_asyncload', '', $url)."' async='async";
}

// Add needed image formats ------------------------------------------------------------------

function mis_imageInit() {
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
    }

    if (function_exists('add_image_size')) {
        add_image_size('mis_imgSize_fatscreen', mis_get_option_integer('mis_imgWidth_fatscreen'));
        add_image_size('mis_imgSize_fourthMq', mis_get_option_integer('mis_imgWidth_fourthMq'));
        add_image_size('mis_imgSize_thirdMq', mis_get_option_integer('mis_imgWidth_thirdMq'));
        add_image_size('mis_imgSize_secondMq', mis_get_option_integer('mis_imgWidth_secondMq'));
        add_image_size('mis_imgSize_firstMq', mis_get_option_integer('mis_imgWidth_firstMq'));
        add_image_size('mis_imgSize_noMq_R', mis_get_option_integer('mis_imgWidth_noMq_R'));
        add_image_size('mis_imgSize_noMq', mis_get_option_integer('mis_imgWidth_noMq'));
    }
}

add_action('after_setup_theme', 'mis_imageInit');



// Srcset HTML-builder (for shortcodes and add_filter for the_content) / Template tag ------------------------------------------------------------------

function makeitSrcset(
$mis_attachment_id = null, // get_post_thumbnail_id($post->ID)
$srcsetSize_noMq = null,
$srcsetSize_firstMq = null,
$srcsetSize_secondMq = null,
$srcsetSize_thirdMq = null,
$srcsetSize_fourthMq = null,
$cssClass = null,
$figcaption = null,
$mis_filter_the_content = false){

    // Vars: Set srcset sizes
    $srcsetSize_noMq = (is_null($srcsetSize_noMq)) ? mis_get_option_integer('mis_srcsetSize_noMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_noMq);
    $srcsetSize_firstMq = (is_null($srcsetSize_firstMq)) ? mis_get_option_integer('mis_srcsetSize_firstMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_firstMq);
    $srcsetSize_secondMq = (is_null($srcsetSize_secondMq)) ? mis_get_option_integer('mis_srcsetSize_secondMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_secondMq);
    $srcsetSize_thirdMq = (is_null($srcsetSize_thirdMq)) ? mis_get_option_integer('mis_srcsetSize_thirdMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_thirdMq);
    $srcsetSize_fourthMq = (is_null($srcsetSize_fourthMq)) ? mis_get_option_integer('mis_srcsetSize_fourthMq') : preg_replace('/[^0-9]+/', '', $srcsetSize_fourthMq);

    // Vars: Set imageformats IF there is an attachment ID passed as an integer and if that attachment is an image. If not give a link to documentation
    if (is_numeric($mis_attachment_id) && isset($mis_attachment_id) && wp_attachment_is_image($mis_attachment_id)) {
        $mis_imgSize_fatscreen = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_fatscreen');
        $mis_imgSize_fourthMq = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_fourthMq');
        $mis_imgSize_thirdMq = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_thirdMq');
        $mis_imgSize_secondMq = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_secondMq');
        $mis_imgSize_firstMq = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_firstMq');
        $mis_imgSize_noMq_R = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_noMq_R');
        $mis_imgSize_noMq = wp_get_attachment_image_src($mis_attachment_id, 'mis_imgSize_noMq');
        $alt = get_post_meta($mis_attachment_id, '_wp_attachment_image_alt', true);
        $filename = get_post_meta($mis_attachment_id, '_wp_attached_file', true);

    } else {
        echo '<p>Hi! makeitSrcset() / [Srcset-image] - shortcode needs the attachment-ID for the image you want to show. Read up on <a href="#">Link</a></p>';
        return;
    }

    // Var: Css-classes for srcset parent element
    $mis_imgParent_cssClass = (is_null($cssClass) ? '' : ' '.$cssClass);

    // Var: Parent container tag (if figcaption exists make it a figure-element)
    if(is_null($figcaption)){
        $mis_containerTag = '<div class="levelThumb_container levelThumb_div'.$mis_imgParent_cssClass.'">';
    } else {
        $mis_containerTag = '<figure class="levelThumb_container levelThumb_figure'.$mis_imgParent_cssClass.'">';
    }

    // Var: Img tag
    $mis_imgTag = '<img class="levelThumb_img levelThumb_omitSrc'.(mis_get_option_boolean('lazyload') ? ' lazyload' : '').'"'.($alt ? ' alt="'.$alt.'"' : ' alt="'.$filename.'"').(mis_get_option_boolean('lazyload') ? ' data-srcset':' srcset').'=';

    if($mis_imgSize_noMq[3]) {

        // Do attachment has needed imageformats? Use them
        $mis_srcsetImages =
            $mis_imgSize_fatscreen[0] . ' ' . $mis_imgSize_fatscreen[1] . 'w, ' .
            $mis_imgSize_fourthMq[0] . ' ' . $mis_imgSize_fourthMq[1] . 'w, ' .
            $mis_imgSize_thirdMq[0] . ' ' . $mis_imgSize_thirdMq[1] . 'w, ' .
            $mis_imgSize_secondMq[0] . ' ' . $mis_imgSize_secondMq[1] . 'w, ' .
            $mis_imgSize_firstMq[0] . ' ' . $mis_imgSize_firstMq[1] . 'w, ' .
            $mis_imgSize_noMq_R[0] . ' ' . $mis_imgSize_noMq_R[1] . 'w, ' .
            $mis_imgSize_noMq[0] . ' ' . $mis_imgSize_noMq[1] . 'w';

    } else {

        // Attachment has not needed imageformats (aka uploaded before plugin was active) - use built in wp-formats
        $mis_imgSize_fatscreen = wp_get_attachment_image_src($mis_attachment_id, 'full');
        $mis_img_defaultLarge = wp_get_attachment_image_src($mis_attachment_id, 'large');
        $mis_img_defaultMedium = wp_get_attachment_image_src($mis_attachment_id, 'medium');
        $mis_img_defaultThumb = wp_get_attachment_image_src($mis_attachment_id, 'thumbnail');

        $mis_srcsetImages =
            $mis_imgSize_fatscreen[0] . ' ' . $mis_imgSize_fatscreen[1] . 'w, ' .
            $mis_img_defaultLarge[0] . ' ' . $mis_img_defaultLarge[1] . 'w, ' .
            $mis_img_defaultMedium[0] . ' ' . $mis_img_defaultMedium[1] . 'w, ' .
            $mis_img_defaultThumb[0] . ' ' . $mis_img_defaultThumb[1] . 'w';
    }

    // Var: Srcset-sizes and Srcset-mediaqueries
    $mis_srcsetSizes = '(min-width: '.$mis_imgSize_fourthMq[1].'px) '.$srcsetSize_fourthMq.'vw, (min-width: '.$mis_imgSize_thirdMq[1].'px) '.$srcsetSize_thirdMq.'vw, (min-width: '.$mis_imgSize_secondMq[1].'px) '.$srcsetSize_secondMq.'vw, (min-width: '.$mis_imgSize_firstMq[1].'px) '.$srcsetSize_firstMq.'vw, '. $srcsetSize_noMq.'vw';

    // Var: Endtag img
    $mis_closeImgTag = '/>';

    // Var: Fallback img in noscript-tag
    $mis_noscriptTag = '<noscript><img class="levelThumb_img levelThumb_nojs" src="'.($mis_imgSize_noMq[3] ? $mis_imgSize_secondMq[0] : $mis_img_defaultLarge[0]).'"'.($alt ? ' alt="'.$alt.'"' : '').'/></noscript>';

    // Var: Figcaption
    if(is_null($figcaption)) {
        $mis_figcaptionTag = '';
    } else {
        $mis_figcaptionTag = '<figcaption class="levelThumb_figcaption">'.$figcaption.'</figcaption>';
    }

    // Var: Endtag parent container
    if(is_null($figcaption)) {
        $mis_closeImgContainer = '</div>';
    } else {
        $mis_closeImgContainer = '</figure>';
    }

    // BUILD HTML
    if($mis_filter_the_content) {
        // Return only srcset attributes in array needed by the_content filter
        $mis_srcsetAttributes = array($mis_srcsetImages, $mis_srcsetSizes);
        return $mis_srcsetAttributes;
    } else {
        // Build HTML for template tag and shortcode
        echo $mis_containerTag.$mis_imgTag.'"'.$mis_srcsetImages.'" sizes="'.$mis_srcsetSizes.'"'.$mis_closeImgTag.$mis_noscriptTag.$mis_figcaptionTag.$mis_closeImgContainer;
    }
}



// Filter the_content with add_filter ------------------------------------------------------------------

if(mis_get_option_boolean('mis_contentFilter')){
    add_filter('the_content', 'mis_wysiwyg_filter');
}

function mis_wysiwyg_filter($content){

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
        $mis_attachment_classes = $img->getAttribute("class");
        $mis_attachment_id = preg_replace("/[^0-9]/","",$mis_attachment_classes);
        $mis_srcset_attr_array = makeitSrcset($mis_attachment_id, null, null, null, null, null, null, null, true);

        // Manipulate images with classes and set srcset-attributes
        $img -> removeAttribute("width");
        $img -> removeAttribute("height");
        if(mis_get_option_boolean('lazyload')){
            $img->setAttribute("class", "lazyload levelThumb_img levelThumb_filtered $mis_attachment_classes");
            $img->setAttribute("data-srcset", $mis_srcset_attr_array[0]);
        } else {
            $img->setAttribute("class", "levelThumb_img levelThumb_filtered $mis_attachment_classes");
            $img->setAttribute("srcset", $mis_srcset_attr_array[0]);
        }
        $img->setAttribute("sizes", $mis_srcset_attr_array[1]);
    }

    // No need for additional html / body-tags (quick and dirty preg_replace). Save it and set it as document
    $mis_filtered_html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
    return $mis_filtered_html;
}



// Shortcode ------------------------------------------------------------------

add_shortcode('Srcset-image', 'mis_shortcode');

function mis_shortcode($atts){
    extract(shortcode_atts(
        array(
            'image_id' => null,
            'srcsetSize_noMq' => null,
            'srcsetSize_firstMq' => null,
            'srcsetSize_secondMq' => null,
            'srcsetSize_thirdMq' => null,
            'srcsetSize_fourthMq' => null,
            'parent_css_class' => null,
            'figcaption' => null
        ), $atts));

    // https://wordpress.org/support/topic/plugin-called-via-shortcode-appears-at-the-wrong-place-on-post?replies=5

    ob_start();
        makeitSrcset($image_id, $srcsetSize_noMq, $srcsetSize_firstMq, $srcsetSize_secondMq, $srcsetSize_thirdMq, $srcsetSize_fourthMq, $parent_css_class, $figcaption);
        $mis_shortcode = ob_get_contents();
    ob_end_clean();

    if(mis_get_option_boolean('mis_shortcode')) {
        return $mis_shortcode;
    }
}



// Prevent duplicate images for browsers that support Srcset but have javascript turned off --------------------------

if(mis_get_option_boolean('mis_preventDuplicates')){
    add_action('wp_head','mis_nojs_style');
}

function mis_nojs_style(){
    $output="<style> .no-mis_enqueue_scripts .levelThumb_img.levelThumb_omitSrc{ display: none;} </style>";
    echo $output;
}