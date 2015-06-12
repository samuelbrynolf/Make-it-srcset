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
		'imgWidth_firstMq'  => '768',
		'imgWidth_secondMq'  => '1024',
		'imgWidth_thirdMq'  => '1280',
		'imgWidth_fourthMq'  => '1440',
        'imgWidth_fatscreen' => '1680',
        'srcsetSize_noMq' => '100',
        'srcsetSize_firstMq' => '100',
        'srcsetSize_secondMq' => '100',
        'srcsetSize_thirdMq' => '100',
        'srcsetSize_fourthMq' => '100'
	);
	return apply_filters( 'levelThumbs_plugin_default_options', $defaults );
}

// -----------------------------------------------------------------------------------------------------------------------------

function levelThumbs_plugin_initialize_options() {
	if( false == get_option( 'levelThumbs_plugin_options' ) ) {
		add_option( 'levelThumbs_plugin_options', apply_filters( 'levelThumbs_plugin_default_options', levelThumbs_plugin_default_options()) );
	}

    // Settings section for image-sizes and javascript enqueues

	add_settings_section(
		'levelThumbs_images_js',
		__('Add new image sizes, toggle polyfill + lazyload support', 'levelThumbs'),
		'levelThumbs_images_js_callback',
		'levelThumbs_plugin_options'
	);

	add_settings_field(
		'imgWidth_firstMq',
		'First Size (Smallest)',
		'levelThumbs_imgSizeFirstMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_secondMq',
		'Second Size',
		'levelThumbs_imgSizeSecondMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_thirdMq',
		'Third Size',
		'levelThumbs_imgSizeThirdMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgWidth_fourthMq',
		'Fourth Size',
		'levelThumbs_imgSizeFourthMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

    add_settings_field(
        'imgWidth_fatscreen',
        'Fifth Size (Largest)',
        'levelThumbs_imgWidth_fatscreen_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_images_js',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('px', 'levelThumbs'),
        )
    );

    add_settings_field(
        'picturefill',
        'Enqueue Picturefill.js',
        'levelThumbs_picturefill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_images_js',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Provide a wider support for custom template tags that uses srcset, with Picturefill.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'lazyload',
        'Enable lazyload',
        'levelThumbs_lazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_images_js',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate and enqueue <a href="#">Lazysizes</a> to lazyload any srcset-images.', 'levelThumbs' ),
        )
    );

    // Settings section for srcset-sizes and srcset-filter

    add_settings_section(
        'levelThumbs_sizes_filter',
        __('Srcset sizes & filter the_content', 'levelThumbs'),
        'levelThumbs_sizes_filter_callback',
        'levelThumbs_plugin_options'
    );

    add_settings_field(
        'srcsetSize_noMq',
        'Non-mediaqueried image size',
        'levelThumbs_srcsetsize_one_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_firstMq',
        'First breakpoint image size',
        'levelThumbs_srcsetsize_two_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_secondMq',
        'Second breakpoint image size',
        'levelThumbs_srcsetsize_three_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_thirdMq',
        'Third breakpoint image size',
        'levelThumbs_srcsetsize_four_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcsetSize_fourthMq',
        'Fourth breakpoint image size',
        'levelThumbs_srcsetsize_five_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'srcset_filter',
        'Enable srcset-filter for the_content()',
        'levelThumbs_srcset_filter_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Srcset all images used in wysiwyg-editor.', 'levelThumbs' ),
        )
    );

	register_setting(
		'levelThumbs_plugin_options',
		'levelThumbs_plugin_options',
		'validate_sanitize_input'
	);
}

add_action( 'admin_init', 'levelThumbs_plugin_initialize_options' );

// Sections callback functions ----------------------------------------------------------------------------------------------------------------------------------

function levelThumbs_images_js_callback() {
	echo '<p>' . __( 'Customize four new post thumbnail-sizes (widths) in pixel-values.<br/><strong>Tip:</strong> Match sizes with your mediaquery-breakpoints since the custom template tags brings srcset to the table (pretty much what this plugin is about). <a href="#">What custom template tags are there?</a><br/><a href="#">Does this plugin add any other sizes?</a>', 'levelThumbs' ) . '</p>';
}

function levelThumbs_sizes_filter_callback() {
    echo '<p>' . __( 'Set default srcset-sizes. Toggle srcset-filter for images pulled by the media uploader.', 'levelThumbs' ) . '</p>';
}


// Settings callback functions -----------------------------------------------------------------------------------------------------------------------------------

