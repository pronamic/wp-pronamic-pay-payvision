<?php
/**
 * Transaction
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Transaction implements \JsonSerializable {
	/**
	 * Store ID.
	 *
	 * @var string
	 */
	private $store_id;

	/**
	 * Amount.
	 *
	 * @var string
	 */
	private $amount;

	/**
	 * Currency code.
	 *
	 * @var string
	 */
	private $currency_code;

	/**
	 * Tracking code.
	 *
	 * @var string
	 */
	private $tracking_code;

	/**
	 * Brand ID.
	 *
	 * Identifies the transaction payment brand. Mandatory for all transactions, except for card transactions when your configuration allows the presence of the card block to be enough. See brand list.
	 *
	 * @var string|null
	 */
	public $brand_id;

	/**
	 * Language code.
	 *
	 * Language code (ISO 639-1) for language to be used for customer UI for alternative payment brands. Only supported by some payment brands. Languages supported depends on the brand.
	 *
	 * @var string|null
	 */
	public $language_code;

	/**
	 * Purchase ID.
	 *
	 * @var string|null
	 */
	public $purchase_id;

	/**
	 * Return URL.
	 *
	 * @var string|null
	 */
	public $return_url;

	/**
	 * Construct and initialize request header.
	 *
	 * @param string $store_id      Store ID.
	 * @param string $amount        Amount.
	 * @param string $currency_code Currency code.
	 * @param string $tracking_code Tracking code.
	 */
	public function __construct( $store_id, $amount, $currency_code, $tracking_code ) {
		$this->store_id      = $store_id;
		$this->amount        = $amount;
		$this->currency_code = $currency_code;
		$this->tracking_code = $tracking_code;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'storeId'      => $this->store_id,
			'amount'       => $this->amount,
			'currencyCode' => $this->currency_code,
			'trackingCode' => $this->tracking_code,
			'brandId'      => $this->brand_id,
			'languageCode' => $this->language_code,
			'purchaseId'   => $this->purchase_id,
			'returnUrl'    => $this->return_url,
		);
	}
}
