<?php
/**
 * Payment Response
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Response
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class PaymentResponse {
	/**
	 * The result of the payment.
	 *
	 * @link https://developers.acehubpaymentservices.com/v3.3/reference#result-codes-2
	 * @var int
	 */
	private $result;

	/**
	 * A short description of the result..
	 *
	 * @var string
	 */
	private $description;

	/**
	 * Header.
	 *
	 * @var ResponseHeader
	 */
	private $header;

	/**
	 * Transaction.
	 *
	 * @var TransactionResponse|null
	 */
	public $transaction;

	/**
	 * Redirect.
	 *
	 * @var RedirectDetails|null
	 */
	public $redirect;

	/**
	 * Construct and initialize payment response
	 *
	 * @param int            $result      Result.
	 * @param string         $description Description.
	 * @param ResponseHeader $header      Header.
	 */
	public function __construct( $result, $description, $header ) {
		$this->result      = $result;
		$this->description = $description;
		$this->header      = $header;
	}

	/**
	 * Get result.
	 *
	 * @return int
	 */
	public function get_result() {
		return $this->result;
	}

	/**
	 * From JSON.
	 *
	 * @param object $object
	 * @return self
	 */
	public static function from_json( $object ) {
		$response = new self( $object->result, $object->description, ResponseHeader::from_json( $object->header ) );

		if ( property_exists( $object->body, 'redirect' ) ) {
			$response->redirect = RedirectDetails::from_json( $object->body->redirect );
		}

		if ( property_exists( $object->body, 'transaction' ) ) {
			$response->transaction = TransactionResponse::from_json( $object->body->transaction );
		}

		return $response;
	}
}
