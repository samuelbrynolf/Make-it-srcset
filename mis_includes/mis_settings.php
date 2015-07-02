<?php function mis_main_tab() {
	add_plugins_page(
		'Make it Srcset',
		'Make it Srcset',
		'manage_options',
		'levelThumbs_plugin_options',
		'mis_plugin_menu'
	);
}
add_action('admin_menu', 'mis_main_tab');

function mis_plugin_menu($active_tab = '') { ?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e('Level my postthumbs — Settings', 'levelThumbs'); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields('levelThumbs_plugin_options');
			do_settings_sections('levelThumbs_plugin_options');
			submit_button(); ?>
		</form>
	</div>
<?php }

// --------------------------------------------------------------------------------------------------------------------------------

function mis_plugin_default_options() {
	$defaults = array(
        'imgWidth_noMq'  => '320',
		'imgWidth_noMq_R'  => '480',
		'imgWidth_firstMq'  => '768',
		'imgWidth_secondMq'  => '1024',
		'imgWidth_thirdMq'  => '1280',
		'imgWidth_fourthMq'  => '1440',
        'imgWidth_fatscreen' => '1680',
        'srcsetSize_noMq' => '100',
        'srcsetSize_firstMq' => '100',
        'srcsetSize_secondMq' => '100',
        'srcsetSize_thirdMq' => '100',
        'srcsetSize_fourthMq' => '100',
        'wysiwyg' => 'Do not srcset them',
        'userpathPicturefill' => '',
        'userpathLazyload' => ''
	);
	return apply_filters( 'mis_plugin_default_options', $defaults );
}

// -----------------------------------------------------------------------------------------------------------------------------

function mis_plugin_initialize_options() {
	if(false == get_option('levelThumbs_plugin_options')) {
		add_option('levelThumbs_plugin_options', apply_filters('mis_plugin_default_options', mis_plugin_default_options()));
	}

    // Settings section for mediaqueries -------------------------------------------------------------------------------------------------------------------------

	add_settings_section(
		'levelThumbs_mediaqueries',
		__('Themes layout mediaqueries', 'levelThumbs'),
		'mis_mediaqueries_callback',
		'levelThumbs_plugin_options'
	);

	add_settings_field(
		'imgWidth_firstMq',
		'First breakpoint:',
		'mis_imgSizeFirstMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_secondMq',
		'Second breakpoint:',
		'mis_imgSizeSecondMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_thirdMq',
		'Third breakpoint:',
		'mis_imgSizeThirdMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_fourthMq',
		'Fourth breakpoint:',
		'mis_imgSizeFourthMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

    // Settings section for image sizes -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_imagewidths',
        __('Image widths &mdash; not targeted by any mediaquery', 'levelThumbs'),
        'mis_imagewidths_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'imgWidth_noMq',
        'Lores image width:',
        'mis_imgWidth_noMq_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );

    add_settings_field(
        'imgWidth_noMq_R',
        'Hires/retina image width:',
        'mis_imgWidth_noMq_R_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );

    add_settings_field(
        'imgWidth_fatscreen',
        'Fatest targeted screensize:',
        'mis_imgWidth_fatscreen_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );
    
    // Settings section for srcset-sizes -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_srcsetSizes',
        __('Srcset size per mediaquery', 'levelThumbs'),
        'mis_srcsetSizes_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'srcsetSize_noMq',
        'Non-mq-targeted image size:',
        'mis_srcsetsize_one_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_firstMq',
        'First breakpoint &mdash; image size:',
        'mis_srcsetsize_two_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_secondMq',
        'Second breakpoint &mdash; image size:',
        'mis_srcsetsize_three_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_thirdMq',
        'Third breakpoint &mdash; image size:',
        'mis_srcsetsize_four_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_fourthMq',
        'Fourth breakpoint &mdash; image size:',
        'mis_srcsetsize_five_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    // Settings section for images pulled by WYSIWYG-editor

    add_settings_section(
        'levelThumbs_wysiwyg',
        __('Handle images pulled by the WYSIWYG-editor', 'levelThumbs'),
        'mis_wysiwyg_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'contentFilter',
        'Enable filter:',
        'mis_contentFilter_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Filter expl', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'shortcode',
        'Enable shortcode:',
        'mis_shortcode_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Shortcode expl', 'levelThumbs' ),
        )
    );

    // Settings section for JS-libraries -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_jslib',
        __('Javascript: Picturefill & Lazyload', 'levelThumbs'),
        'mis_jslib_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'picturefill',
        'Enable Picturefill:',
        'mis_picturefill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Provide a wider support for custom template tags that uses srcset, with Picturefill v2.3.1.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'userpathPicturefill',
        'Replace Picturefill v2.3.1:',
        'mis_userpathPicturefill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Replace Picturefill v2.3.1 with a later version (Set full path).', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'lazyload',
        'Enable Lazysizes:',
        'mis_lazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate and enqueue <a href="#">Lazysizes</a> v1.1.3 to lazyload all srcset-images.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'userpathLazyload',
        'Replace Lazysizes v1.1.3:',
        'mis_userpathLazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Replace Lazysizes v1.1.3 with a later version (Set full path).', 'levelThumbs' ),
        )
    );

    // Settings section for Styles -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_styles',
        __('Styles', 'levelThumbs'),
        'mis_styles_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'prevDupl',
        'Chrome style:',
        'mis_prevDupl_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_styles',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'explanation', 'levelThumbs' ),
        )
    );

    // Register and sanitize -------------------------------------------------------------------------------------------------------------------------

	register_setting(
		'levelThumbs_plugin_options',
		'levelThumbs_plugin_options',
		'mis_validate_sanitize_input'
	);
}

