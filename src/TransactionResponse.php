<?php
/**
 * Transaction Response
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction Response
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class TransactionResponse {
	/**
	 * Action.
	 *
	 * Actual action performed. In case a separate capture is NOT possible, the transaction will be interpreted and performed as a payment transaction and cannot be cancelled, but can be refunded and with result=0 considered as a “successful payment".
	 *
	 * @var string
	 */
	private $action;

	/**
	 * Unique transaction ID given to each transaction.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Your unique transaction reference.
	 *
	 * @var string
	 */
	private $tracking_code;

	/**
	 * Amount of the transaction.
	 *
	 * @var string
	 */
	private $amount;

	/**
	 * Currency code of the amount of the transaction.
	 *
	 * @var RedirectDetails|null
	 */
	private $currency_code;

	/**
	 * Construct and initialize transaction response.
	 *
	 * @param string $action Action.
	 * @param string $id     ID.
	 * @param string $tracking_code      Header.
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
	 * @param object $object
	 * @return self
	 */
	public static function from_json( $object ) {
		return new self( $object->action, $object->id, $object->trackingCode, $object->amount, $object->currencyCode );
	}
}
