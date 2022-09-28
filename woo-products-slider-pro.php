<?php
/**
 * Plugin Name: Woo Products Slider Pro
 * Plugin URI: https://wordpress.org/plugins/woo-products-slider-pro/
 * Description: Display Woocommerce Products in a Carousel. Show Top Rated, Best Selling, ON Sale, Featured Products With Category Filter.
 * Author: Sajjad Hossain Sagor
 * Text Domain: woo-products-slider-pro
 * Domain Path: /languages/
 * WC tested up to: 6.8.2
 * Version: 1.0.4
 * Author URI: https://sajjadhsagor.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! defined( 'WOOPSPRO_ROOT_DIR' ) )
{
    define( 'WOOPSPRO_ROOT_DIR', dirname( __FILE__ ) ); // Plugin root dir
}

if( ! defined( 'WOOPSPRO_ROOT_URL' ) )
{
    define( 'WOOPSPRO_ROOT_URL', plugin_dir_url( __FILE__ ) ); // Plugin root url
}

/**
 * Check if WooCommerce plugin is active
 *
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_check_activation()
{
	if ( ! class_exists('WooCommerce') )
	{
		// is this plugin active?
		if ( is_plugin_active( plugin_basename( __FILE__ ) ) )
		{
			// deactivate the plugin
	 		deactivate_plugins( plugin_basename( __FILE__ ) );
	 		
	 		// unset activation notice
	 		unset( $_GET[ 'activate' ] );
	 		
	 		// display notice
	 		add_action( 'admin_notices', 'woopspro_admin_notices' );
		}
	}
}

// Check required plugin is activated or not
add_action( 'admin_init', 'woopspro_check_activation' );

/**
 * Admin notices
 * 
 * @package Woo Product Slider Pro
 * @since 1.0.0
 */
function woopspro_admin_notices()
{	
	if ( ! class_exists( 'WooCommerce' ) )
	{
		echo '<div class="error notice is-dismissible">';
		
			echo sprintf( __('<p><strong>%s</strong> recommends the following plugin to use.</p>', 'woo-products-slider-pro' ), 'Woo Products Slider Pro' );
		
			echo sprintf( __('<p><strong><a href="%s" target="_blank">%s</a> </strong></p>', 'woo-products-slider-pro' ), 'https://wordpress.org/plugins/woocommerce/', 'WooCommerce' );
		
		echo '</div>';
	}
}

/**
 * Load the plugin after the main plugin is loaded.
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_load_plugin()
{
	// Check main plugin is active or not
	if( class_exists( 'WooCommerce' ) )
	{
		/**
		 * Add Go To Settings Page in Plugin List Table
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'woopspro_goto_settings_page_link' );

		function woopspro_goto_settings_page_link ( $links )
		{ 	
		 	$goto_settings_link = array( '<a href="' . admin_url( 'edit.php?post_type=product&page=woopspro-products-slider' ) . '">'. __( 'Settings', 'woo-products-slider-pro' ) .'</a>' );
			
			return array_merge( $links, $goto_settings_link );
		}

		/**
		 * Load Text Domain
		 * This gets the plugin ready for translation
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		function woopspro_load_textdomain()
		{
			load_plugin_textdomain( 'woo-products-slider-pro', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
		}

		// Action to load plugin text domain
		add_action( 'plugins_loaded', 'woopspro_load_textdomain' );

		/**
		 * Function to add frontend scripts and styles
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		function woopspro_enqueue_frontend_scripts()
		{	
			// Slick CSS
			wp_enqueue_style( 'woopspro-slick-css',  WOOPSPRO_ROOT_URL . 'assets/css/slick.css', array(), time() );				
			
			wp_enqueue_style( 'woopspro-custom-style',  WOOPSPRO_ROOT_URL . 'assets/css/style.css', array(), time() );		
			
			// Registring slick slider script
			wp_register_script( 'woopspro-slick-script', WOOPSPRO_ROOT_URL . 'assets/js/slick.min.js', array( 'jquery' ), time(), true );				

			// Custom script
			wp_register_script( 'woopspro-custom-script', WOOPSPRO_ROOT_URL . 'assets/js/script.js', array( 'jquery' ), time(), true );			
		}

		// Action to add some style and script
		add_action( 'wp_enqueue_scripts', 'woopspro_enqueue_frontend_scripts' );
		
		// Adding Admin Side Scripts
		add_action( 'admin_enqueue_scripts', 'woopspro_admin_enqueue_scripts' );

		/**
		 * Function to add admin scripts and styles
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		function woopspro_admin_enqueue_scripts()
		{	
			// bootstrap, select2 & custom styles
			wp_register_style( 'woopspro-admin-custom-style',  WOOPSPRO_ROOT_URL . 'admin/assets/css/style-admin.min.css', array(), time() );
		
			// bootstrap , select2 & Custom scripts
			wp_register_script( 'woopspro-admin-custom-script', WOOPSPRO_ROOT_URL.'admin/assets/js/script-admin.min.js', array( 'jquery' ), time(), true );
		}

		// Including plugin files
		require ( 'includes/helper-functions.php' );
		
		require ( 'includes/shortcodes.php' );
		
		require ( 'admin/woo-products-slider-pro-admin.php' );
	}
}

// Action to load plugin after the main plugin is loaded
add_action( 'plugins_loaded', 'woopspro_load_plugin', 15 );
