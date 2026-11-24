<?php
/**
 * Demo WooCommerce products for the homepage "Hits of The Week" section.
 *
 * Each product is identified by its unique `key`, which is stored as post meta so the
 * import can be run again without creating duplicates. Images are file names inside
 * the theme's `assets/images/` directory (child themes can override them).
 *
 * @package Skincare Cosmetic Store
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the demo products.
 *
 * @return array[]
 */
function skincare_cosmetic_store_get_demo_products() {
	$skincare_cosmetic_store_products = array(
		array(
			'key'               => 'anti-blemish-tomato-serum',
			'name'              => __( 'Anti-Blemish Tomato Serum', 'skincare-cosmetic-store' ),
			'regular_price'     => '31.00',
			'description'       => __( 'A lightweight serum with tomato and pink basil extracts that helps reduce blemishes and even out skin tone.', 'skincare-cosmetic-store' ),
			'short_description' => __( 'Brightening serum for clearer, even-toned skin.', 'skincare-cosmetic-store' ),
			'image'             => 'product1.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Skincare', 'skincare-cosmetic-store' ), __( 'Serums', 'skincare-cosmetic-store' ) ),
		),
		array(
			'key'               => 'sensitive-after-shave-balm',
			'name'              => __( 'Sensitive After Shave Balm', 'skincare-cosmetic-store' ),
			'regular_price'     => '31.00',
			'description'       => __( 'An alcohol-free balm that soothes and hydrates sensitive skin after shaving.', 'skincare-cosmetic-store' ),
			'short_description' => __( 'Calming care for sensitive skin.', 'skincare-cosmetic-store' ),
			'image'             => 'product2.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Skincare', 'skincare-cosmetic-store' ), __( 'Men\'s Care', 'skincare-cosmetic-store' ) ),
		),
		array(
			'key'               => 'soothing-repair-cream',
			'name'              => __( 'Soothing Repair Cream', 'skincare-cosmetic-store' ),
			'regular_price'     => '31.00',
			'description'       => __( 'A rich, fragrance-free cream that comforts dry and irritated skin and supports its natural barrier.', 'skincare-cosmetic-store' ),
			'short_description' => __( 'Intensive relief for dry, reactive skin.', 'skincare-cosmetic-store' ),
			'image'             => 'product3.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Skincare', 'skincare-cosmetic-store' ), __( 'Creams', 'skincare-cosmetic-store' ) ),
		),
		array(
			'key'               => 'kids-moisturising-cream',
			'name'              => __( 'Kids Moisturising Cream', 'skincare-cosmetic-store' ),
			'regular_price'     => '31.00',
			'description'       => __( 'A gentle everyday moisturiser made for delicate skin, keeping it soft and hydrated all day.', 'skincare-cosmetic-store' ),
			'short_description' => __( 'Gentle daily hydration for delicate skin.', 'skincare-cosmetic-store' ),
			'image'             => 'product4.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Skincare', 'skincare-cosmetic-store' ), __( 'Moisturisers', 'skincare-cosmetic-store' ) ),
		),
	);

	/**
	 * Filters the demo products imported by the one-click setup.
	 *
	 * @param array[] $skincare_cosmetic_store_products Demo product definitions.
	 */
	return apply_filters( 'skincare_cosmetic_store_demo_products', $skincare_cosmetic_store_products );
}
