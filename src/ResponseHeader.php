<?php
/**
 * Response Header
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Response Header
 *
 * @author  Remco Tolsma
 * @version 1.1.0
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
	 * @throws \JsonSchema\Exception\ValidationException Throws exception when JSON is not valid.
	 */
	public static function from_json( $object ) {
		$validator = new \JsonSchema\Validator();

		$validator->validate(
			$object,
			(object) array(
				'$ref' => 'file://' . \realpath( __DIR__ . '/../json-schemas/response-header.json' ),
			),
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

        /* phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase */
		return new self( $object->requestTimestamp );
	}

	/**
	 * Get request timestamp.
	 *
	 * @return string
	 */
	public function get_request_timestamp() {
		return $this->request_timestamp;
	}
}
