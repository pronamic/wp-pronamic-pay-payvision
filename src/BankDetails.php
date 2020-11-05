<?php
/**
 * Bank Details
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Bank Details
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class BankDetails implements \JsonSerializable {
	/**
	 * Issuer ID.
	 *
	 * @var string
	 */
	public $issuer_id;

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
