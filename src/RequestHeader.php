<?php
/**
 * Request Header
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Request Header
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class RequestHeader implements \JsonSerializable {
	/**
	 * Business ID.
	 *
	 * @var string
	 */
	private $business_id;

	/**
	 * Construct and initialize request header.
	 *
	 * @param string $business_id Business ID.
	 */
	public function __construct( $business_id ) {
		$this->business_id = $business_id;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'businessId' => $this->business_id,
		);
	}
}
