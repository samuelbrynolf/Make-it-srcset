<?php function mis_main_tab() {
	add_plugins_page(
		'Make it Srcset',
		'Make it Srcset',
		'manage_options',
		'mis_plugin_options',
		'mis_plugin_menu'
	);
}
add_action('admin_menu', 'mis_main_tab');

function mis_plugin_menu() { ?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e('Make it Srcset', 'makeitsrcset'); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields('mis_plugin_options');
			do_settings_sections('mis_plugin_options');
			submit_button(); ?>
		</form>
	</div>
<?php }

// --------------------------------------------------------------------------------------------------------------------------------

function mis_plugin_default_options() {
	$defaults = array(
        'mis_imgWidth_noMq'  => '320',
		'mis_imgWidth_noMq_R'  => '480',
		'mis_imgWidth_firstMq'  => '768',
		'mis_imgWidth_secondMq'  => '1024',
		'mis_imgWidth_thirdMq'  => '1280',
		'mis_imgWidth_fourthMq'  => '1440',
        'mis_imgWidth_fatscreen' => '1680',
        'mis_srcsetSize_noMq' => '100',
        'mis_srcsetSize_firstMq' => '100',
        'mis_srcsetSize_secondMq' => '100',
        'mis_srcsetSize_thirdMq' => '100',
        'mis_srcsetSize_fourthMq' => '100',
        'mis_userpathPicturefill' => '',
        'mis_userpathLazyload' => ''
	);
	return apply_filters( 'mis_plugin_default_options', $defaults );
}

// -----------------------------------------------------------------------------------------------------------------------------

