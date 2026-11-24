<?php
/**
 * Title: Header Default
 * Slug: skincare-cosmetic-store/header-default
 * Categories: header
 */

$xiaohua_home_url      = home_url( '/' );
$xiaohua_shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$xiaohua_nosotros_page = get_page_by_path( 'nosotros', OBJECT, 'page' );
$xiaohua_contacto_page = get_page_by_path( 'contacto', OBJECT, 'page' );
$xiaohua_nosotros_url  = $xiaohua_nosotros_page ? get_permalink( $xiaohua_nosotros_page ) : home_url( '/nosotros/' );
$xiaohua_contacto_url  = $xiaohua_contacto_page ? get_permalink( $xiaohua_contacto_page ) : home_url( '/contacto/' );
?>
<!-- wp:group {"className":"header-sec","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group header-sec"><!-- wp:group {"className":"rev-top-bar","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"8px","bottom":"8px","left":"0","right":"0"},"blockGap":"0"}},"backgroundColor":"fifth-color","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group rev-top-bar has-fifth-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:8px;padding-right:0;padding-bottom:8px;padding-left:0"><!-- wp:columns {"verticalAlignment":"center","className":"rev-top-bar-col"} -->
<div class="wp-block-columns are-vertically-aligned-center rev-top-bar-col"><!-- wp:column {"verticalAlignment":"center","width":"25%","className":"social-icon-col"} -->
<div class="wp-block-column is-vertically-aligned-center social-icon-col" style="flex-basis:25%"><!-- wp:social-links {"iconColor":"background","iconColorValue":"#fff","className":"is-style-logos-only social-media-rev","style":{"spacing":{"blockGap":{"left":"17px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only social-media-rev"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"tiktok"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"discount-col","style":{"typography":{"fontSize":"15px"}}} -->
<div class="wp-block-column is-vertically-aligned-center discount-col" style="font-size:15px;flex-basis:50%"><!-- wp:paragraph {"align":"center","className":"top-head-text-rev","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}},"textColor":"background","fontFamily":"Quicksand"} -->
<p class="has-text-align-center top-head-text-rev has-background-color has-text-color has-link-color has-quicksand-font-family" style="font-size:16px;font-style:normal;font-weight:500"><?php esc_html_e('Save up to 20% on all products with','skincare-cosmetic-store'); ?> <a href="#"><?php esc_html_e('"GET20OFF"','skincare-cosmetic-store'); ?></a> <?php esc_html_e('code','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"gt-col"} -->
<div class="wp-block-column is-vertically-aligned-center gt-col" style="flex-basis:25%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"div","className":"header-menu-rev","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"backgroundColor":"secondary","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group header-menu-rev has-secondary-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:columns {"className":"rev-headerbox"} -->
<div class="wp-block-columns rev-headerbox"><!-- wp:column {"verticalAlignment":"center","width":"34.3%","className":"menu-box"} -->
<div class="wp-block-column is-vertically-aligned-center menu-box" style="flex-basis:34.3%"><!-- wp:navigation {"customTextColor":"#000","className":"main-navigation","style":{"typography":{"fontSize":"16px","textTransform":"capitalize","fontStyle":"Thin","fontWeight":"500"},"spacing":{"blockGap":"20px"}},"fontFamily":"Quicksand"} --><!-- wp:navigation-link {"label":"Inicio","url":"<?php echo esc_url( $xiaohua_home_url ); ?>","className":"home-page","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Tienda","url":"<?php echo esc_url( $xiaohua_shop_url ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Nosotros","url":"<?php echo esc_url( $xiaohua_nosotros_url ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contacto","url":"<?php echo esc_url( $xiaohua_contacto_url ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Comprar ahora","opensInNewTab":true,"url":"https://www.revolutionwp.com/products/skincare-wordpress-theme","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"rev-logo-box"} -->
<div class="wp-block-column is-vertically-aligned-center rev-logo-box" style="flex-basis:25%"><!-- wp:site-logo {"align":"center"} /-->

<!-- wp:site-title {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"700","textTransform":"capitalize","fontSize":"34px"}},"fontFamily":"Quicksand"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"34.3%","className":"header-icons"} -->
<div class="wp-block-column is-vertically-aligned-center header-icons" style="flex-basis:34.3%"><!-- wp:group {"className":"header-woo-icons","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group header-woo-icons"><!-- wp:group {"className":"search-box","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained","justifyContent":"right"}} -->
<div class="wp-block-group search-box"><!-- wp:search {"label":"Buscar","showLabel":false,"placeholder":"Buscar...","buttonText":"Buscar","buttonUseIcon":true,"query":{"post_type":"product"},"className":"search-box","style":{"typography":{"fontSize":"13px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","fontFamily":"Quicksand"} /--></div>
<!-- /wp:group -->

<!-- wp:woocommerce/customer-account {"displayStyle":"icon_only","iconClass":"wc-block-customer-account__account-icon","className":"header-account","textColor":"foreground","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}}} /-->

<!-- wp:image {"lightbox":{"enabled":false},"id":128,"width":"20px","height":"20px","scale":"contain","sizeSlug":"full","linkDestination":"none","className":"header-heart"} -->
<figure class="wp-block-image size-full is-resized header-heart"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/heart.png'); ?>" alt="" class="wp-image-128" style="object-fit:contain;width:20px;height:20px"/></figure>
<!-- /wp:image -->

<!-- wp:woocommerce/cart-link {"className":"header-cart","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->