add_action( 'admin_init', 'mis_plugin_initialize_options' );

// Sections callback functions ----------------------------------------------------------------------------------------------------------------------------------

function mis_mediaqueries_callback() {
	echo '<p>' . __( 'Set four min-width mediaqueries for your themes layout, in ascending order. If you are using fewer media queries &mdash; enter common screensizes (higher than your final breakpoint) to fill the blanks.', 'levelThumbs' ) . '</p>';
}

function mis_imagewidths_callback() {
    echo '<p>' . __( 'Set hires/lores image widths for your layouts smallest screen (aka images NOT targeted by any min-widht-mediaquery). Also, enter the width for your fatest targeted screen.', 'levelThumbs' ) . '</p>';
}

function mis_srcsetSizes_callback() {
    echo '<p>' . __( 'Pair relative image sizes to your (min-width-) mediaqueries &mdash; or common screensizes if you are using fewer mediaqueries. ', 'levelThumbs' ) . '</p>';
}

function mis_wysiwyg_callback() {
    echo '<p>' . __( '<strong>Filter the_content():</strong> Handles all inline images according to default settings above. <br/><strong>Shortcode:</strong> Maximum flexibility with unique srcses widths for each image. Defaults to settings above.', 'levelThumbs' ) . '</p>';
}

function mis_jslib_callback() {
    echo '<p>' . __( '<em>There might be later versions of the provided resources Enqueue and dequeue.</em>', 'levelThumbs' ) . '</p>';
}

function mis_styles_callback() {
    echo '<p>' . __( 'Stylehandler', 'levelThumbs' ) . '</p>';
}


// Settings callback functions -----------------------------------------------------------------------------------------------------------------------------------

// Mediaqueries

function mis_imgSizeFirstMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$betaQuery = $options['imgWidth_firstMq'];
	$html = '<input type="text" id="imgWidth_firstMq" name="levelThumbs_plugin_options[imgWidth_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $betaQuery ) . '" />';
	$html .= '<label for="imgWidth_firstMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeSecondMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$charlieQuery = $options['imgWidth_secondMq'];
	$html = '<input type="text" id="imgWidth_secondMq" name="levelThumbs_plugin_options[imgWidth_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $charlieQuery ) . '" />';
	$html .= '<label for="imgWidth_secondMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeThirdMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$deltaQuery = $options['imgWidth_thirdMq'];
	$html = '<input type="text" id="imgWidth_thirdMq" name="levelThumbs_plugin_options[imgWidth_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $deltaQuery ) . '" />';
	$html .= '<label for="imgWidth_thirdMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeFourthMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$echoQuery = $options['imgWidth_fourthMq'];
	$html = '<input type="text" id="imgWidth_fourthMq" name="levelThumbs_plugin_options[imgWidth_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $echoQuery ) . '" />';
	$html .= '<label for="imgWidth_fourthMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgWidth_noMq_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_noMq = $options['imgWidth_noMq'];
    $html = '<input type="text" id="imgWidth_noMq" name="levelThumbs_plugin_options[imgWidth_noMq]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_noMq ) . '" />';
    $html .= '<label for="imgWidth_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Non MQ-dependent image sizes

function mis_imgWidth_noMq_R_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_noMq_R = $options['imgWidth_noMq_R'];
    $html = '<input type="text" id="imgWidth_noMq_R" name="levelThumbs_plugin_options[imgWidth_noMq_R]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_noMq_R ) . '" />';
    $html .= '<label for="imgWidth_noMq_R">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_imgWidth_fatscreen_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_fatscreen = $options['imgWidth_fatscreen'];
    $html = '<input type="text" id="imgWidth_fatscreen" name="levelThumbs_plugin_options[imgWidth_fatscreen]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_fatscreen ) . '" />';
    $html .= '<label for="imgWidth_fatscreen">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Srcset sizes