function mis_plugin_initialize_options() {
	if(false == get_option('mis_plugin_options')) {
		add_option('mis_plugin_options', apply_filters('mis_plugin_default_options', mis_plugin_default_options()));
	}

    // Settings section for mediaqueries -------------------------------------------------------------------------------------------------------------------------

	add_settings_section(
		'mis_mediaqueries',
		__('Specify srcset mediaqueries', 'makeitsrcset'),
		'mis_mediaqueries_callback',
		'mis_plugin_options'
	);

	add_settings_field(
		'mis_imgWidth_firstMq',
		'First breakpoint:',
		'mis_imgSizeFirstMq_callback',
		'mis_plugin_options',
		'mis_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'makeitsrcset'),
		)
	);

	add_settings_field(
		'mis_imgWidth_secondMq',
		'Second breakpoint:',
		'mis_imgSizeSecondMq_callback',
		'mis_plugin_options',
		'mis_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'makeitsrcset'),
		)
	);

	add_settings_field(
		'mis_imgWidth_thirdMq',
		'Third breakpoint:',
		'mis_imgSizeThirdMq_callback',
		'mis_plugin_options',
		'mis_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'makeitsrcset'),
		)
	);

	add_settings_field(
		'mis_imgWidth_fourthMq',
		'Fourth breakpoint:',
		'mis_imgSizeFourthMq_callback',
		'mis_plugin_options',
		'mis_mediaqueries',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'makeitsrcset'),
		)
	);

    // Settings section for image sizes -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'mis_imagewidths',
        __('Target screen extremes', 'makeitsrcset'),
        'mis_imagewidths_callback',
        'mis_plugin_options'
    );

    add_settings_field(
        'mis_imgWidth_noMq',
        'Smallest screen: Size (x-axis):',
        'mis_imgWidth_noMq_callback',
        'mis_plugin_options',
        'mis_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_imgWidth_noMq_R',
        'Smallest screen: Hires dpi:',
        'mis_imgWidth_noMq_R_callback',
        'mis_plugin_options',
        'mis_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_imgWidth_fatscreen',
        'Fatest screen: Size (x-axis):',
        'mis_imgWidth_fatscreen_callback',
        'mis_plugin_options',
        'mis_imagewidths',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'makeitsrcset'),
        )
    );
    
    // Settings section for srcset-sizes -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'mis_srcsetSizes',
        __('Srcset size per mediaquery', 'makeitsrcset'),
        'mis_srcsetSizes_callback',
        'mis_plugin_options'
    );

    add_settings_field(
        'mis_srcsetSize_noMq',
        'Non-mq-targeted image size:',
        'mis_srcsetsize_one_callback',
        'mis_plugin_options',
        'mis_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_srcsetSize_firstMq',
        'First breakpoint &mdash; image size:',
        'mis_srcsetsize_two_callback',
        'mis_plugin_options',
        'mis_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_srcsetSize_secondMq',
        'Second breakpoint &mdash; image size:',
        'mis_srcsetsize_three_callback',
        'mis_plugin_options',
        'mis_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_srcsetSize_thirdMq',
        'Third breakpoint &mdash; image size:',
        'mis_srcsetsize_four_callback',
        'mis_plugin_options',
        'mis_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'makeitsrcset'),
        )
    );

    add_settings_field(
        'mis_srcsetSize_fourthMq',
        'Fourth breakpoint &mdash; image size:',
        'mis_srcsetsize_five_callback',
        'mis_plugin_options',
        'mis_srcsetSizes',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'makeitsrcset'),
        )
    );

    // Settings section for images pulled by WYSIWYG-editor -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'mis_wysiwyg',
        __('Handle images pulled by the WYSIWYG-editor', 'makeitsrcset'),
        'mis_wysiwyg_callback',
        'mis_plugin_options'
    );

    add_settings_field(
        'mis_contentFilter',
        'Enable filter:',
        'mis_contentFilter_callback',
        'mis_plugin_options',
        'mis_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Filter expl', 'makeitsrcset' ),
        )
    );

    add_settings_field(
        'mis_shortcode',
        'Enable shortcode:',
        'mis_shortcode_callback',
        'mis_plugin_options',
        'mis_wysiwyg',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Shortcode expl', 'makeitsrcset' ),
        )
    );

    // Settings section for JS-libraries -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'mis_jslib',
        __('Javascript: Picturefill & Lazyload', 'makeitsrcset'),
        'mis_jslib_callback',
        'mis_plugin_options'
    );

    add_settings_field(
        'mis_picturefill',
        'Enable Picturefill:',
        'mis_picturefill_callback',
        'mis_plugin_options',
        'mis_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Provide a wider support for custom template tags that uses srcset, with Picturefill v2.3.1.', 'makeitsrcset' ),
        )
    );

    add_settings_field(
        'mis_userpathPicturefill',
        'Replace Picturefill v2.3.1:',
        'mis_userpathPicturefill_callback',
        'mis_plugin_options',
        'mis_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Replace Picturefill v2.3.1 with a later version (Set full path).', 'makeitsrcset' ),
        )
    );

    add_settings_field(
        'mis_lazyload',
        'Enable Lazysizes:',
        'mis_lazyload_callback',
        'mis_plugin_options',
        'mis_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate and enqueue <a href="#">Lazysizes</a> v1.1.3 to lazyload all srcset-images.', 'makeitsrcset' ),
        )
    );

    add_settings_field(
        'mis_userpathLazyload',
        'Replace Lazysizes v1.1.3:',
        'mis_userpathLazyload_callback',
        'mis_plugin_options',
        'mis_jslib',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Replace Lazysizes v1.1.3 with a later version (Set full path).', 'makeitsrcset' ),
        )
    );

    // Settings section for Styles -------------------------------------------------------------------------------------------------------------------------

    add_settings_section(
        'mis_styles',
        __('Styles', 'makeitsrcset'),
        'mis_styles_callback',
        'mis_plugin_options'
    );

    add_settings_field(
        'mis_preventDuplicates',
        'Chrome style:',
        'mis_mis_preventDuplicates_callback',
        'mis_plugin_options',
        'mis_styles',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'explanation', 'makeitsrcset' ),
        )
    );

    // Register and sanitize -------------------------------------------------------------------------------------------------------------------------

	register_setting(
		'mis_plugin_options',
		'mis_plugin_options',
		'mis_validate_sanitize_input'
	);
}

add_action( 'admin_init', 'mis_plugin_initialize_options' );

// Sections callback functions ----------------------------------------------------------------------------------------------------------------------------------

function mis_mediaqueries_callback() {
	echo '<p>' . __( '<strong>Make it Srcset</strong> uses four min-width mediaqueries within the sizes-attribute for each image. Add your default values in ascending order.<br/><strong>Tip:</strong> Use the same breakpoints as your themes layout do. If you are using fewer media queries in your layout than four &mdash; enter common screensizes (higher than your final breakpoint) to fill the blanks.', 'makeitsrcset' ) . '</p>';
}

function mis_imagewidths_callback() {
    echo '<p>' . __( '<strong>Aka:</strong> What are the needs in pixels for your smallest / fatests screens?<br/><em>Size</em> refers the physical size of the screen.<br/><em>Hires dpi</em> refers resolution such as retina display.<br/><strong>Example:</strong> The iPhone 4 screen has a width of 320px but its dpi is 640px since it is a retina.', 'makeitsrcset' ) . '</p>';
}

