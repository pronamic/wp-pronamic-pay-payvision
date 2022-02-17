<?php
/**
 * Config
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Config
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class Config extends GatewayConfig implements \JsonSerializable {
	/**
	 * System URL.
	 *
	 * @var string
	 */
	private $system_url;

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
	private $username;

	/**
	 * Password.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * Store ID.
	 *
	 * @var string
	 */
	private $store_id;

	/**
	 * Purchase ID.
	 *
	 * @var string|null
	 */
	private $purchase_id;

	/**
	 * Construct config object.
	 *
	 * @param string $system_url  System URL.
	 * @param string $business_id Business Id.
	 * @param string $username    Username.
	 * @param string $password    Password.
	 * @param string $store_id    Store ID.
	 */
	public function __construct( $system_url, $business_id, $username, $password, $store_id ) {
		$this->system_url  = $system_url;
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
	 * Get username.
	 *
	 * @return string
	 */
	public function get_username() {
		return $this->username;
	}

	/**
	 * Get password.
	 *
	 * @return string
	 */
	public function get_password() {
		return $this->password;
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
	 * Get endpoint URL.
	 *
	 * @link https://developers.acehubpaymentservices.com/docs/service-endpoints-and-headers
	 * @param string $path Path.
	 * @return string
	 */
	public function get_endpoint_url( $path ) {
		return $this->system_url . $path;
	}

	/**
	 * Get purchase ID.
	 *
	 * @return string|null
	 */
	public function get_purchase_id() {
		return $this->purchase_id;
	}

	/**
	 * Set purchase ID.
	 *
	 * @param string|null $purchase_id Purchase ID.
	 * @return void
	 */
	public function set_purchase_id( $purchase_id ) {
		$this->purchase_id = $purchase_id;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		$data = array(
			'business_id' => $this->business_id,
			'username'    => $this->username,
			'password'    => $this->password,
			'store_id'    => $this->store_id,
		);

		if ( null !== $this->purchase_id ) {
			$data['purchase_id'] = $this->purchase_id;
		}

		return (object) $data;
	}
}
