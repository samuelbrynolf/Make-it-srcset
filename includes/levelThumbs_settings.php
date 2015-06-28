<?php function levelThumbs_main_tab() {
	add_plugins_page(
		'Level my postthumbs',
		'Level my postthumbs',
		'manage_options',
		'levelThumbs_plugin_options',
		'levelThumbs_plugin_menu'
	);
}
add_action('admin_menu', 'levelThumbs_main_tab');

function levelThumbs_plugin_menu($active_tab = '') { ?>
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

function levelThumbs_plugin_default_options() {
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
        'userpathPolyfill' => '',
        'userpathLazyload' => ''
	);
	return apply_filters( 'levelThumbs_plugin_default_options', $defaults );
}

// -----------------------------------------------------------------------------------------------------------------------------

function levelThumbs_plugin_initialize_options() {
	if(false == get_option('levelThumbs_plugin_options')) {
		add_option('levelThumbs_plugin_options', apply_filters('levelThumbs_plugin_default_options', levelThumbs_plugin_default_options()));
	}

    // Settings section for mediaqueries -------------------------------------------------------------------------------------------------------------------------

	add_settings_section(
		'levelThumbs_mediaqueries',
		__('Themes layout mediaqueries', 'levelThumbs'),
		'levelThumbs_mediaqueries_callback',
		'levelThumbs_plugin_options'
	);

	add_settings_field(
		'imgWidth_firstMq',
		'First breakpoint:',
		'levelThumbs_imgSizeFirstMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_secondMq',
		'Second breakpoint:',
		'levelThumbs_imgSizeSecondMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_thirdMq',
		'Third breakpoint:',
		'levelThumbs_imgSizeThirdMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_fourthMq',
		'Fourth breakpoint:',
		'levelThumbs_imgSizeFourthMq_callback',
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
        'levelThumbs_imagewidths_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'imgWidth_noMq',
        'Lores image width:',
        'levelThumbs_imgWidth_noMq_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );

    add_settings_field(
        'imgWidth_noMq_R',
        'Hires/retina image width:',
        'levelThumbs_imgWidth_noMq_R_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );

    add_settings_field(
        'imgWidth_fatscreen',
        'Fatest targeted screensize:',
        'levelThumbs_imgWidth_fatscreen_callback',
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
        'levelThumbs_srcsetSizes_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'srcsetSize_noMq',
        'Non-mq-targeted image size:',
        'levelThumbs_srcsetsize_one_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_firstMq',
        'First breakpoint &mdash; image size:',
        'levelThumbs_srcsetsize_two_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_secondMq',
        'Second breakpoint &mdash; image size:',
        'levelThumbs_srcsetsize_three_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_thirdMq',
        'Third breakpoint &mdash; image size:',
        'levelThumbs_srcsetsize_four_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_fourthMq',
        'Fourth breakpoint &mdash; image size:',
        'levelThumbs_srcsetsize_five_callback',
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
        'levelThumbs_wysiwyg_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'contentFilter',
        'Enable filter:',
        'levelThumbs_contentFilter_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Filter expl', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'shortcode',
        'Enable shortcode:',
        'levelThumbs_shortcode_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Shortcode expl', 'levelThumbs' ),
        )
    );

    // Settings section for JS-libraries -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_jslib',
        __('Javascript: Polyfill & Lazyload', 'levelThumbs'),
        'levelThumbs_jslib_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'picturefill',
        'Enable Picturefill v2.3.1:',
        'levelThumbs_picturefill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Provide a wider support for custom template tags that uses srcset, with Picturefill.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'userpathPolyfill',
        'Replace Picturefill version:',
        'levelThumbs_userpathPolyfill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Descr relative path.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'lazyload',
        'Enable Lazyload v1.1.3:',
        'levelThumbs_lazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate and enqueue <a href="#">Lazysizes</a> to lazyload all srcset-images.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'userpathLazyload',
        'Replace Lazyload version:',
        'levelThumbs_userpathLazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Descr relative path', 'levelThumbs' ),
        )
    );

    // Settings section for Styles -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'levelThumbs_styles',
        __('Styles', 'levelThumbs'),
        'levelThumbs_styles_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'prevDupl',
        'Chrome style:',
        'levelThumbs_prevDupl_callback',
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
		'validate_sanitize_input'
	);
}

