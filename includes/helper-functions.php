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
function woopspro_global_woo_query( $limit , $cat, $ids = '' )
{
	// setup query
	$args = array(
		'post_type' 			=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page'		=> $limit,
	);

	// Category Parameter
	if( $cat != "" )
	{
		$args['tax_query'] = 
		array(
			array( 
				'taxonomy' 	=> 'product_cat',
				'field' 	=> 'id',
				'terms' 	=> $cat
			)
		);
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
function woopspro_include_template( $name , $options = array() )
{
	include WOOPSPRO_ROOT_DIR . "/admin/templates/$name.php";
}

// woocommerce get all product cats as Select options
function woopspro_get_woo_cats_option_html()
{
	$all_cats = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'name', 'hide_empty'   => 1 ) );

	$html = '';

	foreach ( $all_cats as $cat )
	{
		$html .= "<option value='{$cat->term_id}'>{$cat->name}</option>";
	}

	return $html;
}
