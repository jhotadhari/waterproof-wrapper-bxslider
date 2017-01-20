<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_bxslider_single');
	grunt.concat_in_order.require('init');
*/

class Wpwq_wrapper_bxslider_single extends Wpwq_wrapper_single {
	
	function __construct( $name = null, $query_single_obj = null , $args = null, $args_single = null ) {
		parent::__construct( $name, $query_single_obj , $args, $args_single );
		$this->set_inner( $query_single_obj );
	}
		
	protected function set_inner( $query_single_obj ) {

		$is_linked = ( array_key_exists('has_link', $this->args ) && $this->args['has_link'] == 'true' && strlen($query_single_obj['str_link']) > 0 ? true : false );
		
		$return = '';
		
		$return .= '<li>';
			$return .= '<div class="bxslider-inner">';
			
			$return .= '<div class="silder-header postheader">';
				if ($is_linked) $return .= '<a href="' . $query_single_obj['link'] . '">';

					$return .= '<h3>' . $query_single_obj['str_title'] . '</h3>';
				if ($is_linked) $return .= '</a>';

			$return .= '</div>';
				
			if ( strlen($query_single_obj['image_url']) > 0 ) {
				if ($is_linked)
					$return .= '<a href="' . $query_single_obj['link'] . '">';

				$return .= $query_single_obj['image'];
				if ($is_linked)
					$return .= '</a>';

			}
				
			$return .= '<div class="inner">';
				$return .= $query_single_obj['str_inner'];
			$return .= '</div">';
				
				$return .= '<div  class="bxslider-post-link">';
					$return .= '<span>';
						if ($is_linked) $return .= '<a title="' . $query_single_obj['str_title'] . '" href="' . $query_single_obj['link'] . '">' . $query_single_obj['str_link'] . '</a>';
					$return .= '</span>';

				$return .= '</div>';	

				
			$return .= '</div>';

		$return .= '</li>';
		
		
		$this->inner = $return;
	}
	
}

?>