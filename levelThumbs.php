<?php
/*
Plugin Name: Level-my-postthumbs
Plugin URI: http://note-to-helf.com/wordpress-plugin-Level-my-postthumbs/
Description: Level up post thumbnails.
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
	die('Invalid URL');
}

class levelThumbs {
	public function __construct(){
		add_action('plugins_loaded', array(&$this, 'constants'), 1);
		add_action('plugins_loaded', array(&$this, 'includes'), 2);
		add_action('plugins_loaded', array(&$this, 'scripts'),3);
	}

	public function constants(){
		define('levelThumbs_DIR', plugin_dir_path( __FILE__ ));
		define('levelThumbs_INCLUDES', levelThumbs_DIR . trailingslashit('includes'));
	}

	public function includes(){
		require_once(levelThumbs_INCLUDES . 'levelThumbs_settings.php');
		require_once(levelThumbs_INCLUDES . 'levelThumbs_functions.php');
	}

	public function scripts(){
		function levelThumbs_scripts(){

            // If user want all built in scripts, enqueue a bundled version...
            if(levelThumbs_get_option_boolean('picturefill') && levelThumbs_get_option_boolean('lazyload') && !levelThumbs_get_option_string('userpathPolyfill') && !levelThumbs_get_option_string('userpathLazyload')) {
                wp_enqueue_script('levelThumbsBundled', plugins_url('/js/bundled.min.js#asyncload', __FILE__), array(), null, false);
            } else {

                // ...if not, check if they want picturefill...
                if(levelThumbs_get_option_boolean('picturefill')){
                    // ...yes? do they want their own / updated version?
                    if(levelThumbs_get_option_string('userpathPolyfill')){
                        // enqueue new poly path
                    } else {
                        // ... no? Run built in picurefill
                        wp_enqueue_script('picturefill', plugins_url('/js/picturefill.min.js#asyncload', __FILE__), array(), null, false);
                    }
                } // end polyfill conditional

                // ...if not, check if they want to lazyload...
                if(levelThumbs_get_option_boolean('lazyload')){
                    // ...yes? do they want their own / updated version?
                    if(levelThumbs_get_option_string('userpathLazyload')){
                        // enqueue new lazyversion path
                    } else {
                        // ... no? Run built in picurefill
                        wp_enqueue_script('lazysizes', plugins_url('/js/lazysizes.min.js#asyncload', __FILE__), array(), null, false);
                    }
                } // end lazyolad conditional

            } // end conditional for bundled vs custom paths

        }
		add_action('wp_enqueue_scripts', 'levelThumbs_scripts');
	}
}

new levelThumbs();