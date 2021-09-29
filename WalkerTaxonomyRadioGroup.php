<?php

namespace wpscholar\WordPress;

/**
 * Class WalkerTaxonomyRadioGroup
 *
 * @package wpscholar\WordPress
 */
class WalkerTaxonomyRadioGroup extends \Walker {

	/**
	 * Map fields
	 *
	 * @var array
	 */
	public $db_fields = [
		'id'     => 'term_id',
		'parent' => 'parent',
	];

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of taxonomy. Used for tab indentation.
	 * @param array  $args   An array of arguments.
	 *
	 * @see Walker:start_lvl()
	 *
	 */
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of taxonomy. Used for tab indentation.
	 * @param array  $args   An array of arguments.
	 *
	 * @see Walker::end_lvl()
	 *
	 */
	public function end_lvl( &$output, $depth = 0, $args = [] ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param \WP_Term $term   The current term object.
	 * @param int      $depth  Depth of the term in reference to parents. Default 0.
	 * @param array    $args   An array of arguments.
	 * @param int      $id     ID of the current term.
	 *
	 * @see Walker::start_el()
	 *
	 */
	public function start_el( &$output, $term, $depth = 0, $args = [], $id = 0 ) {

		$selectedTermId = isset( $args['selected'] ) ? absint( $args['selected'] ) : 0;

		$output .= sprintf( '<li id="%s">', esc_attr( "{$term->taxonomy}-{$term->term_id}" ) );

		$output .= sprintf(
			'<label><input type="radio" id="%s" name="%s" value="%s"%s%s%s /> %s</label>',
			esc_attr( "in{$term->taxonomy}-{$term->term_id}" ),
			esc_attr( "tax_input[{$term->taxonomy}][]" ),
			esc_attr( $term->term_id ),
			checked( $term->term_id, $selectedTermId, false ),
			disabled( empty( $args['disabled'] ), false, false ),
			empty( $args['required'] ) ? '' : ' required',
			esc_html( $term->name )
		);

	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param \WP_Term $term   The current term object.
	 * @param int      $depth  Depth of the term in reference to parents. Default 0.
	 * @param array    $args   An array of arguments.
	 *
	 * @see   Walker::end_el()
	 *
	 * @since 2.5.1
	 *
	 */
	public function end_el( &$output, $term, $depth = 0, $args = [] ) {
		$output .= "</li>\n";
	}
}
