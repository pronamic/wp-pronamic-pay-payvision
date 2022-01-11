<?php
/**
 * Brand ID Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\PaymentMethods;

/**
 * Brand ID Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class BrandIdTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$this->assertEquals( '1010', BrandId::VISA );
	}

	/**
	 * Test from core.
	 *
	 * @param string $method   Method.
	 * @param string $expected Expected value.
	 * @dataProvider provider_test_from_core
	 */
	public function test_from_core( $method, $expected ) {
		$brand_id = BrandId::from_core( $method );

		$this->assertEquals( $expected, $brand_id );
	}

	/**
	 * Status data provider.
	 *
	 * @return array<string, string|null>
	 */
	public function provider_test_from_core() {
		return array(
			array( PaymentMethods::AFTERPAY_NL, BrandId::AFTERPAY ),
			array( PaymentMethods::BANCONTACT, BrandId::BCMC ),
			array( PaymentMethods::IDEAL, BrandId::IDEAL ),
			array( PaymentMethods::PAYPAL, BrandId::PAYPAL ),
			array( PaymentMethods::MAESTRO, BrandId::MAESTRO ),
			array( 'unknown method', null ),
		);
	}
}
