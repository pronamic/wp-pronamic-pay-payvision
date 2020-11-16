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
	 * @link https://github.com/WordPress/wp-notify/blob/develop/includes/JsonUnserializable.php
	 * @param object $object Object.
	 * @return self
	 * @throws \InvalidArgumentException Throws exception when required property is not set.
	 */
	public static function from_json( $object ) {
		if ( ! property_exists( $object, 'requestTimestamp' ) ) {
			throw new \InvalidArgumentException( 'Object must contain `requestTimestamp` property.' );
		}

		/* phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase */
		$header = new self( $object->requestTimestamp );

		return $header;
	}
}
