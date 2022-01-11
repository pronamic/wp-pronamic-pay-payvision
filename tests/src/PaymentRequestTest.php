<?php
/**
 * Payment Request Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Request Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
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

		$bank = new BankDetails();
		$bank->set_issuer_id( IssuerIdIDeal::ABN_AMRO );

		$payment_request->set_bank( $bank );

		$this->assertInstanceOf( PaymentRequest::class, $payment_request );

		// JSON.
		$json_file = __DIR__ . '/../json/payment-request.json';

		$json_string = \wp_json_encode( $payment_request, \JSON_PRETTY_PRINT );

		$this->assertJsonStringEqualsJsonFile( $json_file, $json_string );
	}
}
