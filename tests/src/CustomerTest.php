<?php
/**
 * Customer Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Customer Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class CustomerTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$customer = new Customer();

		$customer->family_name = 'Doe';
		$customer->email       = 'john.doe@example.com';

		$this->assertInstanceOf( Customer::class, $customer );
		$this->assertEquals( 'Doe', $customer->family_name );
		$this->assertEquals( 'john.doe@example.com', $customer->email );
	}
}
