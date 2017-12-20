<?php

if ( ! function_exists( 'wp_tax_radio_group' ) ) {

	/**
	 * Displays a radio group of taxonomy terms.
	 *
	 * @param string $taxonomy The taxonomy from which to fetch terms
	 * @param array $args An array of arguments for customizing output (see $defaultArgs for available options)
	 *
	 * @return string
	 */
	function wp_tax_radio_group( $taxonomy, array $args = [] ) {

		$defaultArgs = [
			'class'           => 'categorychecklist', // Default class name for ul element
			'container'       => true, // Whether or not to wrap output in a container element
			'container_class' => 'categorydiv', // Default class name for container element
			'disabled'        => false, // Disable the field
			'max_depth'       => - 1, // Setting to a value greater than 0 will show terms in a nested format
			'required'        => false, // Require the field
			'selected'        => 0, // ID for the currently selected term
			'term_args'       => [ // Args passed to get_terms()
				'hide_empty' => false, // Show all terms by default
			],
		];

		// Try to set the selected term ID, if not already set
		if ( ! array_key_exists( 'selected', $args ) ) {
			$post_id = get_the_ID();
			if ( $post_id ) {
				$objTerms = wp_get_object_terms( $post_id, $taxonomy );
				if ( isset( $objTerms, $objTerms[0], $objTerms[0]->term_id ) ) {
					$defaultArgs['selected'] = $objTerms[0]->term_id;
				}
			}
		}

		// Merge default args with user-provided args
		$args = array_merge( $defaultArgs, $args );

		// Set max depth
		$max_depth = $args['max_depth'];
		unset( $args['max_depth'] );

		// Get terms for taxonomy
		$terms = get_terms( array_merge( $args['term_args'], [ 'taxonomy' => $taxonomy ] ) );
		unset( $args['term_args'] );

		// Allow control over class, container, and container class
		$class = sanitize_html_class( (string) $args['class'] );
		$container = wp_validate_boolean( $args['container'] );
		$container_class = sanitize_html_class( (string) $args['container_class'] );
		unset( $args['class'], $args['container'], $args['container_class'] );

		// Instantiate walker
		$walker = new \wpscholar\WordPress\WalkerTaxonomyRadioGroup();

		// Compile markup for taxonomy radio group
		$output = $container ? '<div class="' . esc_attr( $container_class ) . '">' : '';
		$output .= '<ul class="' . esc_attr( $class ) . '">';
		$output .= $walker->walk( $terms, $max_depth, $args );
		$output .= '</ul>';
		$output .= $container ? '</div>' : '';

		return $output;

	}

}