<?php
/**
 * Web SDK gateway
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2019 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Exception;
use InvalidArgumentException;
use Locale;
use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Payments\Payment;
use Pronamic\WordPress\Pay\Plugin;
use WP_Error;

/**
 * Gateway
 *
 * @link https://github.com/payvisionpayments/php/blob/master/generatepaymentform.php
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Constructs and initializes an Payvision gateway.
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		// Supported features.
		$this->supports = array();

		// Client.
		$this->client = new Client( $config );
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Core_Gateway::get_supported_payment_methods()
	 *
	 * @return array<string>
	 */
	public function get_supported_payment_methods() {
		return array(
			PaymentMethods::BANCONTACT,
			PaymentMethods::CREDIT_CARD,
			PaymentMethods::DIRECT_DEBIT,
			PaymentMethods::GIROPAY,
			PaymentMethods::IDEAL,
			PaymentMethods::MAESTRO,
			PaymentMethods::SOFORT,
		);
	}

	/**
	 * Start.
	 *
	 * @see Plugin::start()
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function start( Payment $payment ) {
		$payment_request = new PaymentRequest();

		$tracking_code = \sprintf(
			'%08s',
			$payment->get_id()
		);

		$payment->set_meta( 'payvision_tracking_code', $tracking_code );

		$payment_request->business_id   = $this->config->business_id;
		$payment_request->store_id      = $this->config->store_id;
		$payment_request->amount        = $payment->get_total_amount()->get_value();
		$payment_request->currency_code = $payment->get_total_amount()->get_currency()->get_alphabetic_code();
		$payment_request->tracking_code = $tracking_code;
		$payment_request->purchase_id   = $payment->get_id();
		$payment_request->return_url    = $payment->get_return_url();

		// iDEAL.
		$payment_request->brand_id      = '3010';
		// https://developers.acehubpaymentservices.com/v3.3/reference#issuer-id-ideal
		$payment_request->issuer_id     = '10';

var_dump( json_encode( $payment_request ) );

		$payment_response = $this->client->send_request( '', $payment_request );

		var_dump( $payment_response );
	}

	/**
	 * Payment redirect.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function payment_redirect( Payment $payment ) {
		
	}

	/**
	 * Update status of the specified payment.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function update_status( Payment $payment ) {
		
	}
}
