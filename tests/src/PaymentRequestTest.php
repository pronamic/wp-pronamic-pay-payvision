<?php
/**
 * Payment Request Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Request Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class PaymentRequestTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$header = new RequestHeader( '123456' );

		$transaction = new Transaction( '1', 50, 'EUR', '12345678' );

		$payment_request = new PaymentRequest( $header, $transaction );

		$this->assertInstanceOf( PaymentRequest::class, $payment_request );
	}
}
