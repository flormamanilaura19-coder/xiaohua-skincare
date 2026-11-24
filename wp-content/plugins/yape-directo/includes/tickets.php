<?php
/** Ticket generation and delivery for Yape Directo orders. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_yape_directo_download_ticket', 'yape_directo_download_ticket' );
add_action( 'admin_post_yape_directo_email_ticket', 'yape_directo_email_ticket' );
add_action( 'admin_post_yape_directo_generate_ticket', 'yape_directo_generate_ticket' );
add_action( 'template_redirect', 'yape_directo_serve_public_ticket' );
add_action( 'admin_notices', 'yape_directo_ticket_admin_notice' );

define( 'YAPE_DIRECTO_TICKET_VERSION', 10 );

function yape_directo_render_ticket_actions( $order ) {
	$order_id = $order->get_id();
	$download = wp_nonce_url(
		admin_url( 'admin-post.php?action=yape_directo_download_ticket&order_id=' . $order_id ),
		'yape_directo_download_ticket_' . $order_id
	);
	$generate = wp_nonce_url(
		admin_url( 'admin-post.php?action=yape_directo_generate_ticket&order_id=' . $order_id ),
		'yape_directo_generate_ticket_' . $order_id
	);
	$customer_email = $order->get_billing_email();
	$customer_name  = trim( $order->get_formatted_billing_full_name() );
	if ( '' === $customer_name ) {
		$customer_name = __( 'cliente', 'yape-directo' );
	}
	$ticket_ready = (bool) $order->get_meta( '_yape_directo_ticket_pdf' );
	$ticket_url   = $ticket_ready ? yape_directo_get_public_ticket_url( $order ) : '';
	$phone      = preg_replace( '/\D+/', '', (string) $order->get_billing_phone() );
	if ( 9 === strlen( $phone ) && '9' === substr( $phone, 0, 1 ) ) {
		$phone = '51' . $phone;
	} elseif ( 11 === strlen( $phone ) && '0' === substr( $phone, 0, 2 ) ) {
		$phone = '51' . substr( $phone, 2 );
	}
	$message = sprintf(
		/* translators: 1: customer name, 2: order number, 3: total, 4: ticket link. */
		__( 'Hola %1$s, aquí tienes el ticket de tu pedido #%2$s por %3$s: %4$s', 'yape-directo' ),
		$customer_name,
		$order->get_order_number(),
		wp_strip_all_tags( $order->get_formatted_order_total() ),
		$ticket_url
	);
	$whatsapp_url = $phone ? 'https://wa.me/' . rawurlencode( $phone ) . '?text=' . rawurlencode( $message ) : '';

	echo '<div class="yape-directo-ticket-actions"><h4>' . esc_html__( 'Ticket de compra', 'yape-directo' ) . '</h4>';
	echo '<p><a class="button button-primary" href="' . esc_url( $generate ) . '">' . esc_html( $ticket_ready ? __( 'Generar nuevamente el ticket', 'yape-directo' ) : __( 'Generar ticket PDF', 'yape-directo' ) ) . '</a></p>';
	if ( $ticket_ready ) {
		echo '<p><a class="button" href="' . esc_url( $download ) . '">' . esc_html__( 'Descargar ticket PDF', 'yape-directo' ) . '</a></p>';
	}
	if ( $customer_email && $ticket_ready ) {
		$email_url = wp_nonce_url(
			admin_url( 'admin-post.php?action=yape_directo_email_ticket&order_id=' . $order_id ),
			'yape_directo_email_ticket_' . $order_id
		);
		echo '<p><a class="button button-primary" href="' . esc_url( $email_url ) . '" onclick="return confirm(\'' . esc_js( __( '¿Enviar el ticket al correo del cliente?', 'yape-directo' ) ) . '\')">' . esc_html__( 'Enviar ticket por correo', 'yape-directo' ) . '</a> <span>' . esc_html( $customer_email ) . '</span></p>';
	} elseif ( ! $customer_email ) {
		echo '<p>' . esc_html__( 'Este pedido no tiene correo del cliente.', 'yape-directo' ) . '</p>';
	} else {
		echo '<p>' . esc_html__( 'Genera el ticket antes de enviarlo por correo.', 'yape-directo' ) . '</p>';
	}
	if ( $whatsapp_url && $ticket_ready ) {
		echo '<p><a class="button" href="' . esc_url( $whatsapp_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Abrir WhatsApp con el ticket', 'yape-directo' ) . '</a> <span>' . esc_html( $order->get_billing_phone() ) . '</span></p>';
	} elseif ( ! $phone ) {
		echo '<p>' . esc_html__( 'Este pedido no tiene un teléfono para WhatsApp.', 'yape-directo' ) . '</p>';
	} else {
		echo '<p>' . esc_html__( 'Genera el ticket antes de compartirlo por WhatsApp.', 'yape-directo' ) . '</p>';
	}
	echo '<p class="description">' . esc_html__( 'WhatsApp abrirá el mensaje listo para que confirmes el envío. El enlace del ticket es privado para quien lo reciba.', 'yape-directo' ) . '</p></div>';
}

