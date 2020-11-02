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

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Config
 *
 * @author  Remco Tolsma
 * @version 1.1.1
 * @since   1.0.0
 */
class Config extends GatewayConfig {
	/**
	 * Business Id.
	 *
	 * @var string
	 */
	public $business_id;

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
	public $store_id;

	/**
	 * Construct config object.
	 *
	 * @param string $business_id Business Id.
	 * @param string $username    Username.
	 * @param string $password    Password.
	 * @param string $store_id    Store ID.
	 */
	public function __construct( $business_id, $username, $password, $store_id ) {
		$this->business_id = $business_id;
		$this->username    = $username;
		$this->password    = $password;
		$this->store_id    = $store_id;
	}
}
