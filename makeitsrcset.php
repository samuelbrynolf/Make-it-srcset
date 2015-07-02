<?php
/*
Plugin Name: Make it Srcset
Plugin URI: http://note-to-helf.com/make-it-srcset/
Description: Handle responsive images with the srcset-attribute.
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
	die('Invalid URL');
}

class makeitsrcset {
	public function __construct(){
		add_action('plugins_loaded', array(&$this, 'mis_constants'), 1);
		add_action('plugins_loaded', array(&$this, 'mis_includes'), 2);
		add_action('plugins_loaded', array(&$this, 'mis_scripts'),3);
	}

	public function mis_constants(){
		define('mis_DIR', plugin_dir_path( __FILE__ ));
		define('mis_INCLUDES', mis_DIR . trailingslashit('mis_includes'));
	}

	public function mis_includes(){
		require_once(mis_INCLUDES . 'mis_settings.php');
		require_once(mis_INCLUDES . 'mis_functions.php');
	}

	public function mis_scripts(){
		function mis_enqueue_scripts(){

            $mis_userpathPicturefill = mis_get_option_url('userpathPicturefill');
            $mis_userpathLazyload = mis_get_option_url('userpathLazyload');
            $mis_userpathPicturefillAsync = $mis_userpathPicturefill.'#mis_asyncload';
            $mis_userpathLazyloadAsync = $mis_userpathLazyload.'#mis_asyncload';

            // If user want all built in scripts, enqueue a bundled version...
            if(mis_get_option_boolean('picturefill') && mis_get_option_boolean('lazyload') && empty($mis_userpathPicturefill) && empty($mis_userpathLazyload)) {
                wp_enqueue_script('mis_bundled', plugins_url('/mis_enqueue_scripts/mis_bundled.min.mis_enqueue_scripts#mis_asyncload', __FILE__), array(), null, false);
            } else {

                // ...if not all built in scripts, check if they want picturefill at all...
                if(mis_get_option_boolean('picturefill')){
                    // ...yes? do they want their own / updated version?
                    if(empty($mis_userpathPicturefill)){
                        // ... no? Run built in picurefill
                        wp_enqueue_script('picturefill', plugins_url('/mis_enqueue_scripts/mis_picturefill.min.mis_enqueue_scripts#mis_asyncload', __FILE__), array(), null, false);
                    } else {
                        // ... Yes? Run picturefill user path
                        wp_enqueue_script('picturefill', $mis_userpathPicturefillAsync, array(), null, false);
                    }
                } // end Picturefill conditional

                // ...if not all built in scripts, check if they want lazyload at all...
                if(mis_get_option_boolean('lazyload')){
                    // ...yes? do they want their own / updated version?
                    if(empty($mis_userpathLazyload)){
                        // ... no? Run built in Lazysizes
                        wp_enqueue_script('lazysizes', plugins_url('/mis_enqueue_scripts/mis_lazysizes.min.mis_enqueue_scripts#mis_asyncload', __FILE__), array(), null, false);
                    } else {
                        // ... Yes? Run Lazysizes user path
                        wp_enqueue_script('lazysizes', $mis_userpathLazyloadAsync, array(), null, false);
                    }
                } // end lazyload conditional

            } // end conditional for bundled vs custom paths
            add_filter('clean_url', 'mis_async_forscript', 11, 1);
        }
        if(mis_get_option_boolean('picturefill') || mis_get_option_boolean('lazyload')) {
            add_action('wp_enqueue_scripts', 'mis_enqueue_scripts');
        }
	}
}

new makeitsrcset();