# WordPress Taxonomy Radio Group

A WordPress walker class and function for rendering a taxonomy radio group.

## Getting Started

The anticipated use case for this is removing the normal hierarchical taxonomy metabox from the WordPress admin and replacing with a custom metabox with radio buttons (as opposed to the normal checkboxes).

For example, here is how to replace the standard categories metabox on the post edit screen with our own custom one:

```php
<?php

add_action( 'admin_menu', function () {

	$taxonomy = get_taxonomy( 'category' );
	
	add_meta_box( "{$taxonomy->name}div", $taxonomy->label, function () use ( $taxonomy ) {
		echo wp_tax_radio_group( $taxonomy->name );
	}, 'post', 'side' );

} );

``` 