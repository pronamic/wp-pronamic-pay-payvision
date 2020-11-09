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
use Pronamic\WordPress\Pay\Payments\PaymentStatus;
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
	 * Get issuers
	 *
	 * @see Core_Gateway::get_issuers()
	 * @return array<int, array<string, array<string>>>
	 */
	public function get_issuers() {
		return array(
			array(
				'options' => array(
					IssuerIdIDeal::ABN_AMRO              => __( 'ABN Amro', 'pronamic_ideal' ),
					IssuerIdIDeal::RABOBANK              => __( 'Rabobank', 'pronamic_ideal' ),
					IssuerIdIDeal::ING                   => __( 'ING', 'pronamic_ideal' ),
					IssuerIdIDeal::SNS                   => __( 'SNS', 'pronamic_ideal' ),
					IssuerIdIDeal::ASN                   => __( 'ASN', 'pronamic_ideal' ),
					IssuerIdIDeal::REGIOBANK             => __( 'RegioBank', 'pronamic_ideal' ),
					IssuerIdIDeal::TRIODOS               => __( 'Triodos', 'pronamic_ideal' ),
					IssuerIdIDeal::KNAB                  => __( 'Knab', 'pronamic_ideal' ),
					IssuerIdIDeal::VAN_LANSCHOT_BANKIERS => __( 'Van Lanschot Bankiers', 'pronamic_ideal' ),
					IssuerIdIDeal::BUNQ                  => __( 'Bunq', 'pronamic_ideal' ),
					IssuerIdIDeal::MONEYOU               => __( 'Moneyou', 'pronamic_ideal' ),
					IssuerIdIDeal::HANDELSBANKEN         => __( 'Handelsbanken', 'pronamic_ideal' ),
				),
			),
		);
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
			PaymentMethods::IDEAL,
			PaymentMethods::PAYPAL,
			PaymentMethods::AFTERPAY,
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
		$header = new RequestHeader( $this->config->business_id );

		$tracking_code = \sprintf(
			'%08s',
			$payment->get_id()
		);

		$transaction = new Transaction(
			$this->config->store_id,
			$payment->get_total_amount()->get_value(),
			$payment->get_total_amount()->get_currency()->get_alphabetic_code(),
			$tracking_code
		);

		$transaction->purchase_id = $payment->get_id();
		$transaction->return_url  = $payment->get_return_url();

		$transaction->brand_id = BrandId::from_core( $payment->get_method() );

		$customer = $payment->get_customer();

		if ( null !== $customer ) {
			$locale = $customer->get_locale();

			if ( \is_string( $locale ) ) {
				$transaction->language_code = \substr( $locale, 0, 2 );
			}
		}

		$payment_request = new PaymentRequest( $header, $transaction );

		$bank = new BankDetails();

		if ( BrandId::IDEAL === $transaction->brand_id ) {
			// https://developers.acehubpaymentservices.com/v3.3/reference#issuer-id-ideal
			$bank->issuer_id = $payment->get_issuer();
		}

		$payment_request->bank = $bank;

		$payment->set_meta( 'payvision_business_id', $this->config->business_id );
		$payment->set_meta( 'payvision_tracking_code', $tracking_code );

		$object = $this->client->send_request( 'POST', 'payments', wp_json_encode( $payment_request ) );

		$payment_response = PaymentResponse::from_json( $object );
var_dump( $object );
var_dump( $payment_response );
exit;
		if ( null !== $payment_response->redirect ) {
			$payment->set_action_url( $payment_response->redirect->url );
		}

		if ( null !== $payment_response->transaction ) {
			$payment->set_transaction_id( $payment_response->transaction->id );
		}
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
		$id = $payment->get_transaction_id();

		$business_id = $payment->get_meta( 'payvision_business_id' );

		$object = $this->client->send_request( 'GET', 'payments/' . $id, array( 'businessId' => $business_id ) );

		$response = PaymentResponse::from_json( $object );

		switch ( $response->get_result() ) {
			case ResultCode::OK:
				$payment->set_status( PaymentStatus::SUCCESS );

				break;
		}
	}
}
