<?php
/**
 * Title: Footer Default
 * Slug: skincare-cosmetic-store/footer-default
 * Categories: footer
 */

$xiaohua_home_url     = home_url( '/' );
$xiaohua_shop_url     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$xiaohua_account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
$xiaohua_cart_url     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'cart' ) : home_url( '/cart/' );
$xiaohua_nosotros_page = get_page_by_path( 'nosotros', OBJECT, 'page' );
$xiaohua_nosotros_url  = $xiaohua_nosotros_page ? get_permalink( $xiaohua_nosotros_page ) : home_url( '/nosotros/' );
$xiaohua_contacto_page = get_page_by_path( 'contacto', OBJECT, 'page' );
$xiaohua_contacto_url  = $xiaohua_contacto_page ? get_permalink( $xiaohua_contacto_page ) : home_url( '/contacto/' );

$xiaohua_email = 'flormamanilaura19@gmail.com';
$xiaohua_whatsapp_number = defined( 'XIAOHUA_WHATSAPP_NUMBER' ) ? preg_replace( '/\D+/', '', (string) XIAOHUA_WHATSAPP_NUMBER ) : '51958327294';
$xiaohua_whatsapp_url    = 'https://wa.me/' . $xiaohua_whatsapp_number;
$xiaohua_whatsapp_label  = '+51 958 327 294';
$xiaohua_hours           = 'Lunes a viernes, de 9:00 a 18:00 h';

$xiaohua_category_map = array(
	array( 'label' => 'Limpieza facial',      'slugs' => array( 'limpieza-facial', 'cleansers', 'limpiadores' ) ),
	array( 'label' => 'Hidratantes',          'slugs' => array( 'hidratantes', 'moisturisers', 'moisturizers', 'creams' ) ),
	array( 'label' => 'Sérums y tratamientos','slugs' => array( 'serums-y-tratamientos', 'serums', 'tratamientos' ) ),
	array( 'label' => 'Protectores solares',  'slugs' => array( 'protectores-solares', 'sunscreen', 'spf' ) ),
	array( 'label' => 'Mascarillas faciales', 'slugs' => array( 'mascarillas-faciales', 'masks', 'mascarillas' ) ),
	array( 'label' => 'Cuidado facial',       'slugs' => array( 'cuidado-facial', 'skincare', 'facial-care' ) ),
);

$xiaohua_categories = array();
if ( function_exists( 'get_term_by' ) && function_exists( 'get_term_link' ) ) {
	foreach ( $xiaohua_category_map as $cat ) {
		$term = null;
		foreach ( $cat['slugs'] as $slug ) {
			$found = get_term_by( 'slug', $slug, 'product_cat' );
			if ( $found && ! is_wp_error( $found ) ) {
				$term = $found;
				break;
			}
		}
		if ( $term ) {
			$link = get_term_link( $term );
			if ( ! is_wp_error( $link ) ) {
				$xiaohua_categories[] = array(
					'label' => $cat['label'],
					'url'   => $link,
				);
			}
		}
	}
}
?>

