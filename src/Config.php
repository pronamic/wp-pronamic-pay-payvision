<?php
/**
 * Config
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Config
 *
 * @author  Remco Tolsma
 * @version 1.1.1
 * @since   1.0.0
 */
class Config extends GatewayConfig implements \JsonSerializable {
	/**
	 * Business Id.
	 *
	 * @var string
	 */
	private $business_id;

	/**
	 * User.
	 *
	 * @var string
	 */
	public $username;

	/**
	 * Password.
	 *
	 * @var string
	 */
	public $password;

	/**
	 * Store ID.
	 *
	 * @var string
	 */
	private $store_id;

	/**
	 * Construct config object.
	 *
	 * @param string $mode        Mode.
	 * @param string $business_id Business Id.
	 * @param string $username    Username.
	 * @param string $password    Password.
	 * @param string $store_id    Store ID.
	 */
	public function __construct( $mode, $business_id, $username, $password, $store_id ) {
		$this->mode        = $mode;
		$this->business_id = $business_id;
		$this->username    = $username;
		$this->password    = $password;
		$this->store_id    = $store_id;
	}

	/**
	 * Get business ID.
	 *
	 * @return string
	 */
	public function get_business_id() {
		return $this->business_id;
	}

	/**
	 * Get store ID.
	 *
	 * @return string
	 */
	public function get_store_id() {
		return $this->store_id;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'mode'        => $this->mode,
			'business_id' => $this->business_id,
			'username'    => $this->username,
			'password'    => $this->password,
			'store_id'    => $this->store_id,
		);
	}
}
