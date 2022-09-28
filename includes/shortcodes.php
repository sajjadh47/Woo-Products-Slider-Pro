<?php

/**
 * Register All Shortcodes
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */

$woopspro_shortcodes = array(
	'woopspro_products_slider',
	'woopspro_bestselling_products_slider',
	'woopspro_featured_products_slider',
	'woopspro_on_sale_products_slider',
	'woopspro_top_rated_products_slider'
);

foreach ( $woopspro_shortcodes as $shortcode )
{	
	add_shortcode( $shortcode, $shortcode . '_callback' );
}

// normal products slider callback
function woopspro_products_slider_callback( $atts )
{
	extract( shortcode_atts( array(
		'cats' 				=> '',
		'ids' 				=> '',
		'tax' 				=> 'product_cat',
		'limit' 			=> '-1',
		'slide_to_show' 	=> '3',
		'slide_to_scroll' 	=> '3',
		'autoplay' 			=> 'true',
		'autoplay_speed' 	=> '3000',
		'speed' 			=> '300',
		'arrows' 			=> 'true',
		'dots' 				=> 'true',
		'rtl'  				=> '',
		'slider_cls'		=> 'products',
	), $atts ) );

	$cat 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';
	
	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl( $rtl );

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );
	
	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cat, $ids );

		$args['meta_query'] = 
		array(
			'key'       => '_visibility',
			'value'     => 'hidden',
			'compare'   => '!=',
		);

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}

// bestselling products slider callback
function woopspro_bestselling_products_slider_callback( $atts )
{
	extract( shortcode_atts( array(
		'cats' 				=> '',
		'ids' 				=> '',
		'tax' 				=> 'product_cat',
		'limit' 			=> '-1',
		'slide_to_show' 	=> '3',
		'slide_to_scroll' 	=> '3',
		'autoplay' 			=> 'true',
		'autoplay_speed' 	=> '3000',
		'speed' 			=> '300',
		'arrows' 			=> 'true',
		'dots' 				=> 'true',
		'rtl'  				=> '',
		'slider_cls'		=> 'products',
	), $atts ) );

	$cat 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';

	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl( $rtl );

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );
	
	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cat, $ids );

		$args['orderby'] = 'meta_value_num';
		$args['order'] 	 = 'DESC';
		$args['meta_query'] = 
		array(
			// get only products best sold
			array(
				'key' 		=> 'total_sales',
				'value' 	=> 0,
				'compare' 	=> '>',
			)
		);

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}

// featured products slider callback
function woopspro_featured_products_slider_callback( $atts )
{
	extract(  shortcode_atts( array(
		'cats' 				=> '',
		'ids' 				=> '',
		'tax' 				=> 'product_cat',
		'limit' 			=> '-1',
		'slide_to_show' 	=> '3',
		'slide_to_scroll' 	=> '3',
		'autoplay' 			=> 'true',
		'autoplay_speed' 	=> '3000',
		'speed' 			=> '300',
		'arrows' 			=> 'true',
		'dots' 				=> 'true',
		'rtl'  				=> '',
		'slider_cls'		=> 'products',
	), $atts ) );

	$cat 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';

	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl( $rtl );

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );
	
	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cat, $ids );

		$tax_query = WC()->query->get_tax_query();

		// setup tax query
		$tax_query[] = array(
	        'taxonomy' => 'product_visibility',
	        'field'    => 'name',
	        'terms'    => 'featured',
	        'operator' => 'IN',
		);

		$args['tax_query'] = $tax_query;

		$args['meta_query'] = 
		array(
			'key'       => '_visibility',
			'value'     => 'hidden',
			'compare'   => '!=',
		);

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}

// on sale products slider callback
function woopspro_on_sale_products_slider_callback( $atts )
{
	extract( shortcode_atts( array(
		'cats' 				=> '',
		'ids' 				=> '',
		'tax' 				=> 'product_cat',
		'limit' 			=> '-1',
		'slide_to_show' 	=> '3',
		'slide_to_scroll' 	=> '3',
		'autoplay' 			=> 'true',
		'autoplay_speed' 	=> '3000',
		'speed' 			=> '300',
		'arrows' 			=> 'true',
		'dots' 				=> 'true',
		'rtl'  				=> '',
		'slider_cls'		=> 'products',
	), $atts ) );

	$cat 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';

	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl( $rtl );

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );
	
	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cat, $ids );

		$args['meta_query'] = array(
			'relation' => 'OR',
            array( // Simple products type
            	'key'           => '_sale_price',
            	'value'         => 0,
            	'compare'       => '>',
            	'type'          => 'numeric'
            ),
            array( // Variable products type
            	'key'           => '_min_variation_sale_price',
            	'value'         => 0,
            	'compare'       => '>',
            	'type'          => 'numeric'
            )
        );

        $args['meta_query'][] = 
		array(
			'key'       => '_visibility',
			'value'     => 'hidden',
			'compare'   => '!=',
		);

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}

// top rated products slider callback
function woopspro_top_rated_products_slider_callback( $atts )
{
	extract( shortcode_atts( array(
		'cats' 				=> '',
		'ids' 				=> '',
		'tax' 				=> 'product_cat',
		'limit' 			=> '-1',
		'slide_to_show' 	=> '3',
		'slide_to_scroll' 	=> '3',
		'autoplay' 			=> 'true',
		'autoplay_speed' 	=> '3000',
		'speed' 			=> '300',
		'arrows' 			=> 'true',
		'dots' 				=> 'true',
		'rtl'  				=> '',
		'slider_cls'		=> 'products',
	), $atts ) );

	$cat 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';

	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl($rtl);

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );
	
	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cat, $ids );

		$args['meta_key']   = '_wc_average_rating';
		$args['orderby']    = 'meta_value_num';
		$args['order']      = 'DESC';

		$args['meta_query'] = 
		array(
			'key'       => '_visibility',
			'value'     => 'hidden',
			'compare'   => '!=',
		);

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}
