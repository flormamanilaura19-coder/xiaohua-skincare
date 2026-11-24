<?php
/**
 * Plugin Name: Laragon Favicon
 * Description: Sirve un favicon propio del entorno Laragon para evitar el icono en cache de otros entornos locales (XAMPP).
 * Version: 1.0.0
 * Author: Laragon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Imprime el enlace del favicon en el frontend, el admin y el login.
 *
 * @return void
 */
function laragon_favicon_link() {
	echo '<link rel="icon" href="/favicon.ico?v=laragon" type="image/x-icon" sizes="any">' . "\n";
}
add_action( 'wp_head', 'laragon_favicon_link', 99 );
add_action( 'admin_head', 'laragon_favicon_link', 99 );
add_action( 'login_head', 'laragon_favicon_link', 99 );
