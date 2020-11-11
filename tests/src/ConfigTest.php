<?php
/**
 * Config Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Config Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ConfigTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$config = new Config( '123456', 'Test', '●●●●●●●●', '1' );

		$this->assertInstanceOf( Config::class, $config );
		$this->assertEquals( '123456', $config->get_business_id() );
		$this->assertEquals( '1', $config->get_store_id() );
		$this->assertEquals( '{"business_id":"123456","username":"Test","password":"\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf","store_id":"1"}', \wp_json_encode( $config ) );
	}
}
