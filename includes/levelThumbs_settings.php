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
		'beta_query'  => '768',
		'charlie_query'  => '1024',
		'delta_query'  => '1280',
		'echo_query'  => '1440'
	);
	return apply_filters( 'levelThumbs_plugin_default_options', $defaults );
}

// -----------------------------------------------------------------------------------------------------------------------------

function levelThumbs_plugin_initialize_cpt_options() {
	if( false == get_option( 'levelThumbs_plugin_options' ) ) {
		add_option( 'levelThumbs_plugin_options', apply_filters( 'levelThumbs_plugin_default_options', levelThumbs_plugin_default_options() ) );
	}
	add_settings_section(
		'levelThumbs_settings_section',
		__( '', 'levelThumbs' ),
		'levelThumbs_options_callback',
		'levelThumbs_plugin_options'
	);
	
	add_settings_field(
		'beta_query',
		'First Size/Breakpoint',
		'levelThumbs_betaQuery_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_settings_section',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Default = 768px', 'levelThumbs' ),
		)
	);
	
	add_settings_field(
		'charlie_query',
		'Second Size/Breakpoint',
		'levelThumbs_charlieQuery_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_settings_section',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Default = 1024px', 'levelThumbs' ),
		)
	);
	
	add_settings_field(
		'delta_query',
		'Third Size/Breakpoint',
		'levelThumbs_deltaQuery_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_settings_section',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Default = 1280px', 'levelThumbs' ),
		)
	);
	
	add_settings_field(
		'echo_query',
		'Fourth Size/Breakpoint',
		'levelThumbs_echoQuery_callback',
		'levelThumbs_plugin_options',
		'levelThumbs_settings_section',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Default = 1440px', 'levelThumbs' ),
		)
	);

    add_settings_field(
        'picturefill',
        'Enqueue Picturefill.js',
        'levelThumbs_picturefill_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_settings_section',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Provide a wider support for custom template tags that uses Srcset, with Picturefill.', 'levelThumbs' ),
        )
    );

    add_settings_field(
        'lazyload',
        'Enable lazyload',
        'levelThumbs_lazyload_callback',
        'levelThumbs_plugin_options',
        'levelThumbs_settings_section',
        array(        // The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate and enqueue <a href="#">Lazysizes</a> to lazyload Srcset-images that are pulled by custom template tags.', 'levelThumbs' ),
        )
    );

	register_setting(
		'levelThumbs_plugin_options',
		'levelThumbs_plugin_options',
		'validate_sanitize_input'
	);
}

add_action( 'admin_init', 'levelThumbs_plugin_initialize_cpt_options' );

//----------------------------------------------------------------------------------------------------------------------------------

function levelThumbs_options_callback() {
	echo '<p>' . __( 'Customize four new post thumbnail-sizes (widths) in pixel-values.<br/><strong>Tip:</strong> Match sizes with your mediaquery-breakpoints since the custom template tags brings Srcset to the table (pretty much what this plugin is about). <a href="#">What custom template tags are there?</a><br/><a href="#">Does this plugin add any other sizes?</a>', 'levelThumbs' ) . '</p>';
}

//-----------------------------------------------------------------------------------------------------------------------------------

function levelThumbs_betaQuery_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$betaQuery = $options['beta_query'];
	$html = '<input type="text" id="beta_query" name="levelThumbs_plugin_options[beta_query]" value="' . $betaQuery . '" />';
	$html .= '<label for="beta_query">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_charlieQuery_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$charlieQuery = $options['charlie_query'];
	$html = '<input type="text" id="charlie_query" name="levelThumbs_plugin_options[charlie_query]" value="' . $charlieQuery . '" />';
	$html .= '<label for="charlie_query">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function levelThumbs_deltaQuery_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$deltaQuery = $options['delta_query'];
	$html = '<input type="text" id="delta_query" name="levelThumbs_plugin_options[delta_query]" value="' . $deltaQuery . '" />';
	$html .= '<label for="delta_query">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}
function levelThumbs_echoQuery_callback($args) {
	$options = get_option( 'levelThumbs_plugin_options' );
	$echoQuery = $options['echo_query'];
	$html = '<input type="text" id="echo_query" name="levelThumbs_plugin_options[echo_query]" value="' . $echoQuery . '" />';
	$html .= '<label for="echo_query">&nbsp;'  . $args[0] . '</label>';
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