function mis_srcsetsize_one_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_noMq = $options['srcsetSize_noMq'];
    $html = '<input type="text" id="srcsetSize_noMq" name="levelThumbs_plugin_options[srcsetSize_noMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_noMq ) . '" />';
    $html .= '<label for="srcsetSize_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_two_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_firstMq = $options['srcsetSize_firstMq'];
    $html = '<input type="text" id="srcsetSize_firstMq" name="levelThumbs_plugin_options[srcsetSize_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_firstMq ) . '" />';
    $html .= '<label for="srcsetSize_firstMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_three_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_secondMq = $options['srcsetSize_secondMq'];
    $html = '<input type="text" id="srcsetSize_secondMq" name="levelThumbs_plugin_options[srcsetSize_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_secondMq ) . '" />';
    $html .= '<label for="srcsetSize_secondMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_four_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_thirdMq = $options['srcsetSize_thirdMq'];
    $html = '<input type="text" id="srcsetSize_thirdMq" name="levelThumbs_plugin_options[srcsetSize_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_thirdMq ) . '" />';
    $html .= '<label for="srcsetSize_thirdMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_five_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_fourthMq = $options['srcsetSize_fourthMq'];
    $html = '<input type="text" id="srcsetSize_fourthMq" name="levelThumbs_plugin_options[srcsetSize_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_fourthMq ) . '" />';
    $html .= '<label for="srcsetSize_fourthMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Images pulled by WYSIWYG-editor

function mis_contentFilter_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="contentFilter" name="levelThumbs_plugin_options[contentFilter]" value="1" ' . checked(1, isset($options['contentFilter']) ? $options['contentFilter'] : 0, false) . '/>';
    $html .= '<label for="contentFilter">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_shortcode_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="shortcode" name="levelThumbs_plugin_options[shortcode]" value="1" ' . checked(1, isset($options['shortcode']) ? $options['shortcode'] : 0, false) . '/>';
    $html .= '<label for="shortcode">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// JS-libraries

function mis_picturefill_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="picturefill" name="levelThumbs_plugin_options[picturefill]" value="1" ' . checked(1, isset($options['picturefill']) ? $options['picturefill'] : 0, false) . '/>';
    $html .= '<label for="picturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_userpathPicturefill_callback($args) {

    // First, we read the social options collection
    $options = get_option('levelThumbs_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    //$url = '';
    //if(isset($options['userpathPicturefill'])) {
    //    $url = $options['userpathPicturefill'];
    //} // end if

    // Render the output
    $html = '<input type="text" id="userpathPicturefill" placeholder="http://" name="levelThumbs_plugin_options[userpathPicturefill]" value="' . esc_url_raw($options['userpathPicturefill']) . '" />';
    $html .= '<label for="userpathPicturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_lazyload_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="lazyload" name="levelThumbs_plugin_options[lazyload]" value="1" ' . checked(1, isset($options['lazyload']) ? $options['lazyload'] : 0, false) . '/>';
    $html .= '<label for="lazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_userpathLazyload_callback($args) {

    // First, we read the social options collection
    $options = get_option('levelThumbs_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    // $url = '';
    // if( isset( $options['userpathLazyload'] ) ) {
    //    $url = $options['userpathLazyload'];
    //} // end if

    // Render the output
    $html = '<input type="text" id="userpathLazyload" placeholder="http://" name="levelThumbs_plugin_options[userpathLazyload]" value="' . esc_url_raw($options['userpathLazyload']) . '" />';
    $html .= '<label for="userpathLazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Styles

function mis_prevDupl_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="prevDupl" name="levelThumbs_plugin_options[prevDupl]" value="1" ' . checked(1, isset($options['prevDupl']) ? $options['prevDupl'] : 0, false) . '/>';
    $html .= '<label for="prevDupl">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}



//-----------------------------------------------------------------------------------------------------------------------------------

function mis_validate_sanitize_input($input) {
	$output = array();
	foreach($input as $key => $value){
		if(isset($input[$key])){
			$output[$key] = strip_tags(stripslashes($input[$key]));
		}
	}
	return apply_filters('mis_validate_sanitize_input', $output, $input);
}

function mis_get_option_integer($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    return $value = preg_replace('/[^0-9]+/', '', $options[$fieldID]);
}

function mis_get_option_boolean($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    return $value = isset($options[$fieldID]) && intval($options[$fieldID]);
}

function mis_get_option_url($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    return $value = esc_url_raw($options[$fieldID]);
}