<?php
/**
 * Gateway
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Gateway
 *
 * @link    https://github.com/payvisionpayments/php/blob/master/generatepaymentform.php
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Config
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Client.
	 *
	 * @var Client
	 */
	private $client;

	/**
	 * Constructs and initializes an Payvision gateway.
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->config = $config;

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		// Supported features.
		$this->supports = array(
			'payment_status_request',
		);

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
					IssuerIdIDeal::ABN_AMRO              => \__( 'ABN Amro', 'pronamic_ideal' ),
					IssuerIdIDeal::ING                   => \__( 'ING', 'pronamic_ideal' ),
					IssuerIdIDeal::RABOBANK              => \__( 'Rabobank', 'pronamic_ideal' ),
					IssuerIdIDeal::ASN                   => \__( 'ASN Bank', 'pronamic_ideal' ),
					IssuerIdIDeal::BUNQ                  => \__( 'Bunq', 'pronamic_ideal' ),
					IssuerIdIDeal::HANDELSBANKEN         => \__( 'Handelsbanken', 'pronamic_ideal' ),
					IssuerIdIDeal::KNAB                  => \__( 'Knab', 'pronamic_ideal' ),
					IssuerIdIDeal::REGIOBANK             => \__( 'RegioBank', 'pronamic_ideal' ),
					IssuerIdIDeal::REVOLUT               => \__( 'Revolut', 'pronamic_ideal' ),
					IssuerIdIDeal::SNS                   => \__( 'SNS Bank', 'pronamic_ideal' ),
					IssuerIdIDeal::TRIODOS               => \__( 'Triodos Bank', 'pronamic_ideal' ),
					IssuerIdIDeal::VAN_LANSCHOT_BANKIERS => \__( 'Van Lanschot', 'pronamic_ideal' ),
				),
			),
		);
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Core_Gateway::get_supported_payment_methods()
	 * @return array<string>
	 */
	public function get_supported_payment_methods() {
		return array(
			PaymentMethods::IDEAL,
			PaymentMethods::PAYPAL,
		);
	}

	/**
	 * Is payment method required to start transaction?
	 *
	 * @see Core_Gateway::payment_method_is_required()
	 * @return true
	 */
	public function payment_method_is_required() {
		return true;
	}

	/**
	 * Start.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 * @throws \InvalidArgumentException Throws exception if payment ID or currency is empty.
	 */
	public function start( Payment $payment ) {
		$header = new RequestHeader( $this->config->get_business_id() );

		$payment_id = $payment->get_id();

		if ( null === $payment_id ) {
			throw new \InvalidArgumentException( 'Can not start payment with empty ID.' );
		}

		$tracking_code = TrackingCode::from_id( $payment_id );

		$transaction = new Transaction(
			$this->config->get_store_id(),
			/**
			 * Amounts are to be formatted using a dot (“.”) as a decimal
			 * separator. The maximum number of decimals depends on the
			 * currency used and it is specified according to ISO 4217.
			 * It is not needed to specify all decimals, e.g. €5.00 can be
			 * formatted as “5”, “5.0” or “5.00".The maximum amount depends
			 * on the brand used.
			 *
			 * @link https://developers.acehubpaymentservices.com/docs/data-types
			 */
			$payment->get_total_amount()->get_number()->format( null, '.', '' ),
			$payment->get_total_amount()->get_currency()->get_alphabetic_code(),
			$tracking_code
		);

		$transaction->set_purchase_id( $payment->format_string( (string) $this->config->get_purchase_id() ) );
		$transaction->set_return_url( $payment->get_return_url() );
		$transaction->set_brand_id( BrandId::from_core( $payment->get_payment_method() ) );
		$transaction->set_descriptor( DataHelper::sanitize_an( (string) $payment->get_description(), 127 ) );

		$payment_request = new PaymentRequest( $header, $transaction );

		// iDEAL.
		if ( BrandId::IDEAL === $transaction->get_brand_id() ) {
			$bank = new BankDetails();

			$bank->set_issuer_id( $payment->get_meta( 'issuer' ) );

			$payment_request->set_bank( $bank );
		}

		$payment->set_meta( 'payvision_business_id', $this->config->get_business_id() );
		$payment->set_meta( 'payvision_tracking_code', \strval( $tracking_code ) );

		// Create payment.
		$object = $this->client->send_request( 'POST', '/gateway/v3/payments', \wp_json_encode( $payment_request ) );

		$payment_response = PaymentResponse::from_json( $object );

		$error = $payment_response->get_error();

		if ( null !== $error ) {
			throw $error;
		}

		if ( null !== $payment_response->redirect ) {
			if ( null !== $payment_response->redirect->url ) {
				$payment->set_action_url( $payment_response->redirect->url );
			}
		}

		if ( null !== $payment_response->transaction ) {
			$payment->set_transaction_id( $payment_response->transaction->id );
		}
	}

	/**
	 * Update status of the specified payment.
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function update_status( Payment $payment ) {
		$id = $payment->get_transaction_id();

		// Get payment.
		$object = $this->client->send_request(
			'GET',
			'/gateway/v3/payments/' . $id,
			array(
				'businessId' => $payment->get_meta( 'payvision_business_id' ),
			)
		);

		$response = PaymentResponse::from_json( $object );

		// Update payment status.
		$result_code = $response->get_result();

		$status = ResultCode::to_core( $result_code );

		if ( null !== $status ) {
			$payment->set_status( $status );
		}

		// Add error as note.
		$error = $response->get_error();

		if ( null !== $error ) {
			$payment->add_note( \sprintf( '%s: %s', $error->get_code(), $error->get_message() ) );
		}
	}
}
