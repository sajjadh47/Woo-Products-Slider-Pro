<?php

/**
 * Function to unique number value
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_get_unique_number()
{    
    static $unique = 0;
    
    $unique++;

    return $unique;
}

/**
 * Function to enqueue scripts
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_enqueue_scripts()
{    
	wp_enqueue_script( 'woopspro-slick-script' );
	
	wp_enqueue_script( 'woopspro-custom-script' );
}

/**
 * Function to check slider direction
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_is_slider_rtl( $rtl )
{    
	return ( empty( $rtl ) && is_rtl() || $rtl == 'true' ) ? 'true' : 'false';
}

/**
 * Function to generate global woocommerce product query
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_global_woo_query( $limit , $cats, $tags, $ids, $skus, $stock_status )
{
	// setup query
	$args = [
		'post_type' 			=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page'		=> $limit,
	];

	$args['meta_query'] = [];
	
	$args['tax_query'] = [];

	// Category Parameter
	if( $cats != "" )
	{
		$args['tax_query'][] = 
		[
			'taxonomy' 	=> 'product_cat',
			'field' 	=> 'id',
			'terms' 	=> $cats
		];
	}

	// Tag Parameter
	if( $tags != "" )
	{
		$args['tax_query'][] = 
		[
			'taxonomy' 	=> 'product_tag',
			'field' 	=> 'id',
			'terms' 	=> $tags
		];
	}

	// Stock Status Parameter
	if( $stock_status != "" )
	{
		array_push( $args['meta_query'],
		[
			'key' 		=> '_stock_status',
			'value' 	=> $stock_status
		] );
	}

	// SKU Parameter
	if( $skus != "" )
	{
		array_push( $args['meta_query'],
		[
			'key' 		=> '_sku',
			'compare' 	=> 'IN',
			'value' 	=> $skus
		] );
	}

	// id Parameter
	if( $ids != "" )
	{
		$args['post__in'] = $ids;
	}

	return $args;
}

/**
 * Function to generate woo products slider html
 * 
 * @package Woo Products Slider Pro
 * @since 1.0.0
 */
function woopspro_generate_slider_html( $args, $slider_conf )
{
	// query database
	$products = new WP_Query( $args );

	if ( $products->have_posts() ) : ?>
		<div class="woopspro-product-slider-wrap">
			<div class="woocommerce woopspro-product-slider" id="woopspro-product-slider-<?php echo woopspro_get_unique_number(); ?>">
			<?php
				woocommerce_product_loop_start();
					while ( $products->have_posts() ) : $products->the_post();
						wc_get_template_part( 'content', 'product' );
					endwhile; // end of the loop.
				woocommerce_product_loop_end();
 			?>
			</div>
			<div class="woopspro-slider-conf" data-conf="<?php echo htmlspecialchars( json_encode( $slider_conf ) ); ?>"></div>
		</div>
	<?php 
	endif;
}

// template include function
function woopspro_include_template( $name , $options = [] )
{
	include WOOPSPRO_ROOT_DIR . "/admin/templates/$name.php";
}

add_action( 'wp_ajax_woopspro_get_woo_products_option_html', 'woopspro_get_woo_products_option_html' );

// woocommerce get all product as Select options
function woopspro_get_woo_products_option_html()
{
	$search = isset( $_REQUEST['search'] ) && ! empty( $_REQUEST['search'] ) ? sanitize_text_field( $_REQUEST['search'] ) : '';
	
	$results = [ 'results' => [] ];

	if ( ! empty( $search ) )
	{
		$args = [
		    'post_type' 		=> 'product', 
		    'posts_per_page' 	=> -1,
		    's' 				=> $search
		];

		$wcProductsArray = get_posts( $args );

		foreach ( $wcProductsArray as $product )
		{
			$results['results'][] = [ 'id' => $product->ID, 'text' => $product->post_title ];
		}	
	}

	wp_send_json_success( $results ); die();
}

// woocommerce get all product statuses as Select options
function woopspro_get_woo_stock_status_option_html()
{
	$all_statuses = wc_get_product_stock_status_options();

	$html = '';

	foreach ( $all_statuses as $status_name => $status_label )
	{
		$html .= "<option value='{$status_name}'>{$status_label}</option>";
	}

	return $html;
}

// woocommerce get all product cats as Select options
function woopspro_get_woo_cats_option_html()
{
	$all_cats = get_categories( [ 'taxonomy' => 'product_cat', 'orderby' => 'name', 'hide_empty' => 1 ] );

	$html = '';

	foreach ( $all_cats as $cat )
	{
		$html .= "<option value='{$cat->term_id}'>{$cat->name}</option>";
	}

	return $html;
}

// woocommerce get all product tags as Select options
function woopspro_get_woo_tags_option_html()
{
	$all_tags = get_categories( [ 'taxonomy' => 'product_tag', 'orderby' => 'name', 'hide_empty' => 1 ] );

	$html = '';

	foreach ( $all_tags as $tag )
	{
		$html .= "<option value='{$tag->term_id}'>{$tag->name}</option>";
	}

	return $html;
}

add_action( 'wp_ajax_woopspro_get_woo_skus_option_html', 'woopspro_get_woo_skus_option_html' );

// woocommerce get all product skus as Select options
function woopspro_get_woo_skus_option_html()
{
	$search = isset( $_REQUEST['search'] ) && ! empty( $_REQUEST['search'] ) ? sanitize_text_field( $_REQUEST['search'] ) : '';
	
	$results = [ 'results' => [] ];

	if ( ! empty( $search ) )
	{
		$args = [
		    'post_type' 		=> 'product', 
		    'posts_per_page' 	=> -1,
		    's' 				=> $search
		];

		$wcProductsArray = get_posts( $args );

		foreach ( $wcProductsArray as $product )
		{
			$productSKU = get_post_meta( $product->ID, '_sku', true );
			
			$results['results'][] = [ 'id' => $productSKU, 'text' => $productSKU ];
		}	
	}

	wp_send_json_success( $results ); die();
}

// woocommerce get all product attributes as Select options
function woopspro_get_woo_attributes_option_html()
{
	$attributes = wc_get_attribute_taxonomies();

	$html = '';

	foreach ( $attributes as $attribute )
	{		
		$html .= "<option value='{$attribute->attribute_name}'>{$attribute->attribute_label}</option>";
	}

	return $html;
}
