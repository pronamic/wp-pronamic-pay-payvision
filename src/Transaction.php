<?php
/**
 * Transaction
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction
 *
 * @author  Remco Tolsma
 * @version 1.1.0
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
	 * @var TrackingCode
	 */
	private $tracking_code;

	/**
	 * Brand ID.
	 *
	 * Identifies the transaction payment brand. Mandatory for all transactions, except for card transactions when your configuration allows the presence of the card block to be enough. See brand list.
	 *
	 * @var string|null
	 */
	private $brand_id;

	/**
	 * Purchase ID.
	 *
	 * @var string|null
	 */
	private $purchase_id;

	/**
	 * Return URL.
	 *
	 * @var string|null
	 */
	private $return_url;

	/**
	 * Descriptor.
	 *
	 * @var string|null
	 */
	private $descriptor;

	/**
	 * Construct and initialize request header.
	 *
	 * @param string       $store_id      Store ID.
	 * @param string       $amount        Amount.
	 * @param string       $currency_code Currency code.
	 * @param TrackingCode $tracking_code Tracking code.
	 */
	public function __construct( $store_id, $amount, $currency_code, $tracking_code ) {
		$this->store_id      = $store_id;
		$this->amount        = $amount;
		$this->currency_code = $currency_code;
		$this->tracking_code = $tracking_code;
	}

	/**
	 * Get brand ID.
	 *
	 * @return string|null
	 */
	public function get_brand_id() {
		return $this->brand_id;
	}

	/**
	 * Set brand ID.
	 *
	 * @param string|null $brand_id Brand ID.
	 * @return void
	 */
	public function set_brand_id( $brand_id ) {
		$this->brand_id = $brand_id;
	}

	/**
	 * Set purchase ID.
	 *
	 * @param string|null $purchase_id Purchase ID.
	 * @return void
	 */
	public function set_purchase_id( $purchase_id ) {
		$this->purchase_id = $purchase_id;
	}

	/**
	 * Set return URL.
	 *
	 * @param string|null $return_url Return URL.
	 * @return void
	 */
	public function set_return_url( $return_url ) {
		$this->return_url = $return_url;
	}

	/**
	 * Get descriptor.
	 *
	 * @return string|null
	 */
	public function get_descriptor() {
		return $this->descriptor;
	}

	/**
	 * Set descriptor.
	 *
	 * @param string|null $descriptor Descriptor.
	 * @return void
	 */
	public function set_descriptor( $descriptor ) {
		$this->descriptor = $descriptor;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		$data = array(
			'storeId'      => $this->store_id,
			'amount'       => $this->amount,
			'currencyCode' => $this->currency_code,
			'trackingCode' => $this->tracking_code,
		);

		if ( null !== $this->brand_id ) {
			$data['brandId'] = $this->brand_id;
		}

		if ( null !== $this->purchase_id ) {
			$data['purchaseId'] = $this->purchase_id;
		}

		if ( null !== $this->return_url ) {
			$data['returnUrl'] = $this->return_url;
		}

		if ( null !== $this->descriptor ) {
			$data['descriptor'] = $this->descriptor;
		}

		return (object) $data;
	}
}