function levelThumbs_imgSizeFirstMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$betaQuery = $options['imgWidth_firstMq'];
	$html = '<input type="text" id="imgWidth_firstMq" name="levelThumbs_plugin_options[imgWidth_firstMq]" value="' . $betaQuery . '" />';
	$html .= '<label for="imgWidth_firstMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeSecondMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$charlieQuery = $options['imgWidth_secondMq'];
	$html = '<input type="text" id="imgWidth_secondMq" name="levelThumbs_plugin_options[imgWidth_secondMq]" value="' . $charlieQuery . '" />';
	$html .= '<label for="imgWidth_secondMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeThirdMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$deltaQuery = $options['imgWidth_thirdMq'];
	$html = '<input type="text" id="imgWidth_thirdMq" name="levelThumbs_plugin_options[imgWidth_thirdMq]" value="' . $deltaQuery . '" />';
	$html .= '<label for="imgWidth_thirdMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeFourthMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$echoQuery = $options['imgWidth_fourthMq'];
	$html = '<input type="text" id="imgWidth_fourthMq" name="levelThumbs_plugin_options[imgWidth_fourthMq]" value="' . $echoQuery . '" />';
	$html .= '<label for="imgWidth_fourthMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgWidth_fatscreen_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $imgWidth_fatscreen = $options['imgWidth_fatscreen'];
    $html = '<input type="text" id="imgWidth_fatscreen" name="levelThumbs_plugin_options[imgWidth_fatscreen]" value="' . $imgWidth_fatscreen . '" />';
    $html .= '<label for="imgWidth_fatscreen">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_picturefill_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="picturefill" name="levelThumbs_plugin_options[picturefill]" value="1" ' . checked(1, isset($options['picturefill']) ? $options['picturefill'] : 0, false) . '/>';
    $html .= '<label for="picturefill">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_lazyload_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="lazyload" name="levelThumbs_plugin_options[lazyload]" value="1" ' . checked(1, isset($options['lazyload']) ? $options['lazyload'] : 0, false) . '/>';
    $html .= '<label for="lazyload">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_one_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_noMq = $options['srcsetSize_noMq'];
    $html = '<input type="text" id="srcsetSize_noMq" name="levelThumbs_plugin_options[srcsetSize_noMq]" value="' . $srcsetSize_noMq . '" />';
    $html .= '<label for="srcsetSize_noMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_two_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_firstMq = $options['srcsetSize_firstMq'];
    $html = '<input type="text" id="srcsetSize_firstMq" name="levelThumbs_plugin_options[srcsetSize_firstMq]" value="' . $srcsetSize_firstMq . '" />';
    $html .= '<label for="srcsetSize_firstMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_three_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_secondMq = $options['srcsetSize_secondMq'];
    $html = '<input type="text" id="srcsetSize_secondMq" name="levelThumbs_plugin_options[srcsetSize_secondMq]" value="' . $srcsetSize_secondMq . '" />';
    $html .= '<label for="srcsetSize_secondMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_four_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_thirdMq = $options['srcsetSize_thirdMq'];
    $html = '<input type="text" id="srcsetSize_thirdMq" name="levelThumbs_plugin_options[srcsetSize_thirdMq]" value="' . $srcsetSize_thirdMq . '" />';
    $html .= '<label for="srcsetSize_thirdMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_five_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $srcsetSize_fourthMq = $options['srcsetSize_fourthMq'];
    $html = '<input type="text" id="srcsetSize_fourthMq" name="levelThumbs_plugin_options[srcsetSize_fourthMq]" value="' . $srcsetSize_fourthMq . '" />';
    $html .= '<label for="srcsetSize_fourthMq">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcset_filter_callback($args) {
    $options = get_option('levelThumbs_plugin_options');
    $html = '<input type="checkbox" id="srcset_filter" name="levelThumbs_plugin_options[srcset_filter]" value="1" ' . checked(1, isset($options['srcset_filter']) ? $options['srcset_filter'] : 0, false) . '/>';
    $html .= '<label for="srcset_filter">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

//-----------------------------------------------------------------------------------------------------------------------------------

function validate_sanitize_input($input) {
	$output = array();
	foreach($input as $key => $value){
		if(isset($input[$key])){
			$output[$key] = preg_replace('/[^0-9]+/', '', $input[ $key ] );
		}
	}
	return apply_filters('validate_sanitize_input', $output, $input);
}

function levelThumbs_get_options_value($fieldID){
	$options = get_option('levelThumbs_plugin_options');
	return $value = sanitize_key($options[$fieldID]);
}

function levelThumbs_get_boolean_options_value($fieldID){
    $options = get_option('levelThumbs_plugin_options');
    $value = isset($options[$fieldID]) && intval($options[$fieldID]);
    return $value;
}