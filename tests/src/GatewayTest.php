<?php
/**
 * Gateway Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Gateway Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class GatewayTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->assertInstanceOf( Config::class, $config );
		$this->assertInstanceOf( Gateway::class, $gateway );
	}
}
