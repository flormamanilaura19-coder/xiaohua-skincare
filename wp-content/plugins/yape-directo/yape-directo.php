<?php
/**
 * Plugin Name: Yape Directo para WooCommerce
 * Description: Método de pago manual con Yape, independiente de Mercado Pago.
 * Version: 2.1.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: Tienda
 * Text Domain: yape-directo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'YAPE_DIRECTO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once __DIR__ . '/includes/tickets.php';

add_action( 'plugins_loaded', 'yape_directo_init', 11 );

function yape_directo_init() {
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
		return;
	}

	class WC_Gateway_Yape_Directo extends WC_Payment_Gateway {
		public function __construct() {
			$this->id                 = 'yape_directo';
			$this->icon               = '';
			$this->has_fields         = true;
			$this->method_title       = __( 'Yape Directo', 'yape-directo' );
			$this->method_description = __( 'Recibe pagos manuales por Yape y confirma los pedidos después de verificar el abono.', 'yape-directo' );
			$this->supports           = array( 'products' );

			$this->init_form_fields();
			$this->init_settings();

			$this->enabled      = $this->get_option( 'enabled', 'no' );
			$this->title        = $this->get_option( 'title', __( 'Yape', 'yape-directo' ) );
			$this->description  = $this->get_option( 'description', __( 'Paga con Yape. Verificaremos el pago antes de preparar tu pedido.', 'yape-directo' ) );
			$this->phone        = $this->get_option( 'phone', '' );
			$this->qr_url       = $this->get_option( 'qr_url', '' );
			if ( '' === $this->qr_url ) {
				$this->qr_url = YAPE_DIRECTO_PLUGIN_URL . 'assets/qr-yape.jpeg';
			}
			$this->instructions = $this->get_option( 'instructions', __( 'Yapea el total de tu pedido al número indicado. Tu pedido quedará pendiente hasta que verifiquemos el pago.', 'yape-directo' ) );

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
			add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'admin_order_data' ) );
			add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 4 );
		}

		public function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
					'title'   => __( 'Activar', 'yape-directo' ),
					'type'    => 'checkbox',
					'label'   => __( 'Activar Yape Directo', 'yape-directo' ),
					'default' => 'no',
				),
				'title' => array(
					'title'       => __( 'Título', 'yape-directo' ),
					'type'        => 'text',
					'default'     => __( 'Yape', 'yape-directo' ),
					'description' => __( 'Nombre que verá el cliente al pagar.', 'yape-directo' ),
					'desc_tip'    => true,
				),
				'description' => array(
					'title'   => __( 'Descripción', 'yape-directo' ),
					'type'    => 'textarea',
					'default' => __( 'Paga con Yape. Verificaremos el pago antes de preparar tu pedido.', 'yape-directo' ),
				),
				'phone' => array(
					'title'       => __( 'Número de Yape', 'yape-directo' ),
					'type'        => 'text',
					'default'     => '',
					'description' => __( 'Número al que el cliente debe enviar el pago.', 'yape-directo' ),
				),
				'qr_url' => array(
					'title'       => __( 'URL de imagen del QR (opcional)', 'yape-directo' ),
					'type'        => 'text',
					'default'     => plugins_url( 'assets/qr-yape.jpeg', __FILE__ ),
					'description' => __( 'Sube el QR a Medios y pega aquí la URL de la imagen.', 'yape-directo' ),
				),
				'instructions' => array(
					'title'   => __( 'Instrucciones de pago', 'yape-directo' ),
					'type'    => 'textarea',
					'default' => __( 'Yapea el total de tu pedido al número indicado. Tu pedido quedará pendiente hasta que verifiquemos el pago.', 'yape-directo' ),
				),
			);
		}

		public function payment_fields() {
			if ( $this->description ) {
				echo wpautop( wp_kses_post( $this->description ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			if ( $this->phone ) {
				echo '<p><strong>' . esc_html__( 'Número de Yape:', 'yape-directo' ) . '</strong> ' . esc_html( $this->phone ) . '</p>';
			}
			if ( $this->qr_url && wp_http_validate_url( $this->qr_url ) ) {
				echo '<p><img src="' . esc_url( $this->qr_url ) . '" alt="' . esc_attr__( 'Código QR para pagar con Yape', 'yape-directo' ) . '" style="max-width:220px;height:auto" /></p>';
			}
			if ( $this->instructions ) {
				echo wpautop( wp_kses_post( $this->instructions ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			woocommerce_form_field(
				'yape_operation_code',
				array(
					'type'        => 'text',
					'class'       => array( 'form-row-wide' ),
					'label'       => __( 'Código de operación de Yape', 'yape-directo' ),
					'required'    => true,
					'placeholder' => __( 'Ingresa el código que aparece en Yape', 'yape-directo' ),
				),
				''
			);
			echo '<p class="form-row form-row-wide"><label for="yape_receipt_upload">' . esc_html__( 'Foto o captura del pago (JPG, PNG o WebP; máximo 2 MB)', 'yape-directo' ) . ' <span class="required">*</span></label><input type="file" id="yape_receipt_upload" name="yape_receipt_upload" accept="image/jpeg,image/png,image/webp" required /></p>';
		}

		public function validate_fields() {
			$code = isset( $_POST['yape_operation_code'] ) ? sanitize_text_field( wp_unslash( $_POST['yape_operation_code'] ) ) : '';
			if ( '' === trim( $code ) ) {
				wc_add_notice( __( 'Ingresa el código de operación de Yape para continuar.', 'yape-directo' ), 'error' );
				return false;
			}
			$classic_upload = ! empty( $_FILES['yape_receipt_upload']['name'] ) && isset( $_FILES['yape_receipt_upload']['error'] ) && UPLOAD_ERR_OK === (int) $_FILES['yape_receipt_upload']['error'];
			$blocks_upload  = ! empty( $_POST['yape_receipt_data'] ) && is_string( $_POST['yape_receipt_data'] );
			if ( ! $classic_upload && ! $blocks_upload ) {
				wc_add_notice( __( 'Adjunta la foto o captura del pago de Yape.', 'yape-directo' ), 'error' );
				return false;
			}
			if ( $classic_upload && (int) $_FILES['yape_receipt_upload']['size'] > 2 * MB_IN_BYTES ) {
				wc_add_notice( __( 'La imagen del comprobante no debe superar 2 MB.', 'yape-directo' ), 'error' );
				return false;
			}
			if ( $blocks_upload && strlen( $_POST['yape_receipt_data'] ) > ( 4 * ceil( ( 2 * MB_IN_BYTES ) / 3 ) + 100 ) ) {
				wc_add_notice( __( 'La imagen del comprobante no debe superar 2 MB.', 'yape-directo' ), 'error' );
				return false;
			}
			return true;
		}

		public function process_payment( $order_id ) {
			$order = wc_get_order( $order_id );
			if ( ! $order ) {
				return array( 'result' => 'failure' );
			}

			$code = isset( $_POST['yape_operation_code'] ) ? sanitize_text_field( wp_unslash( $_POST['yape_operation_code'] ) ) : '';
			if ( '' === trim( $code ) ) {
				wc_add_notice( __( 'Ingresa el código de operación de Yape para continuar.', 'yape-directo' ), 'error' );
				return array( 'result' => 'failure' );
			}
			$receipt_id = yape_directo_save_receipt( $order_id );
			if ( is_wp_error( $receipt_id ) ) {
				wc_add_notice( $receipt_id->get_error_message(), 'error' );
				return array( 'result' => 'failure' );
			}
			$order->update_meta_data( '_yape_operation_code', $code );
			$order->update_meta_data( '_yape_receipt_attachment_id', $receipt_id );
			$order->update_meta_data( '_yape_payment_phone', $this->phone );
			$order->save();
			$order->update_status( 'on-hold', __( 'Esperando verificación manual del pago enviado por Yape.', 'yape-directo' ) );
			wc_reduce_stock_levels( $order_id );
			WC()->cart->empty_cart();

			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order ),
			);
		}

		public function thankyou_page( $order_id ) {
			$order = wc_get_order( $order_id );
			if ( $order && $order->get_payment_method() === $this->id ) {
				$this->render_instructions( $order );
			}
		}

		public function email_instructions( $order, $sent_to_admin, $plain_text, $email ) {
			if ( ! $sent_to_admin && $order instanceof WC_Order && $order->get_payment_method() === $this->id && $order->has_status( 'on-hold' ) && 'customer_on_hold_order' === $email->id ) {
				$this->render_instructions( $order );
			}
		}

		private function render_instructions( $order ) {
			echo '<section class="woocommerce-yape-directo-instructions"><h2>' . esc_html__( 'Pago con Yape', 'yape-directo' ) . '</h2>';
			if ( $this->instructions ) {
				echo wpautop( wp_kses_post( $this->instructions ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			$phone = $order->get_meta( '_yape_payment_phone' );
			if ( $phone ) {
				echo '<p><strong>' . esc_html__( 'Número de Yape:', 'yape-directo' ) . '</strong> ' . esc_html( $phone ) . '</p>';
			}
			if ( $this->qr_url && wp_http_validate_url( $this->qr_url ) ) {
				echo '<p><img src="' . esc_url( $this->qr_url ) . '" alt="' . esc_attr__( 'Código QR para pagar con Yape', 'yape-directo' ) . '" style="max-width:220px;height:auto" /></p>';
			}
			echo '<p>' . esc_html__( 'Código de operación indicado:', 'yape-directo' ) . ' ' . esc_html( $order->get_meta( '_yape_operation_code' ) ) . '</p></section>';
		}

		public function admin_order_data( $order ) {
			if ( $order->get_payment_method() === $this->id ) {
				echo '<p><strong>' . esc_html__( 'Código de operación Yape:', 'yape-directo' ) . '</strong> ' . esc_html( $order->get_meta( '_yape_operation_code' ) ) . '</p>';
				$receipt_id  = absint( $order->get_meta( '_yape_receipt_attachment_id' ) );
				$receipt_url = $receipt_id ? wp_get_attachment_url( $receipt_id ) : '';
				if ( $receipt_url ) {
					echo '<p><strong>' . esc_html__( 'Comprobante de Yape:', 'yape-directo' ) . '</strong><br><a href="' . esc_url( $receipt_url ) . '" target="_blank" rel="noopener noreferrer"><img src="' . esc_url( $receipt_url ) . '" alt="' . esc_attr__( 'Comprobante de pago Yape', 'yape-directo' ) . '" style="max-width:240px;height:auto" /></a></p>';
				}
				yape_directo_render_ticket_actions( $order );
			}
		}
	}
}

add_filter( 'woocommerce_payment_gateways', 'yape_directo_add_gateway' );
function yape_directo_add_gateway( $gateways ) {
	$gateways[] = 'WC_Gateway_Yape_Directo';
	return $gateways;
}

function yape_directo_save_receipt( $order_id ) {
	$allowed_mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'webp'         => 'image/webp',
	);

	if ( ! empty( $_FILES['yape_receipt_upload']['name'] ) ) {
		$file = $_FILES['yape_receipt_upload'];
		if ( UPLOAD_ERR_OK !== (int) $file['error'] || (int) $file['size'] > 2 * MB_IN_BYTES ) {
			return new WP_Error( 'yape_receipt_upload', __( 'No se pudo cargar el comprobante. Usa una imagen de hasta 2 MB.', 'yape-directo' ) );
		}
		$checked = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], $allowed_mimes );
		if ( empty( $checked['type'] ) || ! in_array( $checked['type'], $allowed_mimes, true ) ) {
			return new WP_Error( 'yape_receipt_type', __( 'El comprobante debe ser una imagen JPG, PNG o WebP.', 'yape-directo' ) );
		}
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$attachment_id = media_handle_upload( 'yape_receipt_upload', $order_id, array(), array( 'mimes' => $allowed_mimes ) );
		if ( is_wp_error( $attachment_id ) ) {
			return new WP_Error( 'yape_receipt_upload', __( 'No se pudo guardar el comprobante. Inténtalo nuevamente.', 'yape-directo' ) );
		}
		return (int) $attachment_id;
	}

	if ( ! isset( $_POST['yape_receipt_data'] ) ) {
		return new WP_Error( 'yape_receipt_required', __( 'Adjunta la foto o captura del pago de Yape.', 'yape-directo' ) );
	}

	$data_uri = (string) wp_unslash( $_POST['yape_receipt_data'] );
	if ( ! preg_match( '#^data:image/(jpeg|png|webp);base64,#', $data_uri, $matches ) ) {
		return new WP_Error( 'yape_receipt_type', __( 'Adjunta una imagen JPG, PNG o WebP válida.', 'yape-directo' ) );
	}
	$binary = base64_decode( substr( $data_uri, strpos( $data_uri, ',' ) + 1 ), true );
	if ( false === $binary || strlen( $binary ) > 2 * MB_IN_BYTES ) {
		return new WP_Error( 'yape_receipt_size', __( 'La imagen del comprobante no debe superar 2 MB.', 'yape-directo' ) );
	}
	$image = getimagesizefromstring( $binary );
	$expected_mime = 'image/jpeg' === $matches[1] ? 'image/jpeg' : 'image/' . $matches[1];
	if ( ! $image || empty( $image['mime'] ) || $expected_mime !== $image['mime'] ) {
		return new WP_Error( 'yape_receipt_invalid', __( 'El archivo adjunto no es una imagen válida.', 'yape-directo' ) );
	}

	$extension = 'jpeg' === $matches[1] ? 'jpg' : $matches[1];
	$filename  = sanitize_file_name( 'comprobante-yape-' . absint( $order_id ) . '.' . $extension );
	$upload    = wp_upload_bits( $filename, null, $binary );
	if ( ! empty( $upload['error'] ) ) {
		return new WP_Error( 'yape_receipt_upload', __( 'No se pudo guardar el comprobante. Inténtalo nuevamente.', 'yape-directo' ) );
	}
	$checked = wp_check_filetype( $upload['file'], $allowed_mimes );
	if ( empty( $checked['type'] ) ) {
		wp_delete_file( $upload['file'] );
		return new WP_Error( 'yape_receipt_type', __( 'El comprobante debe ser una imagen JPG, PNG o WebP.', 'yape-directo' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $checked['type'],
			'post_title'     => sprintf( __( 'Comprobante Yape pedido %d', 'yape-directo' ), absint( $order_id ) ),
			'post_status'    => 'inherit',
		),
		$upload['file'],
		$order_id,
		true
	);
	if ( is_wp_error( $attachment_id ) ) {
		wp_delete_file( $upload['file'] );
		return new WP_Error( 'yape_receipt_upload', __( 'No se pudo guardar el comprobante. Inténtalo nuevamente.', 'yape-directo' ) );
	}
	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
	return (int) $attachment_id;
}

add_action( 'woocommerce_blocks_loaded', 'yape_directo_register_blocks_support' );
function yape_directo_register_blocks_support() {
	if ( ! class_exists( '\Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
		return;
	}

	class WC_Gateway_Yape_Directo_Blocks extends \Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType {
		protected $name = 'yape_directo';

		public function initialize() {
			$this->settings = get_option( 'woocommerce_yape_directo_settings', array() );
		}

		public function is_active() {
			return 'yes' === $this->get_setting( 'enabled', 'no' );
		}

		public function get_payment_method_script_handles() {
			wp_register_script(
				'yape-directo-blocks',
				YAPE_DIRECTO_PLUGIN_URL . 'assets/js/yape-directo-blocks.js',
				array( 'wc-blocks-registry', 'wc-settings', 'wp-element', 'wp-i18n' ),
				'1.1.0',
				true
			);
			return array( 'yape-directo-blocks' );
		}

		public function get_payment_method_data() {
			$qr_url = $this->get_setting( 'qr_url' );
			if ( ! $qr_url ) {
				$qr_url = YAPE_DIRECTO_PLUGIN_URL . 'assets/qr-yape.jpeg';
			}
			return array(
				'title'        => $this->get_setting( 'title', __( 'Yape', 'yape-directo' ) ),
				'description'  => $this->get_setting( 'description', '' ),
				'instructions' => $this->get_setting( 'instructions', '' ),
				'phone'        => $this->get_setting( 'phone', '' ),
				'qrUrl'        => esc_url_raw( $qr_url ),
				'supports'     => array( 'products' ),
			);
		}
	}

	add_action(
		'woocommerce_blocks_payment_method_type_registration',
		function ( $registry ) {
			$registry->register( new WC_Gateway_Yape_Directo_Blocks() );
		}
	);
}
