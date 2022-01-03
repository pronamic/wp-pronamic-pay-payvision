<?php
/**
 * Redirect Details
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Redirect Details
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class RedirectDetails {
	/**
	 * POST or GET (depends on brand used). The default value is POST.
	 *
	 * @var string|null
	 */
	public $method;

	/**
	 * URL including the query string to which your customer is redirected (depends on brand used).
	 *
	 * @var string|null
	 */
	public $url;

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
				'$ref' => 'file://' . \realpath( __DIR__ . '/../json-schemas/redirect.json' ),
			),
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

		$redirect = new self();

		if ( \property_exists( $object, 'method' ) ) {
			$redirect->method = $object->method;
		}

		if ( \property_exists( $object, 'url' ) ) {
			$redirect->url = $object->url;
		}

		return $redirect;
	}
}