add_action( 'admin_init', 'levelThumbs_plugin_initialize_options' );

// Sections callback functions ----------------------------------------------------------------------------------------------------------------------------------

function levelThumbs_mediaqueries_callback() {
	echo '<p>' . __( 'Set four min-width mediaqueries for your themes layout, in ascending order. If you are using fewer media queries &mdash; enter common screensizes (higher than your final breakpoint) to fill the blanks.', 'levelThumbs' ) . '</p>';
}

function levelThumbs_imagewidths_callback() {
    echo '<p>' . __( 'Set hires/lores image widths for your layouts smallest screen (aka images NOT targeted by any min-widht-mediaquery). Also, enter the width for your fatest targeted screen.', 'levelThumbs' ) . '</p>';
}

function levelThumbs_srcsetSizes_callback() {
    echo '<p>' . __( 'Pair relative image sizes to your (min-width-) mediaqueries &mdash; or common screensizes if you are using fewer mediaqueries. ', 'levelThumbs' ) . '</p>';
}

function levelThumbs_wysiwyg_callback() {
    echo '<p>' . __( '<strong>Filter the_content():</strong> Handles all inline images according to default settings above. <br/><strong>Shortcode:</strong> Maximum flexibility with unique srcses widths for each image. Defaults to settings above.', 'levelThumbs' ) . '</p>';
}

function levelThumbs_jslib_callback() {
    echo '<p>' . __( '<em>There might be later versions of the provided resources Enqueue and dequeue.</em>', 'levelThumbs' ) . '</p>';
}

function levelThumbs_styles_callback() {
    echo '<p>' . __( 'Stylehandler', 'levelThumbs' ) . '</p>';
}


// Settings callback functions -----------------------------------------------------------------------------------------------------------------------------------

// Mediaqueries

function levelThumbs_imgSizeFirstMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$betaQuery = $options['imgWidth_firstMq'];
	$html = '<input type="text" id="imgWidth_firstMq" name="levelThumbs_plugin_options[imgWidth_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $betaQuery ) . '" />';
	$html .= '<label for="imgWidth_firstMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeSecondMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$charlieQuery = $options['imgWidth_secondMq'];
	$html = '<input type="text" id="imgWidth_secondMq" name="levelThumbs_plugin_options[imgWidth_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $charlieQuery ) . '" />';
	$html .= '<label for="imgWidth_secondMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeThirdMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$deltaQuery = $options['imgWidth_thirdMq'];
	$html = '<input type="text" id="imgWidth_thirdMq" name="levelThumbs_plugin_options[imgWidth_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $deltaQuery ) . '" />';
	$html .= '<label for="imgWidth_thirdMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeFourthMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$echoQuery = $options['imgWidth_fourthMq'];
	$html = '<input type="text" id="imgWidth_fourthMq" name="levelThumbs_plugin_options[imgWidth_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $echoQuery ) . '" />';
	$html .= '<label for="imgWidth_fourthMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgWidth_noMq_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_noMq = $options['imgWidth_noMq'];
    $html = '<input type="text" id="imgWidth_noMq" name="levelThumbs_plugin_options[imgWidth_noMq]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_noMq ) . '" />';
    $html .= '<label for="imgWidth_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Non MQ-dependent image sizes

function levelThumbs_imgWidth_noMq_R_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_noMq_R = $options['imgWidth_noMq_R'];
    $html = '<input type="text" id="imgWidth_noMq_R" name="levelThumbs_plugin_options[imgWidth_noMq_R]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_noMq_R ) . '" />';
    $html .= '<label for="imgWidth_noMq_R">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_imgWidth_fatscreen_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_fatscreen = $options['imgWidth_fatscreen'];
    $html = '<input type="text" id="imgWidth_fatscreen" name="levelThumbs_plugin_options[imgWidth_fatscreen]" value="' . preg_replace('/[^0-9]+/', '', $imgWidth_fatscreen ) . '" />';
    $html .= '<label for="imgWidth_fatscreen">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Srcset sizes

