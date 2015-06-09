<?php

// change to vw_noMq & imgWidth_firstMq

function levelThumbs_main_tab() {
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
		'imgSize_firstMq'  => '768',
		'imgSize_secondMq'  => '1024',
		'imgSize_thirdMq'  => '1280',
		'imgSize_fourthMq'  => '1440',
        'noMq_vw' => '100',
        'firstMq_vw' => '100',
        'secondMq_vw' => '100',
        'thirdMq_vw' => '100',
        'fourthMq_vw' => '100'
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
		'imgSize_firstMq',
		'First Size (Smallest)',
		'levelThumbs_imgSizeFirstMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgSize_secondMq',
		'Second Size',
		'levelThumbs_imgSizeSecondMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgSize_thirdMq',
		'Third Size',
		'levelThumbs_imgSizeThirdMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

	add_settings_field(
		'imgSize_fourthMq',
		'Fourth Size',
		'levelThumbs_imgSizeFourthMq_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_images_js',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__('px', 'levelThumbs'),
		)
	);

    add_settings_field(
        'superlarge',
        'Fifth Size (Largest)',
        'levelThumbs_superlarge_callback',
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
        'noMq_vw',
        'Non-mediaqueried image size',
        'levelThumbs_srcsetsize_one_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'firstMq_vw',
        'First breakpoint image size',
        'levelThumbs_srcsetsize_two_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'secondMq_vw',
        'Second breakpoint image size',
        'levelThumbs_srcsetsize_three_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'thirdMq_vw',
        'Third breakpoint image size',
        'levelThumbs_srcsetsize_four_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_sizes_filter',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __('vw', 'levelThumbs'),
        )
    );

    add_settings_field(
        'fourthMq_vw',
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
	$betaQuery = $options['imgSize_firstMq'];
	$html = '<input type="text" id="imgSize_firstMq" name="levelThumbs_plugin_options[imgSize_firstMq]" value="' . $betaQuery . '" />';
	$html .= '<label for="imgSize_firstMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeSecondMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$charlieQuery = $options['imgSize_secondMq'];
	$html = '<input type="text" id="imgSize_secondMq" name="levelThumbs_plugin_options[imgSize_secondMq]" value="' . $charlieQuery . '" />';
	$html .= '<label for="imgSize_secondMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeThirdMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$deltaQuery = $options['imgSize_thirdMq'];
	$html = '<input type="text" id="imgSize_thirdMq" name="levelThumbs_plugin_options[imgSize_thirdMq]" value="' . $deltaQuery . '" />';
	$html .= '<label for="imgSize_thirdMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_imgSizeFourthMq_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$echoQuery = $options['imgSize_fourthMq'];
	$html = '<input type="text" id="imgSize_fourthMq" name="levelThumbs_plugin_options[imgSize_fourthMq]" value="' . $echoQuery . '" />';
	$html .= '<label for="imgSize_fourthMq">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_superlarge_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $superlarge = $options['superlarge'];
    $html = '<input type="text" id="superlarge" name="levelThumbs_plugin_options[superlarge]" value="' . $superlarge . '" />';
    $html .= '<label for="superlarge">&nbsp;'  . $args[0] . '</label>';
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
    $noMq_vw = $options['noMq_vw'];
    $html = '<input type="text" id="noMq_vw" name="levelThumbs_plugin_options[noMq_vw]" value="' . $noMq_vw . '" />';
    $html .= '<label for="noMq_vw">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_two_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $firstMq_vw = $options['firstMq_vw'];
    $html = '<input type="text" id="firstMq_vw" name="levelThumbs_plugin_options[firstMq_vw]" value="' . $firstMq_vw . '" />';
    $html .= '<label for="firstMq_vw">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_three_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $secondMq_vw = $options['secondMq_vw'];
    $html = '<input type="text" id="secondMq_vw" name="levelThumbs_plugin_options[secondMq_vw]" value="' . $secondMq_vw . '" />';
    $html .= '<label for="secondMq_vw">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_four_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $thirdMq_vw = $options['thirdMq_vw'];
    $html = '<input type="text" id="thirdMq_vw" name="levelThumbs_plugin_options[thirdMq_vw]" value="' . $thirdMq_vw . '" />';
    $html .= '<label for="thirdMq_vw">&nbsp;'  . $args[0] . '</label>';
    echo $html;
}

function levelThumbs_srcsetsize_five_callback($args) {
    $options = get_option( 'levelThumbs_plugin_options' );
    $fourthMq_vw = $options['fourthMq_vw'];
    $html = '<input type="text" id="fourthMq_vw" name="levelThumbs_plugin_options[fourthMq_vw]" value="' . $fourthMq_vw . '" />';
    $html .= '<label for="fourthMq_vw">&nbsp;'  . $args[0] . '</label>';
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