<?php
/**
 * Transaction
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Customer implements \JsonSerializable {
	/**
	 * Family name.
	 *
	 * Last name of the customer.
	 *
	 * @var string|null
	 */
	public $family_name;

	/**
	 * Email.
	 *
	 * Email address of the customer.
	 *
	 * @var string|null
	 */
	public $email;

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'familyName' => $this->family_name,
			'email'      => $this->email,
		);
	}
}
