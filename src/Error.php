<?php
/**
 * Error
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Error
 *
 * @link    https://developers.acehubpaymentservices.com/v3.3/reference#payment-3-1
 * @author  Remco Tolsma
 * @version 1.0.0
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
	 */
	public function __construct( $code, $message, $detailed_message ) {
		parent::__construct( $message, $code );

		$this->detailed_message = $detailed_message;
	}

	/**
	 * From JSON.
	 *
	 * @param object $object
	 * @return self
	 */
	public static function from_json( $object ) {
		return new self( $object->code, $object->message, $object->detailedMessage );
	}
}