function levelThumbs_srcsetsize_one_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_noMq = $options['srcsetSize_noMq'];
    $html = '<input type="text" id="srcsetSize_noMq" name="levelThumbs_plugin_options[srcsetSize_noMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_noMq ) . '" />';
    $html .= '<label for="srcsetSize_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_two_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_firstMq = $options['srcsetSize_firstMq'];
    $html = '<input type="text" id="srcsetSize_firstMq" name="levelThumbs_plugin_options[srcsetSize_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_firstMq ) . '" />';
    $html .= '<label for="srcsetSize_firstMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_three_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_secondMq = $options['srcsetSize_secondMq'];
    $html = '<input type="text" id="srcsetSize_secondMq" name="levelThumbs_plugin_options[srcsetSize_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_secondMq ) . '" />';
    $html .= '<label for="srcsetSize_secondMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_four_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_thirdMq = $options['srcsetSize_thirdMq'];
    $html = '<input type="text" id="srcsetSize_thirdMq" name="levelThumbs_plugin_options[srcsetSize_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_thirdMq ) . '" />';
    $html .= '<label for="srcsetSize_thirdMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_five_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_fourthMq = $options['srcsetSize_fourthMq'];
    $html = '<input type="text" id="srcsetSize_fourthMq" name="levelThumbs_plugin_options[srcsetSize_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $srcsetSize_fourthMq ) . '" />';
    $html .= '<label for="srcsetSize_fourthMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Images pulled by WYSIWYG-editor

function levelThumbs_contentFilter_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="contentFilter" name="levelThumbs_plugin_options[contentFilter]" value="1" ' . checked(1, isset($options['contentFilter']) ? $options['contentFilter'] : 0, false) . '/>';
    $html .= '<label for="contentFilter">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_shortcode_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="shortcode" name="levelThumbs_plugin_options[shortcode]" value="1" ' . checked(1, isset($options['shortcode']) ? $options['shortcode'] : 0, false) . '/>';
    $html .= '<label for="shortcode">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// JS-libraries

function levelThumbs_picturefill_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="picturefill" name="levelThumbs_plugin_options[picturefill]" value="1" ' . checked(1, isset($options['picturefill']) ? $options['picturefill'] : 0, false) . '/>';
    $html .= '<label for="picturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_userpathPolyfill_callback($args) {

    // First, we read the social options collection
    $options = get_option('levelThumbs_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    $url = '';
    if(isset($options['userpathPolyfill'])) {
        $url = $options['userpathPolyfill'];
    } // end if

    // Render the output
    $html = '<input type="text" id="userpathPolyfill" name="levelThumbs_plugin_options[userpathPolyfill]" value="' . $options['userpathPolyfill'] . '" />';
    $html .= '<label for="userpathPolyfill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_lazyload_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="lazyload" name="levelThumbs_plugin_options[lazyload]" value="1" ' . checked(1, isset($options['lazyload']) ? $options['lazyload'] : 0, false) . '/>';
    $html .= '<label for="lazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_userpathLazyload_callback($args) {

    // First, we read the social options collection
    $options = get_option('levelThumbs_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    $url = '';
    if( isset( $options['userpathLazyload'] ) ) {
        $url = $options['userpathLazyload'];
    } // end if

    // Render the output
    $html = '<input type="text" id="userpathLazyload" name="levelThumbs_plugin_options[userpathLazyload]" value="' . $options['userpathLazyload'] . '" />';
    $html .= '<label for="userpathLazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Styles

function levelThumbs_prevDupl_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="prevDupl" name="levelThumbs_plugin_options[prevDupl]" value="1" ' . checked(1, isset($options['prevDupl']) ? $options['prevDupl'] : 0, false) . '/>';
    $html .= '<label for="prevDupl">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}



//-----------------------------------------------------------------------------------------------------------------------------------

function validate_sanitize_input($input) {
	$output = array();
	foreach($input as $key => $value){
		if(isset($input[$key])){
			// $output[$key] = preg_replace('/[^0-9]+/', '', $input[ $key ] );
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
		}
	}
	return apply_filters('validate_sanitize_input', $output, $input);
}

function levelThumbs_get_option_string($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    return $value = sanitize_key($options[$fieldID]);
}

function levelThumbs_get_option_boolean($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    return $value = isset($options[$fieldID]) && intval($options[$fieldID]);
}