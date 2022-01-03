<?php
/**
 * Payment Response
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Response
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class PaymentResponse {
	/**
	 * Redirect.
	 *
	 * @var RedirectDetails|null
	 */
	public $redirect;

	/**
	 * Transaction.
	 *
	 * @var TransactionResponse|null
	 */
	public $transaction;

	/**
	 * The result of the payment.
	 *
	 * @link https://developers.acehubpaymentservices.com/v3.3/reference#result-codes-2
	 * @var int
	 */
	private $result;

	/**
	 * A short description of the result.
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
	 * Error.
	 *
	 * @var Error|null
	 */
	private $error;

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
	 * From JSON.
	 *
	 * @param object $object Object.
	 * @return self
	 * @throws \JsonSchema\Exception\ValidationException Throws exception when JSON is not valid.
	 */
	public static function from_json( $object ) {
		$validator = new \JsonSchema\Validator();

		$validator->validate(
			$object,
			(object) array(
				'$ref' => 'file://' . \realpath( __DIR__ . '/../json-schemas/payment-response.json' ),
			),
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

		$response = new self( $object->result, $object->description, ResponseHeader::from_json( $object->header ) );

		if ( \property_exists( $object->body, 'transaction' ) ) {
			$response->transaction = TransactionResponse::from_json( $object->body->transaction );
		}

		if ( \property_exists( $object->body, 'redirect' ) ) {
			$response->redirect = RedirectDetails::from_json( $object->body->redirect );
		}

		if ( \property_exists( $object->body, 'error' ) ) {
			$response->set_error( Error::from_json( $object->body->error ) );
		}

		return $response;
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
	 * Get description.
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get header.
	 *
	 * @return ResponseHeader
	 */
	public function get_header() {
		return $this->header;
	}

	/**
	 * Get error.
	 *
	 * @return Error|null
	 */
	public function get_error() {
		return $this->error;
	}

	/**
	 * Set error.
	 *
	 * @param Error|null $error Error.
	 * @return void
	 */
	public function set_error( Error $error = null ) {
		$this->error = $error;
	}
}
