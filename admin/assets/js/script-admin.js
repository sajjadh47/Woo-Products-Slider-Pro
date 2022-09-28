jQuery( document ).ready( function( $ )
{
	$( 'select.cat_filter' ).each( function( index, el )
	{
		$( el ).select2();
	});

	// after generate button click generate shortcode based on inputs
	$( '.generate_btn' ).on( 'click', function( event )
	{
		event.preventDefault();

		var values = $( this ).closest( 'form' ).serializeArray();

		var shortcode = '[';

		shortcode += $( this ).closest( 'form' ).data( 'shortcode' );

		var cats = " cats='";

		$.each( values, function( index, val )
		{	 
			if ( val.name == 'cat_filter' )
			{
				cats += val.value + ",";
			}
			else
			{
				if ( val.value !== '' )
				{
					shortcode += " " + val.name + "='" + val.value + "'";	
				}
			}
		});

		cats += "'";

		shortcode = $.trim( shortcode ) + cats.replace( ",'", "'" ) + "]";

		$( this ).closest( 'form' ).parent().find( '.slider_shortcode_code' ).text( shortcode );
	});

	$( '.customize_shortcode_form' ).on( 'hidden.bs.collapse', function( event )
	{
		// restore the default shortcode
		$( this ).parent().find( '.slider_shortcode_code' ).text( $( this ).data( 'shortcode' ) );

		// clear the form values
		$( this ).trigger( "reset" );

		$( this ).find( 'select' ).val( null ).trigger( 'change' );
	});
});