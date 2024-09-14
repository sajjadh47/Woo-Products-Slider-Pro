jQuery( document ).ready( function( $ )
{
	$( '.woopspro-product-slider' ).each( function( index )
	{
		var slider_id   = $( this ).attr( 'id' );
		
		var slider_conf = $.parseJSON( $( this ).closest( '.woopspro-product-slider-wrap' ).find( '.woopspro-slider-conf' ).attr( 'data-conf' ) );
		
		var slider_cls	= slider_conf.slider_cls ? slider_conf.slider_cls : 'products';

		jQuery( '#' + slider_id + ' .' + slider_cls ).slick(
		{
			dots			: ( slider_conf.dots ) == "true" ? true : false,
			infinite		: true,
			arrows			: ( slider_conf.arrows ) == "true" ? true : false,
			speed			: parseInt( slider_conf.speed ),
			autoplay		: ( slider_conf.autoplay) == "true" ? true : false,
			autoplaySpeed	: parseInt( slider_conf.autoplay_speed ),
			slidesToShow	: parseInt( slider_conf.slide_to_show ),
			slidesToScroll	: parseInt( slider_conf.slide_to_scroll ),
			rtl             : ( slider_conf.rtl ) == "true" ? true : false,
			responsive: [
			{
				breakpoint: 1024,
				settings:
				{
					slidesToShow: parseInt( slider_conf.slide_to_show_for_laptop ) ? parseInt( slider_conf.slide_to_show_for_laptop ) : 3,
					slidesToScroll: parseInt( slider_conf.slide_to_scroll_for_laptop ) ? parseInt( slider_conf.slide_to_scroll_for_laptop ) : 3,
				}
			},
			{
				breakpoint: 769,
				settings:
				{
					slidesToShow: parseInt( slider_conf.slide_to_show_for_tablet ) ? parseInt( slider_conf.slide_to_show_for_tablet ) : 2,
					slidesToScroll: parseInt( slider_conf.slide_to_scroll_for_tablet ) ? parseInt( slider_conf.slide_to_scroll_for_tablet ) : 2,
				}
			},
			{
				breakpoint: 481,
				settings:
				{
					slidesToShow: parseInt( slider_conf.slide_to_show_for_mobile ) ? parseInt( slider_conf.slide_to_show_for_mobile ) : 1,
					slidesToScroll: parseInt( slider_conf.slide_to_scroll_for_mobile ) ? parseInt( slider_conf.slide_to_scroll_for_mobile ) : 1,
				}	    		
			}]
		});
	});
});