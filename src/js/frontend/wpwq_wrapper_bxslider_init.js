/*
	grunt.concat_in_order.declare('wpwq_wrapper_bxslider_init');
	grunt.concat_in_order.require('init');
*/

jQuery(document).ready(function($bx) {

		if ( $bx( '.wpwq-query-wrapper.bxslider' ).length ) {
		var bxOptions;
		var unique;
		var unique_options;
		var key;
		var val;
		
		$bx( '.wpwq-query-wrapper.bxslider' ).each( function( index ) {
				
			// set dafault options
			bxOptions = Wpwq_wrapper_bxslider.global.bx_options;
			
			// get options from Wpwq_wrapper_bxslider
			unique = $bx( this ).attr('class').match(/\S*-unique\b/)[0].replace( '-unique', '');
			unique_options =  Wpwq_wrapper_bxslider[unique];
			
			// replace default options with options from Wpwq_wrapper_bxslider
			for ( key in unique_options ){
				if (unique_options.hasOwnProperty(key)) {
					if ( isNaN( unique_options[key] ) ){
						val = unique_options[key];
					} else {
						val =  parseFloat(unique_options[key]);
					}
					bxOptions[key] = val;
				}
			}
			
			$bx( this ).children( 'ul.bxslider' ).bxSlider( bxOptions );
		});
	}
		
});