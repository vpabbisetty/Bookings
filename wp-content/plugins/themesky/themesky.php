<?php 
/**
 * Plugin Name: ThemeSky
 * Plugin URI: http://theme-sky.com
 * Description: Add shortcodes and custom post types for BoxShop Theme
 * Version: 1.2.1
 * Author: ThemeSky Team
 * Author URI: http://theme-sky.com
 */ 
if( !defined('THEMESKY_VERSION') ){
	define('THEMESKY_VERSION', '1.2.1');
}

class ThemeSky_Plugin{

	function __construct(){
		$this->load_language_file();
		$this->include_files();
		$this->register_widgets();
		
		/* Fix bbpress setup current user */
		remove_action( 'set_current_user', 'bbp_setup_current_user', 10);
		add_action( 'init', array($this, 'bbp_setup_current_user'));
		
		add_action('template_redirect', array($this, 'template_redirect'));
		
		/* Dont support custom header */
		add_action('after_setup_theme', array($this, 'remove_theme_support_custom_header'), 99 );
	}
	
	function load_language_file(){
		load_plugin_textdomain('themesky', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	function include_files(){
		require_once('functions.php');
		require_once('register_post_type.php');
		require_once('class-shortcodes.php');
		require_once('woo_term.php');
		require_once('woo_filter_by_color.php');
		require_once('metaboxes/metaboxes.php');
		require_once('includes/twitteroauth.php');
	}
	
	function register_widgets(){
		$file_names = array('single_image', 'footer_block', 'twitter', 'gravatar_profile', 'mailchimp_subscription', 'product_filter_by_color'
							, 'product_filter_by_availability', 'social_icons', 'products', 'products_tabs', 'blogs', 'recent_comments'
							, 'facebook_page', 'flickr', 'instagram', 'product_categories');
		foreach( $file_names as $file_name ){
			$file = plugin_dir_path( __FILE__ ) . '/widgets/' . $file_name . '.php';
			if( file_exists($file) ){
				require_once($file);
			}
		}
	}
	
	function bbp_setup_current_user(){
		if( function_exists('bbp_setup_current_user') ){
			add_action( 'set_current_user', 'bbp_setup_current_user', 10);
		}
	}
	
	function template_redirect(){
		if( is_singular('product') ){
			add_filter('wp_get_attachment_image_attributes', function( $attr ){
				if( isset($attr['sizes']) ){
					unset($attr['sizes']);
				}
				if( isset($attr['srcset']) ){
					unset($attr['srcset']);
				}
				return $attr;
			}, 9999);
			add_filter('wp_calculate_image_sizes', '__return_false', 9999);
			add_filter('wp_calculate_image_srcset', '__return_false', 9999);
			remove_filter('the_content', 'wp_make_content_images_responsive');
		}
	}
	
	function remove_theme_support_custom_header(){
		remove_theme_support( 'custom-header' );
	}
	
}
new ThemeSky_Plugin();
?>