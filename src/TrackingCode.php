<?php
/**
 * Tracking Code
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Tracking Code
 *
 * @link    https://developers.acehubpaymentservices.com/v3.3/reference#payment-3-1
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class TrackingCode implements \JsonSerializable {
	/**
	 * Code.
	 *
	 * Your Unique Transaction Reference. Minimum length: 8 characters.
	 *
	 * @var string
	 */
	private $code;

	/**
	 * Construct and initialize tracking code.
	 *
	 * @param string $code Code.
	 * @return void
	 * @throws \InvalidArgumentException Throws exception if length of code is less than 8 characters.
	 */
	public function __construct( $code ) {
		if ( \strlen( $code ) < 8 ) {
			throw new \InvalidArgumentException( 'Minimum length: 8 characters.' );
		}

		$this->code = $code;
	}

	/**
	 * From ID.
	 *
	 * @param string|int $id ID.
	 * @return self
	 */
	public static function from_id( $id ) {
		return new self( \sprintf( '%08s', $id ) );
	}

	/**
	 * JSON serialize.
	 *
	 * @return string
	 */
	public function jsonSerialize() {
		return $this->code;
	}

	/**
	 * To string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->code;
	}
}
