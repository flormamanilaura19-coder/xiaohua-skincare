( function () {
	const { registerPaymentMethod } = window.wc.wcBlocksRegistry;
	const { getPaymentMethodData } = window.wc.wcSettings;
	const { createElement, useEffect, useState } = window.wp.element;
	const settings = getPaymentMethodData( 'yape_directo', {} );

	const Label = ( { components } ) =>
		createElement( components.PaymentMethodLabel, {
			text: settings.title || 'Yape',
		} );

	const Content = ( props ) => {
		const [ operationCode, setOperationCode ] = useState( '' );
		const [ receipt, setReceipt ] = useState( null );
		const registration = props.eventRegistration || {};
		const onPaymentProcessing = registration.onPaymentProcessing;
		const responseTypes = props.emitResponse ? props.emitResponse.responseTypes : {};

		useEffect( () => {
			if ( ! onPaymentProcessing ) {
				return undefined;
			}
			return onPaymentProcessing( async () => {
				if ( ! operationCode.trim() ) {
					return {
						type: responseTypes.ERROR,
						message: 'Ingresa el código de operación de Yape para continuar.',
						messageContext: 'wc/checkout',
					};
				}
				if ( ! receipt ) {
					return {
						type: responseTypes.ERROR,
						message: 'Adjunta la foto o captura del pago de Yape.',
						messageContext: 'wc/checkout',
					};
				}
				if ( receipt.size > 2 * 1024 * 1024 ) {
					return {
						type: responseTypes.ERROR,
						message: 'La imagen del comprobante no debe superar 2 MB.',
						messageContext: 'wc/checkout',
					};
				}
				if ( ! [ 'image/jpeg', 'image/png', 'image/webp' ].includes( receipt.type ) ) {
					return {
						type: responseTypes.ERROR,
						message: 'Adjunta una imagen JPG, PNG o WebP.',
						messageContext: 'wc/checkout',
					};
				}
				const receiptData = await new Promise( ( resolve, reject ) => {
					const reader = new FileReader();
					reader.onload = () => resolve( reader.result );
					reader.onerror = () => reject( new Error( 'No se pudo leer la imagen.' ) );
					reader.readAsDataURL( receipt );
				} ).catch( () => null );
				if ( ! receiptData ) {
					return {
						type: responseTypes.ERROR,
						message: 'No se pudo leer la imagen. Vuelve a seleccionarla.',
						messageContext: 'wc/checkout',
					};
				}
				return {
					type: responseTypes.SUCCESS,
					meta: {
						paymentMethodData: {
							yape_operation_code: operationCode.trim(),
							yape_receipt_data: receiptData,
						},
					},
				};
			} );
		}, [ onPaymentProcessing, operationCode, receipt, responseTypes.ERROR, responseTypes.SUCCESS ] );

		return createElement(
			'div',
			{ className: 'yape-directo-block-content' },
			settings.description ? createElement( 'p', null, settings.description ) : null,
			settings.phone ? createElement( 'p', null, createElement( 'strong', null, 'Número de Yape: ' ), settings.phone ) : null,
			settings.qrUrl ? createElement( 'p', null, createElement( 'img', { src: settings.qrUrl, alt: 'Código QR para pagar con Yape', style: { maxWidth: '220px', height: 'auto' } } ) ) : null,
			settings.instructions ? createElement( 'p', null, settings.instructions ) : null,
			createElement( 'label', { htmlFor: 'yape-directo-operation-code' }, 'Código de operación de Yape' ),
			createElement( 'input', {
				id: 'yape-directo-operation-code',
				type: 'text',
				value: operationCode,
				required: true,
				autoComplete: 'off',
				onChange: ( event ) => setOperationCode( event.target.value ),
				placeholder: 'Ingresa el código que aparece en Yape',
				style: { display: 'block', width: '100%', marginTop: '8px' },
			} ),
			createElement( 'label', { htmlFor: 'yape-directo-receipt', style: { display: 'block', marginTop: '16px' } }, 'Foto o captura del pago (JPG, PNG o WebP; máximo 2 MB)' ),
			createElement( 'input', {
				id: 'yape-directo-receipt',
				type: 'file',
				accept: 'image/jpeg,image/png,image/webp',
				required: true,
				onChange: ( event ) => setReceipt( event.target.files && event.target.files[0] ? event.target.files[0] : null ),
				style: { display: 'block', width: '100%', marginTop: '8px' },
			} )
		);
	};

	registerPaymentMethod( {
		name: 'yape_directo',
		label: createElement( Label, {} ),
		content: createElement( Content, {} ),
		edit: createElement( Content, {} ),
		canMakePayment: () => true,
		ariaLabel: settings.title || 'Yape',
		supports: { features: settings.supports || [ 'products' ] },
	} );
} )();