function mis_srcsetSizes_callback() {
    echo '<p>' . __( 'Pair relative image sizes to your (min-width-) mediaqueries &mdash; or common screensizes if you are using fewer mediaqueries. ', 'makeitsrcset' ) . '</p>';
}

function mis_wysiwyg_callback() {
    echo '<p>' . __( '<strong>Filter the_content():</strong> Handles all inline images according to default settings above. <br/><strong>Shortcode:</strong> Maximum flexibility with unique srcses widths for each image. Defaults to settings above.', 'makeitsrcset' ) . '</p>';
}

function mis_jslib_callback() {
    echo '<p>' . __( '<em>There might be later versions of the provided resources Enqueue and dequeue.</em>', 'makeitsrcset' ) . '</p>';
}

function mis_styles_callback() {
    echo '<p>' . __( 'Stylehandler', 'makeitsrcset' ) . '</p>';
}


// Settings callback functions -----------------------------------------------------------------------------------------------------------------------------------

// Mediaqueries

function mis_imgSizeFirstMq_callback($args) {
	$options = get_option( 'mis_plugin_options' );
	$betaQuery = $options['mis_imgWidth_firstMq'];
	$html = '<input type="text" id="mis_imgWidth_firstMq" name="mis_plugin_options[mis_imgWidth_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $betaQuery ) . '" />';
	$html .= '<label for="mis_imgWidth_firstMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeSecondMq_callback($args) {
	$options = get_option( 'mis_plugin_options' );
	$charlieQuery = $options['mis_imgWidth_secondMq'];
	$html = '<input type="text" id="mis_imgWidth_secondMq" name="mis_plugin_options[mis_imgWidth_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $charlieQuery ) . '" />';
	$html .= '<label for="mis_imgWidth_secondMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeThirdMq_callback($args) {
	$options = get_option( 'mis_plugin_options' );
	$deltaQuery = $options['mis_imgWidth_thirdMq'];
	$html = '<input type="text" id="mis_imgWidth_thirdMq" name="mis_plugin_options[mis_imgWidth_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $deltaQuery ) . '" />';
	$html .= '<label for="mis_imgWidth_thirdMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgSizeFourthMq_callback($args) {
	$options = get_option( 'mis_plugin_options' );
	$echoQuery = $options['mis_imgWidth_fourthMq'];
	$html = '<input type="text" id="mis_imgWidth_fourthMq" name="mis_plugin_options[mis_imgWidth_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $echoQuery ) . '" />';
	$html .= '<label for="mis_imgWidth_fourthMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function mis_imgWidth_noMq_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_imgWidth_noMq = $options['mis_imgWidth_noMq'];
    $html = '<input type="text" id="mis_imgWidth_noMq" name="mis_plugin_options[mis_imgWidth_noMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_imgWidth_noMq ) . '" />';
    $html .= '<label for="mis_imgWidth_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Non MQ-dependent image sizes

function mis_imgWidth_noMq_R_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_imgWidth_noMq_R = $options['mis_imgWidth_noMq_R'];
    $html = '<input type="text" id="mis_imgWidth_noMq_R" name="mis_plugin_options[mis_imgWidth_noMq_R]" value="' . preg_replace('/[^0-9]+/', '', $mis_imgWidth_noMq_R ) . '" />';
    $html .= '<label for="mis_imgWidth_noMq_R">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_imgWidth_fatscreen_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_imgWidth_fatscreen = $options['mis_imgWidth_fatscreen'];
    $html = '<input type="text" id="mis_imgWidth_fatscreen" name="mis_plugin_options[mis_imgWidth_fatscreen]" value="' . preg_replace('/[^0-9]+/', '', $mis_imgWidth_fatscreen ) . '" />';
    $html .= '<label for="mis_imgWidth_fatscreen">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Srcset sizes

function mis_srcsetsize_one_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_srcsetSize_noMq = $options['mis_srcsetSize_noMq'];
    $html = '<input type="text" id="mis_srcsetSize_noMq" name="mis_plugin_options[mis_srcsetSize_noMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_srcsetSize_noMq ) . '" />';
    $html .= '<label for="mis_srcsetSize_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_two_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_srcsetSize_firstMq = $options['mis_srcsetSize_firstMq'];
    $html = '<input type="text" id="mis_srcsetSize_firstMq" name="mis_plugin_options[mis_srcsetSize_firstMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_srcsetSize_firstMq ) . '" />';
    $html .= '<label for="mis_srcsetSize_firstMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_three_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_srcsetSize_secondMq = $options['mis_srcsetSize_secondMq'];
    $html = '<input type="text" id="mis_srcsetSize_secondMq" name="mis_plugin_options[mis_srcsetSize_secondMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_srcsetSize_secondMq ) . '" />';
    $html .= '<label for="mis_srcsetSize_secondMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_four_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_srcsetSize_thirdMq = $options['mis_srcsetSize_thirdMq'];
    $html = '<input type="text" id="mis_srcsetSize_thirdMq" name="mis_plugin_options[mis_srcsetSize_thirdMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_srcsetSize_thirdMq ) . '" />';
    $html .= '<label for="mis_srcsetSize_thirdMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_srcsetsize_five_callback($args) {
    $options = get_option( 'mis_plugin_options' );
    $mis_srcsetSize_fourthMq = $options['mis_srcsetSize_fourthMq'];
    $html = '<input type="text" id="mis_srcsetSize_fourthMq" name="mis_plugin_options[mis_srcsetSize_fourthMq]" value="' . preg_replace('/[^0-9]+/', '', $mis_srcsetSize_fourthMq ) . '" />';
    $html .= '<label for="mis_srcsetSize_fourthMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Images pulled by WYSIWYG-editor

function mis_contentFilter_callback($args) {
    $options = get_option('mis_plugin_options');
    $html = '<input type="checkbox" id="mis_contentFilter" name="mis_plugin_options[mis_contentFilter]" value="1" ' . checked(1, isset($options['mis_contentFilter']) ? $options['mis_contentFilter'] : 0, false) . '/>';
    $html .= '<label for="mis_contentFilter">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_shortcode_callback($args) {
    $options = get_option('mis_plugin_options');
    $html = '<input type="checkbox" id="mis_shortcode" name="mis_plugin_options[mis_shortcode]" value="1" ' . checked(1, isset($options['mis_shortcode']) ? $options['mis_shortcode'] : 0, false) . '/>';
    $html .= '<label for="mis_shortcode">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// JS-libraries

function mis_picturefill_callback($args) {
    $options = get_option('mis_plugin_options');
    $html = '<input type="checkbox" id="mis_picturefill" name="mis_plugin_options[mis_picturefill]" value="0" ' . checked(0, isset($options['mis_picturefill']) ? $options['mis_picturefill'] : 1, false) . '/>';
    $html .= '<label for="mis_picturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_userpathPicturefill_callback($args) {

    // First, we read the social options collection
    $options = get_option('mis_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    //$url = '';
    //if(isset($options['mis_userpathPicturefill'])) {
    //    $url = $options['mis_userpathPicturefill'];
    //} // end if

    // Render the output
    $html = '<input type="text" id="mis_userpathPicturefill" placeholder="http://" name="mis_plugin_options[mis_userpathPicturefill]" value="' . esc_url_raw($options['mis_userpathPicturefill']) . '" />';
    $html .= '<label for="mis_userpathPicturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_lazyload_callback($args) {
    $options = get_option('mis_plugin_options');
    $html = '<input type="checkbox" id="mis_lazyload" name="mis_plugin_options[mis_lazyload]" value="1" ' . checked(1, isset($options['mis_lazyload']) ? $options['mis_lazyload'] : 0, false) . '/>';
    $html .= '<label for="mis_lazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function mis_userpathLazyload_callback($args) {

    // First, we read the social options collection
    $options = get_option('mis_plugin_options');

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    // $url = '';
    // if( isset( $options['mis_userpathLazyload'] ) ) {
    //    $url = $options['mis_userpathLazyload'];
    //} // end if

    // Render the output
    $html = '<input type="text" id="mis_userpathLazyload" placeholder="http://" name="mis_plugin_options[mis_userpathLazyload]" value="' . esc_url_raw($options['mis_userpathLazyload']) . '" />';
    $html .= '<label for="mis_userpathLazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

// Styles

function mis_mis_preventDuplicates_callback($args) {
    $options = get_option('mis_plugin_options');
    $html = '<input type="checkbox" id="mis_preventDuplicates" name="mis_plugin_options[mis_preventDuplicates]" value="1" ' . checked(1, isset($options['mis_preventDuplicates']) ? $options['mis_preventDuplicates'] : 0, false) . '/>';
    $html .= '<label for="mis_preventDuplicates">&nbsp;'  . $args[0] . '</label>';
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
    $options = get_option('mis_plugin_options');
    return $value = preg_replace('/[^0-9]+/', '', $options[$fieldID]);
}

function mis_get_option_boolean($fieldID){
    $options = get_option('mis_plugin_options');
    return $value = isset($options[$fieldID]) && intval($options[$fieldID]);
}

function mis_get_option_url($fieldID){
    $options = get_option('mis_plugin_options');
    return $value = esc_url_raw($options[$fieldID]);
}