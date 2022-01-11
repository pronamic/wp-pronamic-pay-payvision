<?php
/**
 * Result Code Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Payments\PaymentStatus;

/**
 * Result Code Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class ResultCodeTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$this->assertEquals( 0, ResultCode::OK );
	}

	/**
	 * Test to core.
	 *
	 * @param string $result_code Result code.
	 * @param string $expected    Expected value.
	 * @dataProvider provider_test_to_core
	 */
	public function test_to_core( $result_code, $expected ) {
		$payment_status = ResultCode::to_core( $result_code );

		$this->assertEquals( $expected, $payment_status );
	}

	/**
	 * Result code data provider.
	 *
	 * @return array<int, string|null>
	 */
	public function provider_test_to_core() {
		return array(
			array( ResultCode::CUSTOMER_ERROR, PaymentStatus::CANCELLED ),
			array( ResultCode::DECLINED, PaymentStatus::FAILURE ),
			array( ResultCode::FAILED, PaymentStatus::FAILURE ),
			array( ResultCode::OK, PaymentStatus::SUCCESS ),
			array( ResultCode::WAITING, PaymentStatus::OPEN ),
			array( ResultCode::PENDING, PaymentStatus::OPEN ),
			array( ResultCode::TIMEOUT, PaymentStatus::EXPIRED ),
			array( -1000, null ),
		);
	}
}
