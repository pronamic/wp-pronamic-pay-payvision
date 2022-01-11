<?php
/**
 * Bank Details
 *
 * @author Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license GPL-3.0-or-later
 * @package Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Bank Details
 *
 * @author Remco Tolsma
 * @version 1.1.0
 * @since 1.0.0
 */
class BankDetails implements \JsonSerializable {
	/**
	 * Issuer ID.
	 *
	 * @var string|null
	 */
	private $issuer_id;

	/**
	 * Get issuer ID.
	 *
	 * @return string|null
	 */
	public function get_issuer_id() {
		return $this->issuer_id;
	}

	/**
	 * Set issuer ID.
	 *
	 * @param string|null $issuer_id Issuer ID.
	 * @return void
	 */
	public function set_issuer_id( $issuer_id ) {
		$this->issuer_id = $issuer_id;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'issuerId' => $this->issuer_id,
		);
	}
}
