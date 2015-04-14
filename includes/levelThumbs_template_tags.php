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

function levelThumbs_srcset_image(
$levelThumbs_attachment_id = 'featured',
$alpha_vw = '100vw',
$beta_vw = '50vw',
$charlie_vw = '33vw',
$delta_vw = '33vw',
$echo_vw = '20vw'){

    global $post;

    if ($levelThumbs_attachment_id === 'featured' && function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
        $echoImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'echoImg');
        $deltaImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'deltaImg');
        $charlieImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'charlieImg');
        $betaImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'betaImg');
        $alphaImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'alphaImg');
        $alphaImg_half = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'alphaImg_half');
        $alphaImg_third = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'alphaImg_third');
        $alphaImg_quart = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'alphaImg_quart');
        $title = get_post(get_post_thumbnail_id())->post_title;
        $lT_featured = '';

    } elseif (is_numeric($levelThumbs_attachment_id)) {
        $echoImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'echoImg');
        $deltaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'deltaImg');
        $charlieImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'charlieImg');
        $betaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'betaImg');
        $alphaImg = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg');
        $alphaImg_half = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_half');
        $alphaImg_third = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_third');
        $alphaImg_quart = wp_get_attachment_image_src($levelThumbs_attachment_id, 'alphaImg_quart');
        $title = get_post(get_post_thumbnail_id())->post_title;
        $lT_attached_image = '';
    }

    if (isset($lT_featured) || isset($lT_attached_image)) {
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
    } else {
        echo '<p>Oups! levelThumbs_srcset_image(); first passed value must be the ID of an attached image. No passed values? The function assumes you want the post featured image. Read up on <a href="#">Link</a></p>';
    }
}

/*
function restructure_imgs($content) {
    $doc = new DOMDocument();
    $doc->LoadHTML($content);
    $images = $doc->getElementsByTagName('img');
    $attributes = array('src'=>'data-src', 'width'=>'data-width', 'height'=>'data-height');
    foreach ($images as $image) {
        foreach ($attributes as $key=>$value) {
            // Get the value of the current attributes and set them to variables.
            $$key = $image->getAttribute($key);
            // Remove the existing attributes.
            $image->removeAttribute($key);
            // Set the new attribute.
            $image->setAttribute($value, $$key);
            // Replace existing class with the new fs-img class.
            $image->setAttribute('class', 'fs-img');
        }
        // Add the new noscript node.
        $noscript = $doc->createElement('noscript');
        $noscriptnode = $image->parentNode->insertBefore($noscript, $image);
        // Add the img node to the noscript node.
        $img = $doc->createElement('IMG');
        $newimg = $noscriptnode->appendChild($img);
        $newimg->setAttribute('src', $src);
    }
    return $doc->saveHTML();
}
add_filter('the_content', 'restructure_imgs');


function my_content_filter($content){
    $content = preg_replace('#(<[/]?img.*>)#U', '', $content);
    return $content;
}
add_filter('the_content', 'my_content_filter');



function html5_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt) {

    $html5 = "<figure id='post-$id media-$id' class='figure align$align'>";
    $html5 .= $html;
    if ($caption) {
        $html5 .= "<figcaption>$caption</figcaption>";
    }
    $html5 .= "</figure>";
    return $html5;
}
add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );


function remove_width_attribute( $html ) {
	$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
	return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

*/

function my_add_attachment_location_field( $form_fields, $post ) {
    if(substr($post->post_mime_type, 0, 5) == 'image' ) {
        $field_value = get_post_meta($post->ID, 'location', true);
        $form_fields['location'] = array(
            'value' => $field_value ? $field_value : 'ohamn',
            'label' => __('Location'),
            'helps' => __('Set a location for this attachment')
        );
    }
    return $form_fields;

}
add_filter( 'attachment_fields_to_edit', 'my_add_attachment_location_field', 10, 2 );

function my_save_attachment_location( $attachment_id ) {
    if (isset($_REQUEST['attachments'][$attachment_id]['location']) && substr($post->post_mime_type, 0, 5) == 'image') {
        $location = $_REQUEST['attachments'][$attachment_id]['location'];
        update_post_meta($attachment_id, 'location', $location);
    }
}
add_action( 'edit_attachment', 'my_save_attachment_location' );

function add_responsive_class($content){

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));

    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {
        $existing_class = $img->getAttribute('class');
        $img->setAttribute('class', "lazyload $existing_class");
        $img->setAttribute('data-srcset', 'http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-1440x960.jpeg 1440w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-1280x853.jpeg 1280w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-1024x683.jpeg 1024w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-768x512.jpeg 768w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-480x320.jpeg 480w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-160x107.jpeg 160w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-110x73.jpeg 110w, http://localhost:8888/wp-content/uploads/2015/04/photo-1418225043143-90858d2301b4-80x53.jpeg 80w" sizes="(min-width: 1440px) 20vw, (min-width: 1280px) 33vw, (min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw"');
    }

    $html = $document->saveHTML();
    return $html;
}
add_filter('the_content', 'add_responsive_class');


// https://developer.wordpress.org/reference/hooks/image_send_to_editor/
// http://stv.whtly.com/2010/12/05/wordpress-append-image-dimensions-as-class-names/
// shortcode http://wordpress.stackexchange.com/questions/28673/need-help-building-a-filter-to-edit-the-output-of-image-send-to-editor
// preg_replace? https://wordpress.org/ideas/topic/add-rel-or-class-to-image-links
// hottip! https://codex.wordpress.org/Plugin_API/Filter_Reference/attachment_fields_to_edit + http://code.tutsplus.com/tutorials/creating-custom-fields-for-attachments-in-wordpress--net-13076