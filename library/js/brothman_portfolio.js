(function($) {
	
$( document ).ready( function() {
	$( 'body' ).on( 'mouseover', '.bp_portfolio_item_cell', function() {
		$( this ).find( '.bp_portfolio_item_overlay' ).css( 'width', '100%' );
	});

	$( 'body' ).on( 'mouseout', '.bp_portfolio_item_cell', function() {
		$( this ).find( '.bp_portfolio_item_overlay' ).css( 'width', '0%' );
	});

	$( 'body' ).on( 'click', '.bp-portfolio-item-selector-image', function() {
		$( 'body' ).find( '.bp-portfolio-item-selected-image' ).removeClass( 'bp-portfolio-item-selected-image' );
		$( this ).addClass( 'bp-portfolio-item-selected-image' );

		var new_image = $( '.bp-portfolio-item-selected-image' ).attr('src');
		$( '.bp_singlepage_portfolio_item_huge_image img' ).attr( 'src', new_image );
	});


});

})( jQuery );