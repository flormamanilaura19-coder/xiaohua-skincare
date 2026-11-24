<?php
/**
 * Skincare Cosmetic Store functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Skincare Cosmetic Store
 */

if ( ! defined( 'SKINCARE_COSMETIC_STORE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'SKINCARE_COSMETIC_STORE_VERSION', wp_get_theme()->get( 'Version' ) );
}

define( 'SKINCARE_COSMETIC_STORE_FREE_SUPPORT', 'https://www.revolutionwp.com/products/skincare-cosmetic-store' );
define( 'SKINCARE_COSMETIC_STORE_PRO_SUPPORT', 'https://wordpress.org/support/theme/skincare-cosmetic-store/' );
define( 'SKINCARE_COSMETIC_STORE_REVIEW', 'https://wordpress.org/support/theme/skincare-cosmetic-store/reviews/' );
define( 'SKINCARE_COSMETIC_STORE_BUY_NOW', 'https://www.revolutionwp.com/products/skincare-wordpress-theme' );
define( 'SKINCARE_COSMETIC_STORE_LIVE_DEMO', 'https://demo.revolutionwp.com/skincare-cosmetic-store-pro/' );
define( 'SKINCARE_COSMETIC_STORE_PRO_DOC', 'https://demo.revolutionwp.com/wpdocs/skincare-cosmetic-store-pro/' );
define( 'SKINCARE_COSMETIC_STORE_LITE_DOC', 'https://demo.revolutionwp.com/wpdocs/skincare-cosmetic-store-free/' );
define( 'SKINCARE_COSMETIC_STORE_BUNDLE', 'https://www.revolutionwp.com/products/wordpress-theme-bundle' );

if ( ! function_exists( 'skincare_cosmetic_store_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function skincare_cosmetic_store_setup() {

		load_theme_textdomain( 'skincare-cosmetic-store', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'woocommerce' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Experimental support for adding blocks inside nav menus
		add_theme_support( 'block-nav-menus' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );
	}
endif;
add_action( 'after_setup_theme', 'skincare_cosmetic_store_setup' );

function skincare_cosmetic_store_scripts() {
    $SKINCARE_COSMETIC_STORE_VERSION_string = '1.0.0'; // Add this line

    wp_enqueue_style('skincare-cosmetic-store-style', get_stylesheet_uri(), array(), filemtime( get_theme_file_path( 'style.css' ) ) );
    wp_enqueue_script('jquery-wow', get_template_directory_uri() . '/assets/js/wow.js', array('jquery'));
    wp_enqueue_style('animate-css', get_template_directory_uri() . '/assets/css/animate.css');

    //font-awesome
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/font-awesome/css/all.css', array(), '6.7.0' );
    wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri().'/assets/css/owl.carousel.css', array(), $SKINCARE_COSMETIC_STORE_VERSION_string );
    wp_enqueue_script( 'owl.carousel-js', get_template_directory_uri(). '/assets/js/owl.carousel.js', array('jquery') ,$SKINCARE_COSMETIC_STORE_VERSION_string,true);
    
    wp_enqueue_script('skincare-cosmetic-store-custom-scripts', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), filemtime( get_theme_file_path( 'assets/js/custom.js' ) ), true);
    wp_style_add_data( 'skincare-cosmetic-store-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'skincare_cosmetic_store_scripts' );


/**
 * Enqueue block editor styles
 */
function skincare_cosmetic_store_enqueue_block_editor_styles() {
    wp_enqueue_style(
        'skincare-cosmetic-store-block-editor-style', // Handle
        get_theme_file_uri( '/assets/css/block-editor.css' ), // File URI
        array(), // Dependencies
        filemtime( get_theme_file_path( '/assets/css/block-editor.css' ) ) // Version with file modification time for cache busting
    );
}
add_action( 'enqueue_block_editor_assets', 'skincare_cosmetic_store_enqueue_block_editor_styles' );


function skincare_cosmetic_store_init_setup() {

    /**
     * Section Pro
     */
    require get_template_directory() . '/inc/section-pro/customizer.php';

    // Add block patterns
    require get_template_directory() . '/inc/block-patterns.php';
    
    // TGM
    require_once get_template_directory() . '/inc/tgm/tgm.php';

    // One-click plugin installation & demo import
    require_once get_template_directory() . '/inc/demo-import/demo-products.php';
    require_once get_template_directory() . '/inc/demo-import/class-skincare-cosmetic-store-demo-import.php';

}
add_action( 'after_setup_theme', 'skincare_cosmetic_store_init_setup' );


//////////////////////////////////////////////   Function for Translation Error   //////////////////////////////////////////////////////
function skincare_cosmetic_store_enqueue_function() {

    /**
    * GET START.
    */
    require get_template_directory() . '/getstarted/skincare_cosmetic_store_about_page.php';

    
}
add_action( 'after_setup_theme', 'skincare_cosmetic_store_enqueue_function' );

// Add admin notice
function skincare_cosmetic_store_admin_notice() {
    if ( get_option( 'skincare_cosmetic_store_admin_notice' ) ) {
        return;
    }

    if ( is_network_admin() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $skincare_cosmetic_store_current_screen = get_current_screen();

    if ( $skincare_cosmetic_store_current_screen && 'appearance_page_skincare-cosmetic-store-getstart-page' === $skincare_cosmetic_store_current_screen->base ) {
        return;
    }
    ?>
    <div class="notice notice-success wprev-welcome-notice">
        <p class="wprev-dismiss-link">
            <strong>
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'skincare_cosmetic_store_admin_notice', '1' ), 'skincare_cosmetic_store_dismiss_notice' ) ); ?>">
                    <?php esc_html_e( 'Dismiss', 'skincare-cosmetic-store' ); ?>
                </a>
            </strong>
        </p>

        <div class="wprev-welcome-notice-wrap">
            <h2 class="wprev-notice-title">
                <span class="dashicons dashicons-admin-home"></span>
                <?php
                    $skincare_cosmetic_store_theme_name = wp_get_theme()->get( 'Name' );
                    /* translators: %s!: Theme Name. */
                    echo esc_html( sprintf( __( 'Welcome to the free theme: %s!', 'skincare-cosmetic-store' ), $skincare_cosmetic_store_theme_name ) );
                ?>
            </h2>
            <p class="wprev-notice-desc">
                <?php esc_html_e( 'Get started by exploring the features of your new theme. Customize your design, add your content, and create a site that fits your vision.', 'skincare-cosmetic-store' ); ?>
            </p>

            <div class="wprev-welcome-info">
                <div class="wprev-welcome-thumb">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr_e( 'Theme Screenshot', 'skincare-cosmetic-store' ); ?>">
                </div>

                <?php if ( Skincare_Cosmetic_Store_Demo_Import::current_user_can_run() ) : ?>
                <div class="wprev-welcome-import">
                    <?php if ( Skincare_Cosmetic_Store_Demo_Import::is_complete() ) : ?>
                        <h3><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Your Demo Is Ready', 'skincare-cosmetic-store' ); ?></h3>
                        <p><?php esc_html_e( 'The recommended plugins are active and the demo products have been imported. Visit your site to see it in action.', 'skincare-cosmetic-store' ); ?></p>
                    <?php else : ?>
                        <h3><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Quick Start: Import Demo', 'skincare-cosmetic-store' ); ?></h3>
                        <p><?php esc_html_e( 'Install the recommended plugins and import the demo products in one click. Get a complete site in minutes.', 'skincare-cosmetic-store' ); ?></p>
                    <?php endif; ?>
                    <?php Skincare_Cosmetic_Store_Demo_Import::render_button( 'notice' ); ?>
                </div>
                <?php endif; ?>

                <div class="wprev-welcome-getting-started">
                    <h3><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Customize Your Theme', 'skincare-cosmetic-store' ); ?></h3>
                    <p><?php esc_html_e( 'Want to make it truly yours? Explore the Getting Started Guide to personalize your site to suit your needs.', 'skincare-cosmetic-store' ); ?></p>
                    <p><a class="info-link button" href="<?php echo esc_url( admin_url( 'themes.php?page=skincare-cosmetic-store-getstart-page' ) ); ?>"><?php esc_html_e( 'View Getting Started Guide', 'skincare-cosmetic-store' ); ?></a></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'admin_notices', 'skincare_cosmetic_store_admin_notice' );

if ( ! function_exists( 'skincare_cosmetic_store_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function skincare_cosmetic_store_update_admin_notice() {
    if ( isset( $_GET['skincare_cosmetic_store_admin_notice'] ) && '1' === $_GET['skincare_cosmetic_store_admin_notice'] && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'skincare_cosmetic_store_dismiss_notice' );
        update_option( 'skincare_cosmetic_store_admin_notice', true );
        wp_safe_redirect( remove_query_arg( array( 'skincare_cosmetic_store_admin_notice', '_wpnonce' ) ) );
        exit;
    }
}
endif;
add_action( 'admin_init', 'skincare_cosmetic_store_update_admin_notice' );

add_action( 'after_switch_theme', 'skincare_cosmetic_store_setup_options' );
function skincare_cosmetic_store_setup_options() {
    update_option( 'skincare_cosmetic_store_admin_notice', false );
}

// Enqueue custom admin notice CSS
function skincare_cosmetic_store_enqueue_admin_notice_css( $hook ) {
    // Load CSS only on wp-admin pages (not the front end)
    wp_enqueue_style(
        'skincare-cosmetic-store-admin-notice-style',
        get_template_directory_uri() . '/assets/css/admin-notice.css',
        array(),
        SKINCARE_COSMETIC_STORE_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'skincare_cosmetic_store_enqueue_admin_notice_css' );


// changelog
function skincare_cosmetic_store_get_changelog_from_readme() {
    $file_path = get_template_directory() . '/readme.txt';

    if (!file_exists($file_path)) {
        return [];
    }

    $content = file_get_contents($file_path);

    // Check if changelog exists
    if (strpos($content, '== Changelog ==') === false) {
        return [];
    }

    // Extract only changelog section
    $changelog = explode('== Changelog ==', $content)[1];

    // Match versions like = 1.0 =
    preg_match_all('/=\s*([\d\.]+)\s*=\s*(.*?)(?=\n=\s*[\d\.]+\s*=|\Z)/s', $changelog, $matches, PREG_SET_ORDER);

    return $matches;
}

/**
 * XIAOHUA WhatsApp integration
 * ---------------------------------
 * Cambia SOLO este numero para usar tu WhatsApp real.
 * Formato: codigo de pais + numero, sin espacios, sin +, sin guiones.
 * Ejemplo Peru: 51987654321
 */
if ( ! defined( 'XIAOHUA_WHATSAPP_NUMBER' ) ) {
    define( 'XIAOHUA_WHATSAPP_NUMBER', '51958327294' ); // Numero WhatsApp XIAOHUA (Peru)
}

if ( ! function_exists( 'xiaohua_whatsapp_number' ) ) {
    function xiaohua_whatsapp_number() {
        $number = preg_replace( '/\D+/', '', (string) XIAOHUA_WHATSAPP_NUMBER );
        return $number;
    }
}

if ( ! function_exists( 'xiaohua_whatsapp_url' ) ) {
    function xiaohua_whatsapp_url( $message ) {
        $number = xiaohua_whatsapp_number();
        if ( '' === $number ) {
            return '';
        }
        return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
    }
}

if ( ! function_exists( 'xiaohua_whatsapp_floating_button' ) ) {
    function xiaohua_whatsapp_floating_button() {
        if ( is_admin() ) {
            return;
        }
        $message = 'Hola XIAOHUA, tengo una consulta sobre los productos de skincare';
        $url     = xiaohua_whatsapp_url( $message );
        if ( '' === $url ) {
            return;
        }
        ?>
        <a class="xiaohua-whatsapp-float" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Consultar por WhatsApp', 'skincare-cosmetic-store' ); ?>" title="<?php esc_attr_e( 'Consultar por WhatsApp', 'skincare-cosmetic-store' ); ?>">
            <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M16 3C9.373 3 4 8.149 4 14.5c0 2.033.558 3.931 1.528 5.6L4 29l9.146-1.494A12.43 12.43 0 0 0 16 26c6.627 0 12-5.149 12-11.5S22.627 3 16 3zm0 20.9c-1.01 0-2.003-.144-2.94-.428l-.67-.2-5.428.886.91-5.14-.352-.545A9.25 9.25 0 0 1 6.1 14.5c0-5.203 4.442-9.435 9.9-9.435 5.457 0 9.9 4.232 9.9 9.435 0 5.204-4.443 9.4-9.9 9.4zm5.43-7.034c-.297-.143-1.757-.834-2.03-.928-.273-.095-.472-.143-.67.143-.198.286-.77.928-.944 1.119-.173.19-.347.214-.644.071-.297-.143-1.255-.445-2.39-1.418-.884-.758-1.48-1.694-1.653-1.98-.174-.286-.019-.44.13-.583.134-.128.297-.333.446-.5.148-.167.198-.286.297-.476.099-.19.05-.357-.025-.5-.074-.143-.67-1.55-.918-2.122-.242-.558-.487-.482-.67-.491l-.57-.01c-.198 0-.52.071-.792.357-.273.286-1.04.976-1.04 2.38 0 1.404 1.064 2.761 1.213 2.952.148.19 2.095 3.075 5.076 4.313.709.295 1.262.471 1.693.603.711.217 1.358.187 1.87.113.57-.082 1.757-.69 2.005-1.357.248-.666.248-1.238.173-1.357-.074-.119-.272-.19-.57-.333z"/>
            </svg>
            <span class="xiaohua-whatsapp-float__label"><?php esc_html_e( 'WhatsApp', 'skincare-cosmetic-store' ); ?></span>
        </a>
        <?php
    }
}
add_action( 'wp_footer', 'xiaohua_whatsapp_floating_button' );

if ( ! function_exists( 'xiaohua_whatsapp_order_message' ) ) {
    function xiaohua_whatsapp_order_message( $order ) {
        if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
            return '';
        }

        $lines   = array();
        $lines[] = 'Hola XIAOHUA, quiero enviar el comprobante y solicitar la factura de mi pedido.';
        $lines[] = '';
        $lines[] = 'Pedido N°: ' . $order->get_order_number();
        $lines[] = 'Productos:';

        foreach ( $order->get_items() as $item ) {
            $name = wp_strip_all_tags( $item->get_name() );
            $qty  = (int) $item->get_quantity();
            $lines[] = '- ' . $name . ' x' . $qty;
        }

        $total = number_format( (float) $order->get_total(), 2, '.', '' );
        $currency = $order->get_currency();
        $total_label = 'S/ ' . $total;
        if ( 'PEN' !== $currency && ! empty( $currency ) ) {
            $total_label = $currency . ' ' . $total;
        }

        $lines[] = 'Total: ' . $total_label;
        $lines[] = '';
        $lines[] = 'Quedo atento(a) a la confirmación y a la factura. Gracias.';

        return implode( "\n", $lines );
    }
}

if ( ! function_exists( 'xiaohua_whatsapp_order_button_html' ) ) {
    function xiaohua_whatsapp_order_button_html( $order ) {
        $message = xiaohua_whatsapp_order_message( $order );
        $url     = xiaohua_whatsapp_url( $message );
        if ( '' === $url ) {
            return '';
        }

        ob_start();
        ?>
        <div class="xiaohua-whatsapp-order">
            <a class="xiaohua-whatsapp-order__btn" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
                <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M16 3C9.373 3 4 8.149 4 14.5c0 2.033.558 3.931 1.528 5.6L4 29l9.146-1.494A12.43 12.43 0 0 0 16 26c6.627 0 12-5.149 12-11.5S22.627 3 16 3zm0 20.9c-1.01 0-2.003-.144-2.94-.428l-.67-.2-5.428.886.91-5.14-.352-.545A9.25 9.25 0 0 1 6.1 14.5c0-5.203 4.442-9.435 9.9-9.435 5.457 0 9.9 4.232 9.9 9.435 0 5.204-4.443 9.4-9.9 9.4zm5.43-7.034c-.297-.143-1.757-.834-2.03-.928-.273-.095-.472-.143-.67.143-.198.286-.77.928-.944 1.119-.173.19-.347.214-.644.071-.297-.143-1.255-.445-2.39-1.418-.884-.758-1.48-1.694-1.653-1.98-.174-.286-.019-.44.13-.583.134-.128.297-.333.446-.5.148-.167.198-.286.297-.476.099-.19.05-.357-.025-.5-.074-.143-.67-1.55-.918-2.122-.242-.558-.487-.482-.67-.491l-.57-.01c-.198 0-.52.071-.792.357-.273.286-1.04.976-1.04 2.38 0 1.404 1.064 2.761 1.213 2.952.148.19 2.095 3.075 5.076 4.313.709.295 1.262.471 1.693.603.711.217 1.358.187 1.87.113.57-.082 1.757-.69 2.005-1.357.248-.666.248-1.238.173-1.357-.074-.119-.272-.19-.57-.333z"/>
                </svg>
                <span><?php esc_html_e( 'Enviar comprobante / pedir factura por WhatsApp', 'skincare-cosmetic-store' ); ?></span>
            </a>
            <p class="xiaohua-whatsapp-order__note"><?php esc_html_e( 'Se abrirá WhatsApp con el resumen de tu pedido para que podamos enviarte la factura.', 'skincare-cosmetic-store' ); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'xiaohua_whatsapp_thankyou_button' ) ) {
    function xiaohua_whatsapp_thankyou_button( $order_id ) {
        if ( ! empty( $GLOBALS['xiaohua_wa_order_btn_rendered'] ) ) {
            return;
        }
        if ( ! $order_id ) {
            return;
        }
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return;
        }
        $GLOBALS['xiaohua_wa_order_btn_rendered'] = true;
        echo xiaohua_whatsapp_order_button_html( $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
add_action( 'woocommerce_thankyou', 'xiaohua_whatsapp_thankyou_button', 20, 1 );

if ( ! function_exists( 'xiaohua_whatsapp_order_confirmation_block' ) ) {
    function xiaohua_whatsapp_order_confirmation_block( $block_content, $block ) {
        if ( is_admin() || empty( $block['blockName'] ) ) {
            return $block_content;
        }

        if ( 'woocommerce/order-confirmation-totals' !== $block['blockName'] ) {
            return $block_content;
        }

        if ( ! function_exists( 'is_order_received_page' ) || ! is_order_received_page() ) {
            return $block_content;
        }

        global $wp;
        $order_id = 0;
        if ( isset( $wp->query_vars['order-received'] ) ) {
            $order_id = absint( $wp->query_vars['order-received'] );
        }
        if ( ! $order_id ) {
            $order_id = absint( get_query_var( 'order-received' ) );
        }
        if ( ! $order_id ) {
            return $block_content;
        }

        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return $block_content;
        }

        $key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( $key && $order->get_order_key() !== $key ) {
            return $block_content;
        }

        if ( ! empty( $GLOBALS['xiaohua_wa_order_btn_rendered'] ) ) {
            return $block_content;
        }
        $GLOBALS['xiaohua_wa_order_btn_rendered'] = true;

        return $block_content . xiaohua_whatsapp_order_button_html( $order );
    }
}
add_filter( 'render_block', 'xiaohua_whatsapp_order_confirmation_block', 10, 2 );