<!-- wp:group {"className":"footer-section","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"60px","bottom":"24px","left":"20px","right":"20px"}}},"backgroundColor":"primary","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group footer-section has-primary-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:60px;padding-right:20px;padding-bottom:24px;padding-left:20px"><!-- wp:columns {"className":"footer-main-cols","style":{"spacing":{"blockGap":{"top":"32px","left":"32px"},"margin":{"bottom":"36px"}}}} -->
<div class="wp-block-columns footer-main-cols" style="margin-bottom:36px"><!-- wp:column {"verticalAlignment":"top","width":"25%","className":"footer-box wow zoomIn delay-5000"} -->
<div class="wp-block-column is-vertically-aligned-top footer-box wow zoomIn delay-5000" style="flex-basis:25%"><!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"none","fontSize":"24px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"bottom":"18px","top":"0"}}},"textColor":"background","fontFamily":"quando"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-quando-font-family" style="margin-top:0;margin-bottom:18px;font-size:24px;font-style:normal;font-weight:600;text-transform:none"><?php esc_html_e( 'Sobre nosotros', 'skincare-cosmetic-store' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","lineHeight":"1.8","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"bottom":"20px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:20px;font-size:14px;font-style:normal;font-weight:400;line-height:1.8"><?php esc_html_e( 'En XIAOHUA creemos que el cuidado de la piel es una forma de amor propio. Descubre productos de skincare seleccionados para acompañarte en tu rutina de belleza y ayudarte a cuidar tu piel cada día.', 'skincare-cosmetic-store' ); ?></p>
<!-- /wp:paragraph -->

<?php /* Redes sociales: WhatsApp configurado. Facebook, Instagram y TikTok pendientes de URL oficial. */ ?>
<!-- wp:social-links {"iconColor":"foreground","iconColorValue":"#000","iconBackgroundColor":"background","iconBackgroundColorValue":"#fff","openInNewTab":true,"size":"has-normal-icon-size","className":"is-style-pill-shape xiaohua-footer-social","style":{"spacing":{"blockGap":{"top":"10px","left":"10px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-normal-icon-size has-icon-color has-icon-background-color is-style-pill-shape xiaohua-footer-social"><!-- wp:social-link {"url":"#","service":"facebook","label":"Facebook"} /-->

<!-- wp:social-link {"url":"#","service":"instagram","label":"Instagram"} /-->

<!-- wp:social-link {"url":"#","service":"tiktok","label":"TikTok"} /-->

<!-- wp:social-link {"url":"<?php echo esc_url( $xiaohua_whatsapp_url ); ?>","service":"whatsapp","label":"WhatsApp"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"25%","className":"footer-box wow zoomIn delay-5000"} -->
<div class="wp-block-column is-vertically-aligned-top footer-box wow zoomIn delay-5000" style="flex-basis:25%"><!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"none","fontSize":"24px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"bottom":"18px","top":"0"}}},"textColor":"background","fontFamily":"quando"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-quando-font-family" style="margin-top:0;margin-bottom:18px;font-size:24px;font-style:normal;font-weight:600;text-transform:none"><?php esc_html_e( 'Enlaces rápidos', 'skincare-cosmetic-store' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_home_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Inicio', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_shop_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Tienda', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_nosotros_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Sobre nosotros', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_account_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Mi cuenta', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_cart_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Carrito', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"0"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:0;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $xiaohua_contacto_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Contáctanos', 'skincare-cosmetic-store' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"25%","className":"footer-box wow zoomIn delay-5000"} -->
<div class="wp-block-column is-vertically-aligned-top footer-box wow zoomIn delay-5000" style="flex-basis:25%"><!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"none","fontSize":"24px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"bottom":"18px","top":"0"}}},"textColor":"background","fontFamily":"quando"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-quando-font-family" style="margin-top:0;margin-bottom:18px;font-size:24px;font-style:normal;font-weight:600;text-transform:none"><?php esc_html_e( 'Categorías', 'skincare-cosmetic-store' ); ?></h3>
<!-- /wp:heading -->

<?php if ( ! empty( $xiaohua_categories ) ) : ?>
	<?php foreach ( $xiaohua_categories as $index => $cat ) : ?>
		<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"10px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
		<p class="has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:10px;font-size:14px;font-style:normal;font-weight:500"><a href="<?php echo esc_url( $cat['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $cat['label'] ); ?></a></p>
		<!-- /wp:paragraph -->
	<?php endforeach; ?>
<?php else : ?>
	<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"}},"textColor":"background","fontFamily":"Quicksand"} -->
	<p class="has-background-color has-text-color has-quicksand-font-family" style="font-size:14px;font-style:normal;font-weight:500"><?php esc_html_e( 'Categorías de productos próximamente.', 'skincare-cosmetic-store' ); ?></p>
	<!-- /wp:paragraph -->
<?php endif; ?></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"25%","className":"footer-box wow zoomIn delay-5000"} -->
<div class="wp-block-column is-vertically-aligned-top footer-box wow zoomIn delay-5000" style="flex-basis:25%"><!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"none","fontSize":"24px","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"bottom":"18px","top":"0"}}},"textColor":"background","fontFamily":"quando"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-quando-font-family" style="margin-top:0;margin-bottom:18px;font-size:24px;font-style:normal;font-weight:600;text-transform:none"><?php esc_html_e( 'Contáctanos', 'skincare-cosmetic-store' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"footer-mail","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500","lineHeight":"1.7"},"spacing":{"margin":{"bottom":"12px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="footer-mail has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:12px;font-size:14px;font-style:normal;font-weight:500;line-height:1.7"><a href="mailto:<?php echo esc_attr( $xiaohua_email ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $xiaohua_email ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-phone","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500","lineHeight":"1.7"},"spacing":{"margin":{"bottom":"12px"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="footer-phone has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:12px;font-size:14px;font-style:normal;font-weight:500;line-height:1.7"><a href="<?php echo esc_url( $xiaohua_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $xiaohua_whatsapp_label ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-hours","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500","lineHeight":"1.7"},"spacing":{"margin":{"bottom":"0"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="footer-hours has-background-color has-text-color has-quicksand-font-family" style="margin-bottom:0;font-size:14px;font-style:normal;font-weight:500;line-height:1.7"><?php echo esc_html( $xiaohua_hours ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"copyright-section","style":{"spacing":{"padding":{"top":"18px","bottom":"0"},"margin":{"top":"0"}},"border":{"top":{"color":"#ffffff33","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group copyright-section" style="border-top-color:#ffffff33;border-top-width:1px;margin-top:0;padding-top:18px;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-text-align-center has-background-color has-text-color has-quicksand-font-family" style="margin-top:0;margin-bottom:0;font-size:14px;font-style:normal;font-weight:500"><?php esc_html_e( '© 2026 XIAOHUA. Todos los derechos reservados.', 'skincare-cosmetic-store' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"scroll-top-box","style":{"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"}}}} -->
<div class="wp-block-button scroll-top-box"><a class="wp-block-button__link wp-element-button" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><img class="wp-image-6" style="width: 20px;" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/scroll-top.png'); ?>" alt=""></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->