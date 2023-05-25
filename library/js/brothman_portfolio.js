(function($) {
	
$( document ).ready( function() {
	$( 'body' ).on( 'mouseover', '.bp_portfolio_item_cell', function() {
		$( this ).find( '.bp_portfolio_item_overlay' ).css( 'width', '100%' );
	});

	$( 'body' ).on( 'mouseout', '.bp_portfolio_item_cell', function() {
		$( this ).find( '.bp_portfolio_item_overlay' ).css( 'width', '0%' );
	});

	$( 'body' ).on( 'click', '.bp-portfolio-item-selector-image', function() {
		$( 'body' ).find( '.bp_portfolio_item_selected_image' ).removeClass( 'bp_portfolio_item_selected_image' );
		$( this ).addClass( 'bp_portfolio_item_selected_image' );

		var new_image = $( '.bp_portfolio_item_selected_image' ).attr('src');
		$( '.bp_singlepage_portfolio_item_huge_image img' ).attr( 'src', new_image );
	});


});

})( jQuery );