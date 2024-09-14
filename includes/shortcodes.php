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
	'woopspro_top_rated_products_slider',
	'woopspro_recently_viewed_products',
);

foreach ( $woopspro_shortcodes as $shortcode )
{	
	add_shortcode( $shortcode, 'woopspro_shortcode_callback' );
}

function woopspro_shortcode_callback( $atts, $content, $tag )
{
	extract( shortcode_atts( array(
		'cats' 							=> '',
		'tags' 							=> '',
		'skus' 							=> '',
		'ids' 							=> '',
		'tax' 							=> 'product_cat',
		'stock_status' 					=> '',
		'limit' 						=> '-1',
		'slide_to_show' 				=> '3',
		'slide_to_show_for_mobile' 		=> '1',
		'slide_to_show_for_tablet' 		=> '2',
		'slide_to_show_for_laptop' 		=> '3',
		'slide_to_scroll' 				=> '3',
		'slide_to_scroll_for_mobile' 	=> '1',
		'slide_to_scroll_for_tablet' 	=> '2',
		'slide_to_scroll_for_laptop' 	=> '3',
		'autoplay' 						=> 'true',
		'autoplay_speed' 				=> '3000',
		'speed' 						=> '300',
		'arrows' 						=> 'true',
		'dots' 							=> 'true',
		'rtl'  							=> '',
		'slider_cls'					=> 'products',
		'order'							=> 'ASC',
		'orderby'						=> 'menu_order',
		'meta_key'						=> '',
	), $atts ) );

	$cats 		= ( ! empty( $cats ) ) ? explode( ',', $cats ) : '';
	
	$tags 		= ( ! empty( $tags ) ) ? explode( ',', $tags ) : '';
	
	$skus 		= ( ! empty( $skus ) ) ? explode( ',', $skus ) : '';
	
	$ids 		= ( ! empty( $ids ) ) ? explode( ',', $ids ) : '';
	
	$slider_cls = ! empty( $slider_cls ) ? $slider_cls : 'products';

	// For RTL
	$rtl = woopspro_is_slider_rtl( $rtl );

	woopspro_enqueue_scripts();

	// Slider configuration
	$slider_conf = compact( 'slide_to_show', 'slide_to_show_for_mobile', 'slide_to_show_for_tablet', 'slide_to_show_for_laptop', 'slide_to_scroll', 'slide_to_scroll_for_mobile', 'slide_to_scroll_for_tablet', 'slide_to_scroll_for_laptop', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots', 'rtl', 'slider_cls' );

	ob_start();

		// setup query
		$args = woopspro_global_woo_query( $limit, $cats, $tags, $ids, $skus, $stock_status );

		if ( $atts )
		{
			foreach ( $atts as $key => $att )
			{
				if ( preg_match( '/^attribute_.+$/', $key ) )
				{
					$attr_name = sanitize_text_field( str_replace( 'attribute_', '', $key ) );

					$attr_values = ( ! empty( $att ) ) ? explode( ',', sanitize_text_field( $att ) ) : '';

					$args['tax_query'][] =
					[
				        'taxonomy'        => 'pa_' . $attr_name,
				        'field'           => 'slug',
				        'terms'           =>  $attr_values,
				        'operator'        => 'IN',
				    ];
				}
			}
		}

		$args['order'] = $order;
				
		$args['orderby'] = $orderby;

		if ( ! empty( $meta_key ) )
		{
			$args['meta_key'] = $meta_key;
		}

		switch ( $tag )
		{
			case 'woopspro_products_slider':

				if ( ! empty( $args['meta_query'] ) )
				{
					$args['meta_query'] = [
						$args['meta_query']
					];
				}
			
			break;

			case 'woopspro_bestselling_products_slider':
				
				$args['orderby'] = 'meta_value_num';
				
				$args['order'] 	 = 'DESC';

				unset( $args['meta_key'] );

				$args['meta_query'] = // get only products best sold
				[
					[
						'key' 		=> 'total_sales',
						'value' 	=> 0,
						'compare' 	=> '>',
					],
					! empty( $args['meta_query'] ) ? $args['meta_query'] : null
				];
			
			break;

			case 'woopspro_featured_products_slider':

				$args['tax_query'] = // get only featured products
				[
					[
				        'taxonomy' => 'product_visibility',
				        'field'    => 'name',
				        'terms'    => 'featured',
				        'operator' => 'IN',
					],
					! empty( $args['tax_query'] ) ? $args['tax_query'] : null
				];
			
			break;

			case 'woopspro_on_sale_products_slider':
				
				$args['meta_query'] =
				[
					[
						// Simple products type
						'relation' => 'OR',
			            [
			            	'key'           => '_sale_price',
			            	'value'         => 0,
			            	'compare'       => '>',
			            	'type'          => 'numeric'
			            ],
			            // Variable products type
			            [
			            	'key'           => '_min_variation_sale_price',
			            	'value'         => 0,
			            	'compare'       => '>',
			            	'type'          => 'numeric'
			            ]
					],
		            ! empty( $args['meta_query'] ) ? $args['meta_query'] : null
		        ];
			
			break;

			case 'woopspro_top_rated_products_slider':
				
				$args['meta_key']   = '_wc_average_rating';
				
				$args['orderby']    = 'meta_value_num';
				
				$args['order']      = 'DESC';

			break;

			case 'woopspro_recently_viewed_products':

				$cookie_name = WOOPSPRO_COOKIE_NAME;

				$post_ids_in = [0];

				if ( isset( $_COOKIE[$cookie_name] ) )
				{
					$data = json_decode( $_COOKIE[$cookie_name] );
					
					if ( $data && is_array( $data ) )
					{
						$post_ids_in = $data;
					}				
				}

				$args['post__in'] = $post_ids_in;

				$args['orderby'] = 'post__in';

				unset( $args['order'] );
				
				unset( $args['meta_key'] );
			
			break;
		}

		if ( isset( $args['meta_query'] ) && empty( $args['meta_query'] ) )
		{
			unset( $args['meta_query'] );
		}

		if ( isset( $args['tax_query'] ) && empty( $args['tax_query'] ) )
		{
			unset( $args['tax_query'] );
		}

		woopspro_generate_slider_html( $args, $slider_conf );

		wp_reset_postdata();

	return ob_get_clean();
}