function yape_directo_ticket_authorize_order( $order_id ) {
	if ( ! current_user_can( 'edit_shop_order', $order_id ) && ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( esc_html__( 'No tienes permiso para acceder a este pedido.', 'yape-directo' ), '', array( 'response' => 403 ) );
	}
	$order = wc_get_order( $order_id );
	if ( ! $order || 'yape_directo' !== $order->get_payment_method() ) {
		wp_die( esc_html__( 'No se encontró un pedido de Yape válido.', 'yape-directo' ), '', array( 'response' => 404 ) );
	}
	return $order;
}

function yape_directo_download_ticket() {
	$order_id = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
	check_admin_referer( 'yape_directo_download_ticket_' . $order_id );
	$order = yape_directo_ticket_authorize_order( $order_id );
	$pdf   = yape_directo_get_saved_ticket_pdf( $order );
	if ( is_wp_error( $pdf ) ) {
		wp_die( esc_html( $pdf->get_error_message() ) );
	}
	if ( ! headers_sent() ) {
		nocache_headers();
		header( 'Content-Type: application/pdf' );
		header( 'Content-Disposition: attachment; filename="ticket-pedido-' . sanitize_file_name( $order->get_order_number() ) . '.pdf"' );
		header( 'Content-Length: ' . strlen( $pdf ) );
	}
	echo $pdf; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}

function yape_directo_generate_ticket() {
	$order_id = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
	check_admin_referer( 'yape_directo_generate_ticket_' . $order_id );
	$order = yape_directo_ticket_authorize_order( $order_id );
	$pdf   = yape_directo_build_ticket_pdf( $order );
	if ( ! is_wp_error( $pdf ) ) {
		$order->update_meta_data( '_yape_directo_ticket_pdf', base64_encode( $pdf ) );
		$order->update_meta_data( '_yape_directo_ticket_version', YAPE_DIRECTO_TICKET_VERSION );
		$order->update_meta_data( '_yape_directo_ticket_generated_at', current_time( 'mysql', true ) );
		$order->add_order_note( __( 'Se generó o actualizó el ticket PDF de compra.', 'yape-directo' ) );
		$order->save();
		$status = 'generated';
	} else {
		$status = 'failed';
	}
	$referer  = wp_get_referer();
	$redirect = $referer ? $referer : admin_url( 'edit.php?post_type=shop_order' );
	wp_safe_redirect( add_query_arg( 'yape_ticket_status', $status, $redirect ) );
	exit;
}

