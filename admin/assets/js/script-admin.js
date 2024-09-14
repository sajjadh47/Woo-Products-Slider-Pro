jQuery( document ).ready( function( $ )
{
    $( 'select.select2' ).each( function( index, el )
    {
        $( el ).select2();
    } );

    $( 'select[name="specific_products_filter"]' ).select2(
    {
        ajax:
        {
            url: ajaxurl,
            data: function ( params )
            {
                var query = {
                    search: params.term,
                    action: 'woopspro_get_woo_products_option_html'
                }

                // Query parameters will be ?search=[term]&action=woopspro_get_woo_products_option_html
                return query;
            },
            processResults: function ( data )
            {                
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: $.map( data.data.results, function( obj )
                    {
                        return { id: obj.id, text: obj.text };
                    } )
                };
            },
            delay: 1000, // wait 1000 milliseconds before triggering the request
            cache: true,
            minimumInputLength: 3
        }
    } );

    $( 'select[name="sku_filter"]' ).select2(
    {
        ajax:
        {
            url: ajaxurl,
            data: function ( params )
            {
                var query = {
                    search: params.term,
                    action: 'woopspro_get_woo_skus_option_html'
                }

                // Query parameters will be ?search=[term]&action=woopspro_get_woo_skus_option_html
                return query;
            },
            processResults: function ( data )
            {                
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: $.map( data.data.results, function( obj )
                    {
                        return { id: obj.id, text: obj.text };
                    } )
                };
            },
            delay: 1000, // wait 1000 milliseconds before triggering the request
            cache: true,
            minimumInputLength: 3
        }
    } );

    // after generate button click generate shortcode based on inputs
    $( '.generate_btn' ).on( 'click', function( event )
    {
        event.preventDefault();

        var values = $( this ).closest( 'form' ).serializeArray();

        var form = $( this ).closest( 'form' );

        var shortcode = '[';

        shortcode += $( this ).closest( 'form' ).data( 'shortcode' );

        var ids = " ids='";
        
        var cats = " cats='";
        
        var tags = " tags='";
        
        var skus = " skus='";
        
        var attribute_filter = "";

        $.each( values, function( index, val )
        {    
            if ( val.name == 'specific_products_filter' )
            {
                ids += val.value + ",";
            }
            else if ( val.name == 'cat_filter' )
            {
                cats += val.value + ",";
            }
            else if ( val.name == 'tag_filter' )
            {
                tags += val.value + ",";
            }
            else if ( val.name == 'sku_filter' )
            {
                skus += val.value + ",";
            }
            else if ( val.name == 'attribute_filter' )
            {
                attribute_filter += ' attribute_' + val.value + "='" + $( form ).find( '#' + val.value + '_attribute_term_filter' ).val().join( ',' ) + "'";
            }
            else if( val.name.indexOf( 'attribute_term_filter' ) < 0 )
            {
                if ( val.value !== '' )
                {
                    shortcode += " " + val.name + "='" + val.value + "'";
                }
            }
        } );

        ids += "'";
        
        cats += "'";
        
        tags += "'";
        
        skus += "'";

        if ( $( this ).closest( 'form' ).data( 'shortcode' ) == 'woopspro_recently_viewed_products' )
        {
            shortcode = $.trim( shortcode ) + "]";;
        }
        else
        {
            shortcode = $.trim( shortcode ) + ids.replace( ",'", "'" ) + cats.replace( ",'", "'" ) + tags.replace( ",'", "'" ) + skus.replace( ",'", "'" ) + attribute_filter + "]";
        }

        if ( ids == " ids=''" )
        {
            shortcode = shortcode.replace( " ids=''", '' );
        }

        if ( cats == " cats=''" )
        {
            shortcode = shortcode.replace( " cats=''", '' );
        }

        if ( tags == " tags=''" )
        {
            shortcode = shortcode.replace( " tags=''", '' );
        }

        if ( skus == " skus=''" )
        {
            shortcode = shortcode.replace( " skus=''", '' );
        }

        $( this ).closest( 'form' ).parent().find( '.slider_shortcode_code' ).text( shortcode );
    } );

    $( '.attribute_filter' ).on( 'change input keyup', function()
    {
        var $target = $( this ).closest( '.row' );

        var form = $( this ).closest( 'form' );
        
        $.post( ajaxurl, { action: 'woopspro_get_product_attributes_terms', attributes: $( this ).val() }, function( response )
        {
            $( '.attribute_terms' ).remove();

            $target.after( response );

            $( 'select.select2' ).each( function( index, el )
            {
                $( el ).select2();
            });
        } );
    } );

    $( '.customize_shortcode_form' ).on( 'hidden.bs.collapse', function( event )
    {
        // restore the default shortcode
        $( this ).parent().find( '.slider_shortcode_code' ).text( $( this ).data( 'shortcode' ) );

        // clear the form values
        $( this ).trigger( "reset" );

        $( this ).find( 'select' ).val( null ).trigger( 'change' );
    } );
} );