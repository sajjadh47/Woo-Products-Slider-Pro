<?php
/**
 * Plugin Name: Woo Products Slider Pro
 * Plugin URI: https://wordpress.org/plugins/woo-products-slider-pro/
 * Description: Display Woocommerce Products in a Carousel. Show Top Rated, Best Selling, ON Sale, Featured, Recently Viewed Products With Category Filter.
 * Author: Sajjad Hossain Sagor
 * Text Domain: woo-products-slider-pro
 * Domain Path: /languages/
 * WC tested up to: 9.3
 * Version: 1.1.4
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

if( ! defined( 'WOOPSPRO_COOKIE_NAME' ) )
{
    define( 'WOOPSPRO_COOKIE_NAME', 'woopspro_recently_viewed_products' ); // Plugin cookie name
}

if( ! defined( 'WOOPSPRO_PLUGIN_VERSION' ) )
{
    define( 'WOOPSPRO_PLUGIN_VERSION', '1.1.4' ); // Plugin current version
}

/**
 * Check if WooCommerce plugin is active
 *
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_check_activation()
{
	if ( ! class_exists( 'WooCommerce' ) )
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
		
			echo sprintf( __('<p><strong>%s</strong> requires the following plugin to be installed & activated.</p>', 'woo-products-slider-pro' ), 'Woo Products Slider Pro' );
		
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
		function woopspro_goto_settings_page_link ( $links )
		{ 	
		 	$goto_settings_link = array( '<a href="' . admin_url( 'edit.php?post_type=product&page=woopspro-products-slider' ) . '">'. __( 'Settings', 'woo-products-slider-pro' ) .'</a>' );
			
			return array_merge( $links, $goto_settings_link );
		}

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'woopspro_goto_settings_page_link' );

		/**
		 * Load Text Domain
		 * This gets the plugin ready for translation
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		function woopspro_load_textdomain()
		{
			load_plugin_textdomain( 'woo-products-slider-pro', '', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
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
			wp_enqueue_style( 'woopspro-slick-css',  WOOPSPRO_ROOT_URL . 'assets/css/slick.css', array(), WOOPSPRO_PLUGIN_VERSION );
			
			wp_enqueue_style( 'woopspro-custom-style',  WOOPSPRO_ROOT_URL . 'assets/css/style.css', array(), WOOPSPRO_PLUGIN_VERSION );
			
			// Registring slick slider script
			wp_register_script( 'woopspro-slick-script', WOOPSPRO_ROOT_URL . 'assets/js/slick.min.js', array( 'jquery' ), WOOPSPRO_PLUGIN_VERSION, true );

			// Custom script
			wp_register_script( 'woopspro-custom-script', WOOPSPRO_ROOT_URL . 'assets/js/script.js', array( 'jquery' ), WOOPSPRO_PLUGIN_VERSION, true );
		}

		// Action to add some style and script
		add_action( 'wp_enqueue_scripts', 'woopspro_enqueue_frontend_scripts' );

		/**
		 * Function to add admin scripts and styles
		 * 
		 * @package Woo Products Slider Pro
		 * @since 1.0.0
		 */
		function woopspro_admin_enqueue_scripts()
		{	
			// bootstrap, select2 & custom styles
			wp_register_style( 'woopspro-admin-custom-style',  WOOPSPRO_ROOT_URL . 'admin/assets/css/style-admin.min.css', array(), WOOPSPRO_PLUGIN_VERSION );
		
			// bootstrap, select2 & Custom scripts
			wp_register_script( 'woopspro-admin-custom-script', WOOPSPRO_ROOT_URL . 'admin/assets/js/script-admin.min.js', array( 'jquery' ), WOOPSPRO_PLUGIN_VERSION, true );
		}

		// Adding Admin Side Scripts
		add_action( 'admin_enqueue_scripts', 'woopspro_admin_enqueue_scripts' );

		// Including plugin files
		require ( 'includes/helper-functions.php' );
		
		require ( 'includes/shortcodes.php' );
		
		require ( 'admin/woo-products-slider-pro-admin.php' );

		// add recently viewed products in the cookie
		add_action( 'template_redirect', function()
		{
			if( is_product() )
			{
				global $post;

				$post_id = $post->ID;

				$cookie_name = WOOPSPRO_COOKIE_NAME;

				if ( $post_id )
				{
					if ( isset( $_COOKIE[$cookie_name] ) )
					{
						$data = json_decode( $_COOKIE[$cookie_name] );
						
						if ( $data && is_array( $data ) )
						{
							array_unshift( $data, $post_id );
						}
						else
						{
							$data = [$post_id];
						}

						$data = array_slice( array_unique( $data ), 0, 10 );
						
						setcookie( $cookie_name, json_encode( $data ), time() + ( 86400 * 7 ), "/" ); // 86400 = 1 day
					}
					else
					{
						setcookie( $cookie_name, json_encode( [$post_id] ), time() + ( 86400 * 7 ), "/" ); // 86400 = 1 day
					}
				}
			}
		} );
	}
}

// Action to load plugin after the main plugin is loaded
add_action( 'plugins_loaded', 'woopspro_load_plugin', 15 );

add_action( 'wp_ajax_woopspro_get_product_attributes_terms', function()
{
	$attributes = [];
	
	if ( isset( $_POST['attributes'] ) && ! empty( $_POST['attributes'] ) )
	{
		foreach ( $_POST['attributes'] as $attr )
		{
			$attributes[] = sanitize_text_field( $attr );
		}
	}

	if ( $attributes )
	{
		foreach ( $attributes as $att )
		{
			$terms = get_terms( 'pa_' . $att );

			if ( $terms )
			{
				?>
					<div class="row attribute_terms">
						<div class="form-group col-md-12">
							<label for="<?php echo $att; ?>_attribute_term_filter"><?php echo __( 'Filter By ' . ucfirst( $att ) . ' Attribute','woo-products-slider-pro' ); ?></label>
							<select name="<?php echo $att; ?>_attribute_term_filter" id="<?php echo $att; ?>_attribute_term_filter" class="select2 attribute_term_filter form-control" multiple="multiple">
							<?php
							
								foreach ( $terms as $term )
								{
									$slug 		= $term->slug;

									$termname 	= $term->name;

									echo "<option value='{$slug}'>{$termname}</option>";
								}

							?>
							</select>
						</div>
					</div>
				<?php
			}
		}	
	}

	die();
} );

// Woocommerce High Performance Order Storage compatibility
add_action( 'before_woocommerce_init', function()
{
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) )
	{
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
