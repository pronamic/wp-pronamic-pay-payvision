<?php
/**
 * Response Header
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Response Header
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ResponseHeader {
	/**
	 * The combined date and time in UTC (ISO8601).
	 *
	 * @var string
	 */
	private $request_timestamp;

	/**
	 * An internally-generated tracking code.
	 *
	 * @var string|null
	 */
	public $request_code;

	/**
	 * Construct and initialize request header.
	 *
	 * @param string $timestamp Request timestamp.
	 */
	public function __construct( $timestamp ) {
		$this->request_timestamp = $timestamp;
	}

	/**
	 * From JSON.
	 *
	 * @param object $object
	 * @return self
	 */
	public static function from_json( $object ) {
		$header = new self( $object->requestTimestamp );

		if ( \property_exists( $object, 'requestCode' ) ) {
			$header->request_code = $object->requestCode;	
		}

		return $header;
	}
}
