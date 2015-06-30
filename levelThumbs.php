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

            $userpathPicturefill = levelThumbs_get_option_url('userpathPicturefill');
            $userpathLazyload = levelThumbs_get_option_url('userpathLazyload');
            $userpathPicturefillAsync = $userpathPicturefill.'#levelThumbsAsyncload';
            $userpathLazyloadAsync = $userpathLazyload.'#levelThumbsAsyncload';

            // If user want all built in scripts, enqueue a bundled version...
            if(levelThumbs_get_option_boolean('picturefill') && levelThumbs_get_option_boolean('lazyload') && empty($userpathPicturefill) && empty($userpathLazyload)) {
                wp_enqueue_script('levelThumbsBundled', plugins_url('/js/bundled.min.js#levelThumbsAsyncload', __FILE__), array(), null, false);
            } else {

                // ...if not all built in scripts, check if they want picturefill at all...
                if(levelThumbs_get_option_boolean('picturefill')){
                    // ...yes? do they want their own / updated version?
                    if(empty($userpathPicturefill)){
                        // ... no? Run built in picurefill
                        wp_enqueue_script('picturefill', plugins_url('/js/picturefill.min.js#levelThumbsAsyncload', __FILE__), array(), null, false);
                    } else {
                        // ... Yes? Run picturefill user path
                        wp_enqueue_script('picturefill', $userpathPicturefillAsync, array(), null, false);
                    }
                } // end Picturefill conditional

                // ...if not all built in scripts, check if they want lazyload at all...
                if(levelThumbs_get_option_boolean('lazyload')){
                    // ...yes? do they want their own / updated version?
                    if(empty($userpathLazyload)){
                        // ... no? Run built in Lazysizes
                        wp_enqueue_script('lazysizes', plugins_url('/js/lazysizes.min.js#levelThumbsAsyncload', __FILE__), array(), null, false);
                    } else {
                        // ... Yes? Run Lazysizes user path
                        wp_enqueue_script('lazysizes', $userpathLazyloadAsync, array(), null, false);
                    }
                } // end lazyload conditional

            } // end conditional for bundled vs custom paths
            add_filter('clean_url', 'levelThumbs_async_forscript', 11, 1);
        }
        if(levelThumbs_get_option_boolean('picturefill') || levelThumbs_get_option_boolean('lazyload')) {
            add_action('wp_enqueue_scripts', 'levelThumbs_scripts');
        }
	}
}

new levelThumbs();