function yape_directo_email_ticket() {
	$order_id = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
	check_admin_referer( 'yape_directo_email_ticket_' . $order_id );
	$order = yape_directo_ticket_authorize_order( $order_id );
	$email = sanitize_email( $order->get_billing_email() );
	$status = 'failed';
	if ( $email ) {
		$pdf = yape_directo_get_saved_ticket_pdf( $order );
		if ( ! is_wp_error( $pdf ) ) {
			$temp_base = tempnam( get_temp_dir(), 'yape-ticket-' );
			$temp_pdf  = $temp_base ? $temp_base . '.pdf' : '';
			if ( $temp_base && @rename( $temp_base, $temp_pdf ) && false !== file_put_contents( $temp_pdf, $pdf ) ) {
				$headers = array( 'Content-Type: text/html; charset=UTF-8' );
				$body    = '<p>' . esc_html( sprintf( __( 'Hola %s, adjuntamos el ticket de tu pedido.', 'yape-directo' ), $order->get_billing_first_name() ) ) . '</p>';
				$body   .= '<p><a href="' . esc_url( yape_directo_get_public_ticket_url( $order ) ) . '">' . esc_html__( 'Ver o descargar el ticket', 'yape-directo' ) . '</a></p>';
				$body   .= '<p>' . esc_html__( 'El estado del pago se muestra en el ticket.', 'yape-directo' ) . '</p>';
				$sent = wp_mail(
					$email,
					sprintf( __( 'Ticket de compra #%s', 'yape-directo' ), $order->get_order_number() ),
					$body,
					$headers,
					array( $temp_pdf )
				);
				$status = $sent ? 'sent' : 'failed';
				@unlink( $temp_pdf );
			} elseif ( $temp_base ) {
				@unlink( $temp_base );
			}
		}
	}
	$order->add_order_note( $status === 'sent' ? sprintf( __( 'Ticket PDF enviado por correo a %s.', 'yape-directo' ), $email ) : __( 'No se pudo enviar el ticket por correo.', 'yape-directo' ) );
	$order->save();
	$referer = wp_get_referer();
	$redirect = $referer ? $referer : admin_url( 'edit.php?post_type=shop_order' );
	wp_safe_redirect( add_query_arg( 'yape_ticket_status', $status, $redirect ) );
	exit;
}

function yape_directo_ticket_admin_notice() {
	if ( ! isset( $_GET['yape_ticket_status'] ) || ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	$status = sanitize_key( wp_unslash( $_GET['yape_ticket_status'] ) );
	if ( 'sent' === $status ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'El ticket se envió por correo.', 'yape-directo' ) . '</p></div>';
	} elseif ( 'generated' === $status ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'El ticket se generó y quedó guardado en el pedido.', 'yape-directo' ) . '</p></div>';
	} elseif ( 'failed' === $status ) {
		echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'No se pudo enviar el ticket. Revisa el correo del pedido y la configuración de correo de WordPress.', 'yape-directo' ) . '</p></div>';
	}
}

function yape_directo_get_public_ticket_url( $order ) {
	$token = $order->get_meta( '_yape_directo_ticket_token' );
	if ( ! $token ) {
		$token = wp_generate_password( 48, false, false );
		$order->update_meta_data( '_yape_directo_ticket_token', $token );
		$order->save();
	}
	return add_query_arg( 'yape_ticket', rawurlencode( $token ), home_url( '/' ) );
}

function yape_directo_serve_public_ticket() {
	if ( empty( $_GET['yape_ticket'] ) ) {
		return;
	}
	$token = sanitize_text_field( wp_unslash( $_GET['yape_ticket'] ) );
	$orders = wc_get_orders(
		array(
			'limit'     => 1,
			'meta_key'  => '_yape_directo_ticket_token',
			'meta_value'=> $token,
			'return'    => 'objects',
		)
	);
	$order = ! empty( $orders ) ? $orders[0] : false;
	if ( ! $order || 'yape_directo' !== $order->get_payment_method() ) {
		wp_die( esc_html__( 'El enlace del ticket no es válido.', 'yape-directo' ), '', array( 'response' => 404 ) );
	}
	$pdf = yape_directo_get_saved_ticket_pdf( $order );
	if ( is_wp_error( $pdf ) ) {
		wp_die( esc_html( $pdf->get_error_message() ) );
	}
	nocache_headers();
	header( 'Content-Type: application/pdf' );
	header( 'Content-Disposition: inline; filename="ticket-pedido-' . sanitize_file_name( $order->get_order_number() ) . '.pdf"' );
	header( 'Content-Length: ' . strlen( $pdf ) );
	echo $pdf; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}

