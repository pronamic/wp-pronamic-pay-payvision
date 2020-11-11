<?php
/**
 * Client Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Client Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$config = new Config( '123456', 'Test', '●●●●●●●●', '1' );

		$client = new Client( $config );

		$this->assertInstanceOf( Config::class, $config );
		$this->assertInstanceOf( Client::class, $client );
	}
}