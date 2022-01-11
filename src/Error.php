<?php
/**
 * Error
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Error
 *
 * @link    https://developers.acehubpaymentservices.com/v3.3/reference#payment-3-1
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class Error extends \Exception {
	/**
	 * Detailed message.
	 *
	 * A more detailed error message when available. If not available, contains the same as error.message.
	 *
	 * @var string
	 */
	private $detailed_message;

	/**
	 * Construct and initialize payment response
	 *
	 * @param int    $code             Code.
	 * @param string $message          Message.
	 * @param string $detailed_message Detailed message.
	 * @return void
	 */
	public function __construct( $code, $message, $detailed_message ) {
		parent::__construct( $message, $code );

		$this->detailed_message = $detailed_message;
	}

	/**
	 * From JSON.
	 *
	 * @param object $object Object.
	 * @return self
	 * @throws \JsonSchema\Exception\ValidationException Throws exception when JSON is not valid.
	 */
	public static function from_json( $object ) {
		$validator = new \JsonSchema\Validator();

		$validator->validate(
			$object,
			(object) array(
				'$ref' => 'file://' . \realpath( __DIR__ . '/../json-schemas/error.json' ),
			),
			\JsonSchema\Constraints\Constraint::CHECK_MODE_EXCEPTIONS
		);

        /* phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase */
		return new self( $object->code, $object->message, $object->detailedMessage );
	}

	/**
	 * Get code.
	 *
	 * @return int|string
	 */
	public function get_code() {
		return $this->getCode();
	}

	/**
	 * Get message.
	 *
	 * @return string
	 */
	public function get_message() {
		return $this->getMessage();
	}

	/**
	 * Get detailed message.
	 *
	 * @return string
	 */
	public function get_detailed_message() {
		return $this->detailed_message;
	}
}