function yape_directo_get_saved_ticket_pdf( $order ) {
	$encoded = $order->get_meta( '_yape_directo_ticket_pdf' );
	$pdf     = $encoded ? base64_decode( $encoded, true ) : false;
	if ( false === $pdf || 0 !== strpos( $pdf, '%PDF-' ) ) {
		return new WP_Error( 'yape_ticket_missing', __( 'Primero genera el ticket desde los detalles del pedido.', 'yape-directo' ) );
	}
	if ( (int) $order->get_meta( '_yape_directo_ticket_version' ) < YAPE_DIRECTO_TICKET_VERSION ) {
		$pdf = yape_directo_build_ticket_pdf( $order );
		if ( is_wp_error( $pdf ) ) {
			return $pdf;
		}
		$order->update_meta_data( '_yape_directo_ticket_pdf', base64_encode( $pdf ) );
		$order->update_meta_data( '_yape_directo_ticket_version', YAPE_DIRECTO_TICKET_VERSION );
		$order->save();
	}
	return $pdf;
}

function yape_directo_build_ticket_pdf( $order ) {
	$money = function ( $amount ) use ( $order ) {
		return html_entity_decode( wp_strip_all_tags( wc_price( $amount, array( 'currency' => $order->get_currency() ) ) ), ENT_QUOTES, 'UTF-8' );
	};
	$rows = array();
	$add_text = function ( $text, $style = 'body' ) use ( &$rows ) {
		$rows[] = array( 'type' => 'text', 'text' => (string) $text, 'style' => $style );
	};
	$add_text( 'DATOS DEL CLIENTE', 'section' );
	$add_text( 'Cliente: ' . trim( $order->get_formatted_billing_full_name() ) );
	if ( $order->get_billing_phone() ) {
		$add_text( 'Teléfono: ' . $order->get_billing_phone() );
	}
	if ( $order->get_billing_email() ) {
		$add_text( 'Correo: ' . $order->get_billing_email() );
	}
	$billing = $order->get_address( 'billing' );
	$billing_address = array_filter( array( $billing['address_1'] ?? '', $billing['address_2'] ?? '', $billing['city'] ?? '', $billing['state'] ?? '', $billing['postcode'] ?? '', $billing['country'] ?? '' ) );
	if ( $billing_address ) {
		$add_text( 'Dirección: ' . implode( ', ', $billing_address ) );
	}
	$shipping = $order->get_address( 'shipping' );
	if ( ! empty( $shipping['address_1'] ) || ! empty( $shipping['city'] ) ) {
		$shipping_address = array_filter( array( $shipping['first_name'] ?? '', $shipping['last_name'] ?? '', $shipping['address_1'] ?? '', $shipping['address_2'] ?? '', $shipping['city'] ?? '', $shipping['state'] ?? '', $shipping['postcode'] ?? '', $shipping['country'] ?? '' ) );
		$add_text( 'Envío a: ' . implode( ', ', $shipping_address ) );
	}
	$shipping = $order->get_address( 'shipping' );
	if ( ! empty( $shipping['address_1'] ) || ! empty( $shipping['city'] ) ) {
		$add_text( 'Envío a: ' . trim( ( $shipping['first_name'] ?? '' ) . ' ' . ( $shipping['last_name'] ?? '' ) . ', ' . ( $shipping['address_1'] ?? '' ) . ', ' . ( $shipping['city'] ?? '' ) ) );
	}
	$rows[] = array( 'type' => 'rule', 'double' => true );
	$add_text( 'DETALLE DE PRODUCTOS', 'section' );
	$rows[] = array( 'type' => 'table_header' );
	foreach ( $order->get_items() as $item ) {
		$quantity   = max( 1, (int) $item->get_quantity() );
		$unit_price = $item->get_subtotal() / $quantity;
		$rows[]     = array(
			'type'     => 'item',
			'name'     => $item->get_name(),
			'quantity' => $quantity,
			'price'    => $money( $unit_price ),
			'total'    => $money( $item->get_total() ),
			'sku'      => $item->get_product() ? $item->get_product()->get_sku() : '',
			'meta'     => array_map(
				function ( $meta ) {
					return wp_strip_all_tags( $meta->display_key . ': ' . $meta->display_value );
				},
				$item->get_formatted_meta_data( '' )
			),
		);
	}
	$rows[] = array( 'type' => 'rule', 'double' => true );
	$rows[] = array( 'type' => 'rule', 'double' => true );
	$rows[] = array( 'type' => 'total', 'label' => 'Base imponible', 'value' => $money( max( 0, $order->get_subtotal() - $order->get_discount_total() ) ) );
	if ( (float) $order->get_discount_total() > 0 ) {
		$rows[] = array( 'type' => 'total', 'label' => 'Descuento', 'value' => '- ' . $money( $order->get_discount_total() ) );
	}
	foreach ( $order->get_items( 'fee' ) as $fee ) {
		$rows[] = array( 'type' => 'total', 'label' => $fee->get_name(), 'value' => $money( $fee->get_total() ) );
	}
	foreach ( $order->get_items( 'shipping' ) as $shipping_item ) {
		$rows[] = array( 'type' => 'total', 'label' => 'Envío ' . $shipping_item->get_name(), 'value' => $money( $shipping_item->get_total() ) );
	}
	$rows[] = array( 'type' => 'total', 'label' => 'Total IVA', 'value' => $money( $order->get_total_tax() ) );
	$rows[] = array( 'type' => 'grand_total', 'label' => 'TOTAL A PAGAR', 'value' => $money( $order->get_total() ) );
	$rows[] = array( 'type' => 'rule', 'double' => false );
	$add_text( 'INFORMACIÓN DEL PAGO', 'section' );
	$add_text( 'Método de pago: ' . $order->get_payment_method_title() );
	$add_text( 'Estado: ' . ( $order->is_paid() ? 'Pago confirmado' : 'Pendiente de verificación' ) );
	$operation = $order->get_meta( '_yape_operation_code' );
	if ( $operation ) {
		$add_text( 'Operación Yape: ' . $operation );
	}
	if ( $order->get_meta( '_yape_receipt_attachment_id' ) ) {
		$add_text( 'Voucher Yape adjunto al pedido.' );
	}
	$rows[] = array( 'type' => 'rule', 'double' => false );
	$add_text( '¡Gracias por su compra!', 'thanks' );
	$add_text( 'Documento informativo; no reemplaza el comprobante electrónico autorizado por SUNAT.', 'footnote' );

	$body_height = 0;
	foreach ( $rows as $row ) {
		if ( 'item' === $row['type'] ) {
			$body_height += max( 1, count( explode( "\n", wordwrap( $row['name'], 23, "\n", true ) ) ) ) * 13;
			$body_height += $row['sku'] ? 10 : 0;
			foreach ( $row['meta'] as $detail ) {
				$body_height += count( explode( "\n", wordwrap( $detail, 38, "\n", true ) ) ) * 9;
			}
		} elseif ( 'table_header' === $row['type'] ) {
			$body_height += 24;
		} elseif ( 'rule' === $row['type'] ) {
			$body_height += $row['double'] ? 14 : 10;
		} elseif ( 'total' === $row['type'] ) {
			$body_height += 13;
		} elseif ( 'grand_total' === $row['type'] ) {
			$body_height += 25;
		} elseif ( 'text' === $row['type'] ) {
			$text_width = 'footnote' === $row['style'] ? 48 : 38;
			$line_count = count( explode( "\n", wordwrap( $row['text'], $text_width, "\n", true ) ) );
			$body_height += $line_count * ( in_array( $row['style'], array( 'section', 'thanks' ), true ) ? 17 : ( 'footnote' === $row['style'] ? 9 : 12 ) );
		} else {
			$body_height += 13;
		}
	}
	$objects     = array(
		1 => '<< /Type /Catalog /Pages 2 0 R >>',
		2 => '',
		3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>',
		4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>',
	);
	$text_command = function ( $text, $font, $size, $x, $y, $align = 'left', $color = '0 0 0' ) {
		$text = function_exists( 'iconv' ) ? iconv( 'UTF-8', 'Windows-1252//TRANSLIT//IGNORE', (string) $text ) : (string) $text;
		if ( false === $text ) {
			$text = preg_replace( '/[^\x20-\x7E]/', '', (string) $text );
		}
		$text = str_replace( array( '\\', '(', ')' ), array( '\\\\', '\\(', '\\)' ), $text );
		$approx_width = strlen( $text ) * $size * 0.47;
		if ( 'center' === $align ) {
			$x = max( 10, ( 226 - $approx_width ) / 2 );
		} elseif ( 'right' === $align ) {
			$x = max( 10, $x - $approx_width );
		}
		return sprintf( "BT /%s %d Tf %s rg 1 0 0 1 %.2f %d Tm (%s) Tj ET\n", $font, $size, $color, $x, $y, $text );
	};
	$store_name  = get_bloginfo( 'name' );
	$store_lines = array( $store_name, 'COMPROBANTE DE VENTA' );
	$store_address = array_filter(
		array(
			get_option( 'woocommerce_store_address' ),
			get_option( 'woocommerce_store_address_2' ),
			get_option( 'woocommerce_store_city' ),
			get_option( 'woocommerce_store_postcode' ),
			get_option( 'woocommerce_store_country' ),
		)
	);
	if ( $store_address ) {
		$store_lines[] = implode( ', ', $store_address );
	}
	$store_email = get_option( 'woocommerce_email_from_address' );
	if ( $store_email ) {
		$store_lines[] = $store_email;
	}
	$store_phone = get_option( 'woocommerce_store_phone' );
	if ( $store_phone ) {
		$store_lines[] = $store_phone;
	}
	$header_line_count = 0;
	foreach ( $store_lines as $store_line ) {
		$header_line_count += count( explode( "\n", wordwrap( $store_line, 31, "\n", true ) ) );
	}
	$page_height = max( 460, 125 + ( 12 * $header_line_count ) + $body_height );
	$content = '';
	$header_y = $page_height - 27;
	foreach ( $store_lines as $index => $store_line ) {
		$store_line = wordwrap( $store_line, 31, "\n", true );
		foreach ( explode( "\n", $store_line ) as $store_line_part ) {
			$font  = in_array( $index, array( 0, 1 ), true ) ? 'F2' : 'F1';
			$size  = 0 === $index ? 11 : ( 1 === $index ? 9 : 7 );
			$color = 1 === $index ? '0.30 0.13 0.31' : '0 0 0';
			$content .= $text_command( $store_line_part, $font, $size, 0, $header_y, 'center', $color );
			$header_y -= ( 1 === $index ) ? 15 : 12;
		}
	}
	$order_date = $order->get_date_created() ? wc_format_datetime( $order->get_date_created() ) : current_time( 'mysql' );
	$y = $header_y - 12;
	$content .= "0 G 0.6 w 12 " . ( $y + 7 ) . " m 214 " . ( $y + 7 ) . " l S\n12 " . ( $y + 4 ) . " m 214 " . ( $y + 4 ) . " l S\n";
	$content .= "0.95 0.94 0.96 rg\n10 " . ( $y - 15 ) . " 206 20 re f\n";
	$content .= $text_command( 'FECHA: ' . $order_date, 'F1', 7, 14, $y - 8 );
	$content .= $text_command( 'TICKET: #' . $order->get_order_number(), 'F2', 7, 212, $y - 8, 'right' );
	$y -= 28;
	$item_index = 0;
	foreach ( $rows as $row ) {
		if ( 'text' === $row['type'] ) {
			$size = 'footnote' === $row['style'] ? 6 : ( 'thanks' === $row['style'] ? 10 : 7 );
			$font = in_array( $row['style'], array( 'section', 'thanks' ), true ) ? 'F2' : 'F1';
			$align = 'thanks' === $row['style'] ? 'center' : 'left';
			$color = 'section' === $row['style'] || 'thanks' === $row['style'] ? '0.30 0.13 0.31' : ( 'footnote' === $row['style'] ? '0.35 0.35 0.35' : '0 0 0' );
			foreach ( explode( "\n", wordwrap( $row['text'], 'footnote' === $row['style'] ? 48 : 38, "\n", true ) ) as $text_line ) {
				if ( 'section' === $row['style'] ) {
					$content .= "0.95 0.94 0.96 rg\n10 " . ( $y - 4 ) . " 206 15 re f\n";
				}
				$content .= $text_command( $text_line, $font, $size, 14, $y, $align, $color );
				$y -= 'thanks' === $row['style'] ? 17 : ( 'footnote' === $row['style'] ? 9 : ( 'section' === $row['style'] ? 17 : 12 ) );
			}
		} elseif ( 'rule' === $row['type'] ) {
			$content .= "0 G 0.6 w\n12 " . ( $y + 4 ) . " m 214 " . ( $y + 4 ) . " l S\n";
			if ( $row['double'] ) {
				$content .= "12 " . ( $y + 1 ) . " m 214 " . ( $y + 1 ) . " l S\n";
			}
			$y -= $row['double'] ? 9 : 7;
		} elseif ( 'table_header' === $row['type'] ) {
			$content .= "0.88 0.87 0.89 rg\n10 " . ( $y - 5 ) . " 206 17 re f\n";
			$content .= $text_command( 'Producto', 'F2', 7, 12, $y );
			$content .= $text_command( 'Cant.', 'F2', 6, 111, $y, 'right' );
			$content .= $text_command( 'P.Unit.', 'F2', 6, 162, $y, 'right' );
			$content .= $text_command( 'Importe', 'F2', 6, 214, $y, 'right' );
			$y -= 18;
		} elseif ( 'item' === $row['type'] ) {
			$name_lines = explode( "\n", wordwrap( $row['name'], 23, "\n", true ) );
			$meta_rows  = array_filter( array( $row['sku'] ? 'SKU: ' . $row['sku'] : '', ...$row['meta'] ) );
			$item_height = ( count( $name_lines ) * 13 ) + ( count( $meta_rows ) * 9 ) + 4;
			if ( 0 === $item_index % 2 ) {
				$content .= sprintf( "0.97 0.97 0.98 rg\n10 %d 206 %d re f\n", $y - $item_height + 7, $item_height );
			}
			foreach ( $name_lines as $line_index => $name_line ) {
				$content .= $text_command( $name_line, 'F2', 7, 12, $y );
				if ( 0 === $line_index ) {
					$content .= $text_command( $row['quantity'], 'F1', 6, 111, $y, 'right' );
					$content .= $text_command( $row['price'], 'F1', 6, 162, $y, 'right' );
					$content .= $text_command( $row['total'], 'F1', 6, 214, $y, 'right' );
				}
				$y -= 13;
			}
			foreach ( $meta_rows as $detail ) {
				foreach ( explode( "\n", wordwrap( $detail, 38, "\n", true ) ) as $detail_line ) {
					$content .= $text_command( $detail_line, 'F1', 6, 18, $y, 'left', '0.35 0.35 0.35' );
					$y -= 9;
				}
			}
			$y -= 4;
			++$item_index;
		} elseif ( 'total' === $row['type'] ) {
			$content .= $text_command( $row['label'], 'F1', 7, 16, $y );
			$content .= $text_command( $row['value'], 'F1', 7, 210, $y, 'right' );
			$y -= 12;
		} elseif ( 'grand_total' === $row['type'] ) {
			$content .= "0.90 0.88 0.92 rg\n10 " . ( $y - 8 ) . " 206 23 re f\n";
			$content .= $text_command( $row['label'], 'F2', 9, 16, $y, 'left', '0.30 0.13 0.31' );
			$content .= $text_command( $row['value'], 'F2', 10, 210, $y, 'right', '0.30 0.13 0.31' );
			$y -= 25;
		}
	}

	$objects = array(
		1 => '<< /Type /Catalog /Pages 2 0 R >>',
		2 => '<< /Type /Pages /Kids [5 0 R] /Count 1 >>',
		3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>',
		4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>',
		5 => '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 226 ' . $page_height . '] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents 6 0 R >>',
		6 => '<< /Length ' . strlen( $content ) . ">>\nstream\n" . $content . 'endstream',
	);
	$pdf     = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
	$offsets = array( 0 );
	foreach ( $objects as $id => $object ) {
		$offsets[ $id ] = strlen( $pdf );
		$pdf .= $id . " 0 obj\n" . $object . "\nendobj\n";
	}
	$xref = strlen( $pdf );
	$pdf .= "xref\n0 " . ( count( $objects ) + 1 ) . "\n0000000000 65535 f \n";
	for ( $id = 1; $id <= count( $objects ); $id++ ) {
		$pdf .= sprintf( "%010d 00000 n \n", $offsets[ $id ] );
	}
	$pdf .= 'trailer << /Size ' . ( count( $objects ) + 1 ) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
	return $pdf;
}
