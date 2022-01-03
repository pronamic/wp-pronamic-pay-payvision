<?php
/**
 * Transaction Response
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction Response
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class TransactionResponse {
	/**
	 * Unique transaction ID given to each transaction.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Action.
	 *
	 * Actual action performed. In case a separate capture is NOT possible, the transaction will be interpreted and performed as a payment transaction and cannot be cancelled, but can be refunded and with result=0 considered as a “successful payment".
	 *
	 * @var string
	 */
	private $action;

	/**
	 * Your unique transaction reference.
	 *
	 * @var string
	 */
	private $tracking_code;

	/**
	 * Amount of the transaction.
	 *
	 * @var string|float|int
	 */
	private $amount;

	/**
	 * Currency code of the amount of the transaction.
	 *
	 * @var string
	 */
	private $currency_code;

	/**
	 * Construct and initialize transaction response.
	 *
	 * @param string           $action        Action.
	 * @param string           $id            ID.
	 * @param string           $tracking_code Tracking code.
	 * @param string|float|int $amount        Amount.
	 * @param string           $currency_code Currency code.
	 */
	public function __construct( $action, $id, $tracking_code, $amount, $currency_code ) {
		$this->action        = $action;
		$this->id            = $id;
		$this->tracking_code = $tracking_code;
		$this->amount        = $amount;
		$this->currency_code = $currency_code;
	}

	/**
	 * From JSON.
	 *
	 * @link https://github.com/WordPress/wp-notify/blob/develop/includes/JsonUnserializable.php
	 * @param object $object Object.
	 * @return self
	 * @throws \JsonSchema\Exception\ValidationException Throws exception when JSON is not valid.
	 */
	public static function from_json( $object ) {
		$validator = new \JsonSchema\Validator();

		$validator->validate(
			$object,
			(object) array(
				'$ref' => 'file://' . \realpath( __DIR__ . '/../json-schemas/transaction-response.json' ),
			),
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

		/* phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase */
		return new self( $object->action, $object->id, $object->trackingCode, $object->amount, $object->currencyCode );
	}

	/**
	 * Get action.
	 *
	 * @return string
	 */
	public function get_action() {
		return $this->action;
	}

	/**
	 * Get id.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get tracking code.
	 *
	 * @return string
	 */
	public function get_tracking_code() {
		return $this->tracking_code;
	}

	/**
	 * Get amount.
	 *
	 * @return string|float|int
	 */
	public function get_amount() {
		return $this->amount;
	}

	/**
	 * Get currency code.
	 *
	 * @return string
	 */
	public function get_currency_code() {
		return $this->currency_code;
	}
}
