<?php
/**
 * Woo Products Slider Shortcode Generator
 *
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Action to add menu
add_action( 'admin_menu', 'woopspro_register_shortcode_generator_page' );

/**
 * Register plugin design page in admin menu
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_register_shortcode_generator_page()
{
	add_submenu_page( 
		'edit.php?post_type=product',
		__( 'Products Slider Pro', 'woo-products-slider-pro' ),
		__( 'Products Slider Pro', 'woo-products-slider-pro' ),
		'manage_options',
		'woopspro-products-slider',
		'woopspro_slider_shortcode_generator_page'
	);
}

/**
 * Function to display plugin design HTML
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_slider_shortcode_generator_page()
{
	// enqueue admin scripts & stylesheets
	wp_enqueue_style( 'woopspro-admin-custom-style' );
	
	wp_enqueue_script( 'woopspro-admin-custom-script' );

	// add header
	woopspro_include_template( 'header' );

		woopspro_include_template( 'shortcode-column', array( 'id' => 'all_products', 'title' => __( 'All Products Slider Shortcode', 'woo-products-slider-pro' ), 'shortcode' => 'woopspro_products_slider' ) );
		
		woopspro_include_template( 'shortcode-column', array( 'id' => 'bestselling_products', 'title' => __( 'Best Selling Products Slider Shortcode', 'woo-products-slider-pro' ), 'shortcode' => 'woopspro_bestselling_products_slider' ) );
		
		woopspro_include_template( 'shortcode-column', array( 'id' => 'featured_products', 'title' => __( 'Featured Products Slider Shortcode', 'woo-products-slider-pro' ), 'shortcode' => 'woopspro_featured_products_slider' ) );
		
		woopspro_include_template( 'shortcode-column', array( 'id' => 'on_sale_products', 'title' => __( 'ON Sale Products Slider Shortcode', 'woo-products-slider-pro' ), 'shortcode' => 'woopspro_on_sale_products_slider' ) );

		woopspro_include_template( 'shortcode-column', array( 'id' => 'top_rated_products', 'title' => __( 'Top Rated Products Slider Shortcode', 'woo-products-slider-pro' ), 'shortcode' => 'woopspro_top_rated_products_slider' ) );

	woopspro_include_template( 'footer' );
}
