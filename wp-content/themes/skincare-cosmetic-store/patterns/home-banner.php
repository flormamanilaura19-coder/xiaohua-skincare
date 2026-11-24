<?php
/**
 * Title: Home Banner
 * Slug: skincare-cosmetic-store/home-banner
 * Categories: template
 *
 * Banner de bienvenida estatico (imagen SKINCARE.png).
 * Sustituye al antiguo carrusel de diapositivas.
 *
 * @package Skincare_Cosmetic_Store
 */

$banner_id  = 28; // Adjunto SKINCARE.png en la biblioteca de medios.
$banner_alt = __( 'Bienvenido a XIAOHUA', 'skincare-cosmetic-store' );

if ( $banner_id && wp_get_attachment_image_src( $banner_id, 'full' ) ) {
	$banner_img = wp_get_attachment_image(
		$banner_id,
		'full',
		false,
		array(
			'class'         => 'banner-static__img',
			'alt'           => $banner_alt,
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'decoding'      => 'async',
			'sizes'         => '100vw',
		)
	);
} else {
	$banner_img = sprintf(
		'<img class="banner-static__img" src="%1$s" alt="%2$s" width="1698" height="926" loading="eager" fetchpriority="high" decoding="async" />',
		esc_url( get_template_directory_uri() . '/assets/images/skincare-banner.png' ),
		esc_attr( $banner_alt )
	);
}
?>
<!-- wp:html -->
<div class="banner-sec banner-static">
	<figure class="banner-static__figure">
		<?php echo $banner_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Markup generado por wp_get_attachment_image(). ?>
	</figure>
</div>
<!-- /wp:html -->
