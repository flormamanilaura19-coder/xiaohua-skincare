<?php
/**
 * Title: Product Section
 * Slug: skincare-cosmetic-store/product-section
 * Categories: template
 */
$skincare_cosmetic_store_pluginsList = get_option( 'active_plugins' );
$skincare_cosmetic_store_plugin = 'woocommerce/woocommerce.php';
$skincare_cosmetic_store_results = in_array( $skincare_cosmetic_store_plugin , $skincare_cosmetic_store_pluginsList);
if ( $skincare_cosmetic_store_results )  {
?>

<!-- wp:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="wp-block-group"><!-- wp:group {"style":{"spacing":{"margin":{"top":"2em"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:2em"><!-- wp:group {"className":"product-section wow zoomIn","layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-group product-section wow zoomIn"><!-- wp:group {"className":"product-head-box wow zoomIn","style":{"spacing":{"margin":{"bottom":"40px"},"padding":{"bottom":"0px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group product-head-box wow zoomIn" style="margin-bottom:40px;padding-bottom:0px"><!-- wp:heading {"textAlign":"center","level":3,"className":"product-section-title","style":{"typography":{"fontSize":"24px","textTransform":"capitalize","fontStyle":"Regular","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"rum-raisin"} -->
<h3 class="wp-block-heading has-text-align-center product-section-title has-primary-color has-text-color has-link-color has-rum-raisin-font-family" style="font-size:24px;font-style:Regular;font-weight:400;text-transform:capitalize"><?php esc_html_e('shop','skincare-cosmetic-store'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-sec-para","style":{"typography":{"fontSize":"27px","fontStyle":"normal","fontWeight":"700","lineHeight":"1.3","textTransform":"capitalize"},"spacing":{"margin":{"top":"0px","bottom":"0px"},"padding":{"right":"25px","left":"25px"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-sec-para has-foreground-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;margin-bottom:0px;padding-right:25px;padding-left:25px;font-size:27px;font-style:normal;font-weight:700;line-height:1.3;text-transform:capitalize"><?php esc_html_e('Hits of The Week','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":1,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"hideControls":["inherit","order","filterable"],"className":"product-div-box"} -->
<div class="wp-block-woocommerce-product-collection product-div-box"><!-- wp:woocommerce/product-template {"className":"products-sec-box","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary"} -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"height":"250px","scale":"contain","className":"product-img"} /-->

<!-- wp:post-title {"textAlign":"center","level":5,"isLink":true,"className":"product-title","style":{"spacing":{"margin":{"bottom":"5px","top":"0"}},"typography":{"lineHeight":"1.4","fontSize":"23px"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","fontFamily":"Quicksand","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"className":"product-price","fontFamily":"Quicksand","fontSize":"small","style":{"spacing":{"margin":{"bottom":"0px"}}}} /-->

<!-- wp:woocommerce/product-button {"isDescendentOfQueryLoop":true,"className":"product-btn","textAlign":"center","style":{"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"width":"0px","style":"none"},"spacing":{"padding":{"left":"5px","right":"5px","top":"0px","bottom":"0px"}},"color":{"background":"#00000000"}},"fontFamily":"Quicksand","textColor":"foreground"} /-->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<?php } else { ?>

<!-- wp:group {"style":{"spacing":{"margin":{"top":"2em"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:2em"><!-- wp:group {"className":"product-section wow zoomIn","layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-group product-section wow zoomIn"><!-- wp:group {"className":"product-head-box wow zoomIn","style":{"spacing":{"margin":{"bottom":"40px"},"padding":{"bottom":"0px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group product-head-box wow zoomIn" style="margin-bottom:40px;padding-bottom:0px"><!-- wp:heading {"textAlign":"center","level":3,"className":"product-section-title","style":{"typography":{"fontSize":"24px","textTransform":"capitalize","fontStyle":"Regular","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"rum-raisin"} -->
<h3 class="wp-block-heading has-text-align-center product-section-title has-primary-color has-text-color has-link-color has-rum-raisin-font-family" style="font-size:24px;font-style:Regular;font-weight:400;text-transform:capitalize"><?php esc_html_e('shop','skincare-cosmetic-store'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-sec-para","style":{"typography":{"fontSize":"27px","fontStyle":"normal","fontWeight":"700","lineHeight":"1.3","textTransform":"capitalize"},"spacing":{"margin":{"top":"0px","bottom":"0px"},"padding":{"right":"25px","left":"25px"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-sec-para has-foreground-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;margin-bottom:0px;padding-right:25px;padding-left:25px;font-size:27px;font-style:normal;font-weight:700;line-height:1.3;text-transform:capitalize"><?php esc_html_e('Hits of The Week','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"product-main-box","layout":{"type":"default"}} -->
<div class="wp-block-group product-main-box"><!-- wp:columns {"className":"products-sec-box"} -->
<div class="wp-block-columns products-sec-box"><!-- wp:column {"className":"product-box"} -->
<div class="wp-block-column product-box"><!-- wp:image {"id":32,"width":"auto","height":"250px","sizeSlug":"full","linkDestination":"none","className":"product-img","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
<figure class="wp-block-image size-full is-resized product-img" style="margin-bottom:var(--wp--preset--spacing--50)"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product1.png'); ?>" alt="" class="wp-image-32" style="width:auto;height:250px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":5,"className":"product-title","style":{"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"top":"10px"}}},"fontFamily":"Quicksand"} -->
<h5 class="wp-block-heading has-text-align-center product-title has-quicksand-font-family" style="margin-top:10px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('Revive Night Repair Cream','skincare-cosmetic-store'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-price","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"0px"}}},"textColor":"primary","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-price has-primary-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;font-size:16px;font-style:normal;font-weight:700"><?php esc_html_e('$31.00','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn","style":{"border":{"width":"0px","style":"none"},"spacing":{"margin":{"top":"0px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons product-btn" style="border-style:none;border-width:0px;margin-top:0px"><!-- wp:button {"style":{"elements":{"link":{"color":{"text":"#171515"}}},"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"width":"0px","style":"none"},"spacing":{"padding":{"left":"5px","right":"5px","top":"0px","bottom":"0px"}},"color":{"background":"#00000000","text":"#171515"}},"fontFamily":"Quicksand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-quicksand-font-family has-custom-font-size wp-element-button" href="#" style="border-style:none;border-width:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;color:#171515;background-color:#00000000;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:5px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('order now','skincare-cosmetic-store'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"product-box"} -->
<div class="wp-block-column product-box"><!-- wp:image {"id":32,"width":"auto","height":"250px","sizeSlug":"full","linkDestination":"none","className":"product-img","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
<figure class="wp-block-image size-full is-resized product-img" style="margin-bottom:var(--wp--preset--spacing--50)"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product2.png'); ?>" alt="" class="wp-image-32" style="width:auto;height:250px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":5,"className":"product-title","style":{"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"top":"10px"}}},"fontFamily":"Quicksand"} -->
<h5 class="wp-block-heading has-text-align-center product-title has-quicksand-font-family" style="margin-top:10px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('Revive Night Repair Cream','skincare-cosmetic-store'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-price","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"0px"}}},"textColor":"primary","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-price has-primary-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;font-size:16px;font-style:normal;font-weight:700"><?php esc_html_e('$31.00','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn","style":{"border":{"width":"0px","style":"none"},"spacing":{"margin":{"top":"0px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons product-btn" style="border-style:none;border-width:0px;margin-top:0px"><!-- wp:button {"style":{"elements":{"link":{"color":{"text":"#171515"}}},"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"width":"0px","style":"none"},"spacing":{"padding":{"left":"5px","right":"5px","top":"0px","bottom":"0px"}},"color":{"background":"#00000000","text":"#171515"}},"fontFamily":"Quicksand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-quicksand-font-family has-custom-font-size wp-element-button" href="#" style="border-style:none;border-width:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;color:#171515;background-color:#00000000;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:5px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('order now','skincare-cosmetic-store'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"product-box"} -->
<div class="wp-block-column product-box"><!-- wp:image {"id":32,"width":"auto","height":"250px","sizeSlug":"full","linkDestination":"none","className":"product-img","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
<figure class="wp-block-image size-full is-resized product-img" style="margin-bottom:var(--wp--preset--spacing--50)"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product3.png'); ?>" alt="" class="wp-image-32" style="width:auto;height:250px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":5,"className":"product-title","style":{"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"top":"10px"}}},"fontFamily":"Quicksand"} -->
<h5 class="wp-block-heading has-text-align-center product-title has-quicksand-font-family" style="margin-top:10px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('Revive Night Repair Cream','skincare-cosmetic-store'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-price","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"0px"}}},"textColor":"primary","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-price has-primary-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;font-size:16px;font-style:normal;font-weight:700"><?php esc_html_e('$31.00','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn","style":{"border":{"width":"0px","style":"none"},"spacing":{"margin":{"top":"0px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons product-btn" style="border-style:none;border-width:0px;margin-top:0px"><!-- wp:button {"style":{"elements":{"link":{"color":{"text":"#171515"}}},"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"width":"0px","style":"none"},"spacing":{"padding":{"left":"5px","right":"5px","top":"0px","bottom":"0px"}},"color":{"background":"#00000000","text":"#171515"}},"fontFamily":"Quicksand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-quicksand-font-family has-custom-font-size wp-element-button" href="#" style="border-style:none;border-width:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;color:#171515;background-color:#00000000;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:5px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('order now','skincare-cosmetic-store'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"product-box"} -->
<div class="wp-block-column product-box"><!-- wp:image {"id":32,"width":"auto","height":"250px","sizeSlug":"full","linkDestination":"none","className":"product-img","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
<figure class="wp-block-image size-full is-resized product-img" style="margin-bottom:var(--wp--preset--spacing--50)"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product4.png'); ?>" alt="" class="wp-image-32" style="width:auto;height:250px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":5,"className":"product-title","style":{"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"top":"10px"}}},"fontFamily":"Quicksand"} -->
<h5 class="wp-block-heading has-text-align-center product-title has-quicksand-font-family" style="margin-top:10px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('Revive Night Repair Cream','skincare-cosmetic-store'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"product-price","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"0px"}}},"textColor":"primary","fontFamily":"Quicksand"} -->
<p class="has-text-align-center product-price has-primary-color has-text-color has-link-color has-quicksand-font-family" style="margin-top:0px;font-size:16px;font-style:normal;font-weight:700"><?php esc_html_e('$31.00','skincare-cosmetic-store'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn","style":{"border":{"width":"0px","style":"none"},"spacing":{"margin":{"top":"0px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons product-btn" style="border-style:none;border-width:0px;margin-top:0px"><!-- wp:button {"style":{"elements":{"link":{"color":{"text":"#171515"}}},"typography":{"fontSize":"17px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"width":"0px","style":"none"},"spacing":{"padding":{"left":"5px","right":"5px","top":"0px","bottom":"0px"}},"color":{"background":"#00000000","text":"#171515"}},"fontFamily":"Quicksand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-quicksand-font-family has-custom-font-size wp-element-button" href="#" style="border-style:none;border-width:0px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;color:#171515;background-color:#00000000;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:5px;font-size:17px;font-style:normal;font-weight:700;text-transform:capitalize"><?php esc_html_e('order now','skincare-cosmetic-store'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php } ?>