<?php
/**
 * Payment Response Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Response Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class PaymentResponseTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$response_header = new ResponseHeader( '2020-11-10T18:31:20Z' );

		$payment_response = new PaymentResponse( 2, 'Pending', $response_header );

		$this->assertInstanceOf( ResponseHeader::class, $response_header );
		$this->assertInstanceOf( PaymentResponse::class, $payment_response );
		$this->assertEquals( ResultCode::PENDING, $payment_response->get_result() );
	}

	/**
	 * Test from JSON.
	 */
	public function test_from_json() {
		$json = \file_get_contents( __DIR__ . '/../json/payment-response.json', true );

		$data = \json_decode( $json );

		$payment_response = PaymentResponse::from_json( $data );

		$this->assertEquals( ResultCode::PENDING, $payment_response->get_result() );
	}
}
