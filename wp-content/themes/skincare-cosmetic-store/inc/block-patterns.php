<?php
/**
 * Skincare Cosmetic Store: Block Patterns
 *
 * @since Skincare Cosmetic Store 1.0
 */

 /**
  * Get patterns content.
  *
  * @param string $file_name Filename.
  * @return string
  */
function skincare_cosmetic_store_get_pattern_content( $file_name ) {
	ob_start();
	include get_theme_file_path( '/patterns/' . $file_name . '.php' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers block patterns and categories.
 *
 * @since Skincare Cosmetic Store 1.0
 *
 * @return void
 */
function skincare_cosmetic_store_register_block_patterns() {

	$patterns = array(
		'header-default' => array(
			'title'      => __( 'Default header', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-headers' ),
			'blockTypes' => array( 'parts/header' ),
		),
		'footer-default' => array(
			'title'      => __( 'Default footer', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-footers' ),
			'blockTypes' => array( 'parts/footer' ),
		),
		'home-banner' => array(
			'title'      => __( 'Home Banner', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-banner' ),
		),
		'product-section' => array(
			'title'      => __( 'Product Sections', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-product-section' ),
		),
		'latest-blog-section' => array(
			'title'      => __( 'Latest Blog Section', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-latest-blog-section' ),
		),
		'primary-sidebar' => array(
			'title'    => __( 'Primary Sidebar', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-sidebars' ),
		),
		'hidden-404' => array(
			'title'    => __( '404 content', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-pages' ),
		),
		'post-listing-single-column' => array(
			'title'    => __( 'Post Single Column', 'skincare-cosmetic-store' ),
			//'inserter' => false,
			'categories' => array( 'skincare-cosmetic-store-query' ),
		),
		'post-listing-two-column' => array(
			'title'    => __( 'Post Two Column', 'skincare-cosmetic-store' ),
			//'inserter' => false,
			'categories' => array( 'skincare-cosmetic-store-query' ),
		),
		'post-listing-three-column' => array(
			'title'    => __( 'Post Three Column', 'skincare-cosmetic-store' ),
			//'inserter' => false,
			'categories' => array( 'skincare-cosmetic-store-query' ),
		),
		'post-listing-four-column' => array(
			'title'    => __( 'Post Four Column', 'skincare-cosmetic-store' ),
			//'inserter' => false,
			'categories' => array( 'skincare-cosmetic-store-query' ),
		),
		'feature-post-column' => array(
			'title'    => __( 'Feature Post Column', 'skincare-cosmetic-store' ),
			//'inserter' => false,
			'categories' => array( 'skincare-cosmetic-store-query' ),
		),
		'comment-section-1' => array(
			'title'    => __( 'Comment Section 1', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-comment-sections' ),
		),
		'cover-with-post-title' => array(
			'title'    => __( 'Cover With Post Title', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-banner-sections' ),
		),
		'theme-button' => array(
			'title'    => __( 'Theme Button', 'skincare-cosmetic-store' ),
			'categories' => array( 'skincare-cosmetic-store-theme-button' ),
		),
	);

	$block_pattern_categories = array(
		'skincare-cosmetic-store-footers' => array( 'label' => __( 'Footers', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-headers' => array( 'label' => __( 'Headers', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-pages'   => array( 'label' => __( 'Pages', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-query'   => array( 'label' => __( 'Query', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-sidebars'   => array( 'label' => __( 'Sidebars', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-banner'   => array( 'label' => __( 'Banner Sections', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-product-section'   => array( 'label' => __( 'Product Section', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-latest-blog-section'   => array( 'label' => __( 'Latest Blog Section', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-comment-section'   => array( 'label' => __( 'Comment Sections', 'skincare-cosmetic-store' ) ),
		'skincare-cosmetic-store-theme-button'   => array( 'label' => __( 'Theme Button Sections', 'skincare-cosmetic-store' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since Skincare Cosmetic Store 1.0
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'skincare_cosmetic_store_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since Skincare Cosmetic Store 1.0
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$patterns = apply_filters( 'skincare_cosmetic_store_block_patterns', $patterns );

	foreach ( $patterns as $block_pattern => $pattern ) {
		$pattern['content'] = skincare_cosmetic_store_get_pattern_content( $block_pattern );
		register_block_pattern(
			'skincare-cosmetic-store/' . $block_pattern,
			$pattern
		);
	}
}
add_action( 'init', 'skincare_cosmetic_store_register_block_patterns', 9 );
