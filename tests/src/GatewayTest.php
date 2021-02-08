<?php
/**
 * Gateway Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Money\TaxedMoney;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Payments\Payment;
use Pronamic\WordPress\Pay\Payments\PaymentStatus;

/**
 * Gateway Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class GatewayTest extends \WP_UnitTestCase {
	/**
	 * Mock HTTP responses.
	 *
	 * @var array<string, string>
	 */
	private $mock_http_responses;

	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();

		// Mock HTTP responses.
		$this->mock_http_responses = array();

		\add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );
	}

	/**
	 * Mock HTTP response.
	 *
	 * @param string $url  URL.
	 * @param string $file File with HTTP response.
	 */
	public function mock_http_response( $url, $file ) {
		$this->mock_http_responses[ $url ] = $file;
	}

	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 * @param bool                 $preempt Whether to preempt an HTTP request's return value. Default false.
	 * @param array<string, mixed> $r       HTTP request arguments.
	 * @param string               $url     The request URL.
	 * @return array<string, mixed>
	 */
	public function pre_http_request( $preempt, $r, $url ) {
		if ( ! isset( $this->mock_http_responses[ $url ] ) ) {
			return $preempt;
		}

		$file = $this->mock_http_responses[ $url ];

		unset( $this->mock_http_responses[ $url ] );

		$response = \file_get_contents( $file, true );

		$processed_response = \WP_Http::processResponse( $response );

		$processed_headers = \WP_Http::processHeaders( $processed_response['headers'], $url );

		$processed_headers['body'] = $processed_response['body'];

		// The `arguments` key is not an officiale WordPress core key, added for SlevomatCodingStandard compliance.
		$processed_headers['arguments'] = $r;

		return $processed_headers;
	}

	/**
	 * Test gateway.
	 */
	public function test_gateway() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->assertTrue( $gateway->payment_method_is_required() );

		// iDEAL issuers.
		$issuers = $gateway->get_issuers();

		$this->assertCount( 1, $issuers );

		// Payment methods.
		$methods = $gateway->get_supported_payment_methods();

		$this->assertCount( 1, $methods );
		$this->assertContains( PaymentMethods::IDEAL, $methods );
	}

	/**
	 * Test get payment status.
	 */
	public function test_get_payment_status() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->mock_http_response(
			'https://stagconnect.acehubpaymentservices.com/gateway/v3/payments/00a502ba-d289-4ee1-a43e-3c4e1de76b4d',
			__DIR__ . '/../http/get-payment-result-0.http'
		);

		$payment = new Payment();

		$payment->set_transaction_id( '00a502ba-d289-4ee1-a43e-3c4e1de76b4d' );

		$gateway->update_status( $payment );

		$this->assertEquals( PaymentStatus::SUCCESS, $payment->get_status() );
	}

	/**
	 * Test get payment status.
	 */
	public function test_get_payment_status_fake() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->mock_http_response(
			'https://stagconnect.acehubpaymentservices.com/gateway/v3/payments/00a502ba-d289-4ee1-a43e-3c4e1de76b4e',
			__DIR__ . '/../http/get-payment-by-fake-id.http'
		);

		$payment = new Payment();

		$payment->set_transaction_id( '00a502ba-d289-4ee1-a43e-3c4e1de76b4e' );

		$this->expectException( \Throwable::class );
		$this->expectExceptionMessage(
			'Could not JSON decode Payvision response, HTTP response: "404 Not Found", HTTP body length: "2", JSON error: "Syntax error".'
		);

		$gateway->update_status( $payment );
	}

	/**
	 * Test get payment empty body.
	 */
	public function test_get_payment_empty_body() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->mock_http_response(
			'https://stagconnect.acehubpaymentservices.com/gateway/v3/payments/00a502ba-d289-4ee1-a43e-3c4e1de76b4e',
			__DIR__ . '/../http/get-payment-body-empty.http'
		);

		$payment = new Payment();

		$payment->set_transaction_id( '00a502ba-d289-4ee1-a43e-3c4e1de76b4e' );

		$this->expectException( \Throwable::class );
		$this->expectExceptionMessage( 'Payvision response is empty, HTTP response: "200 OK".' );

		$gateway->update_status( $payment );
	}

	/**
	 * Test get payment no object.
	 */
	public function test_get_payment_no_object() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->mock_http_response(
			'https://stagconnect.acehubpaymentservices.com/gateway/v3/payments/00a502ba-d289-4ee1-a43e-3c4e1de76b4e',
			__DIR__ . '/../http/get-payment-no-object.http'
		);

		$payment = new Payment();

		$payment->set_transaction_id( '00a502ba-d289-4ee1-a43e-3c4e1de76b4e' );

		$this->expectException( \Throwable::class );
		$this->expectExceptionMessage(
			'Could not JSON decode Payvision response to an object, HTTP response: "200 OK", HTTP body: "[]".'
		);

		$gateway->update_status( $payment );
	}

	/**
	 * Test WordPress error.
	 */
	public function test_wp_error() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$filter = function() {
			return new \WP_Error( 'http_request_failed', 'A valid URL was not provided.' );
		};

		\add_filter( 'pre_http_request', $filter );

		$payment = new Payment();

		$payment->set_transaction_id( '00a502ba-d289-4ee1-a43e-3c4e1de76b4e' );

		$this->expectException( \Throwable::class );
		$this->expectExceptionMessage( 'A valid URL was not provided.' );

		$gateway->update_status( $payment );

		\remove_filter( 'pre_http_request', $filter );
	}

	/**
	 * Test post payment.
	 */
	public function test_post_payment() {
		$config = new Config( Gateway::MODE_TEST, '123456', 'Test', '●●●●●●●●', '1' );

		$gateway = new Gateway( $config );

		$this->mock_http_response(
			'https://stagconnect.acehubpaymentservices.com/gateway/v3/payments',
			__DIR__ . '/../http/post-payment.http'
		);

		$payment = new Payment();

		$payment->set_id( 1 );

		$payment->set_total_amount( new TaxedMoney( 50, 'EUR' ) );

		$gateway->start( $payment );

		$this->assertEquals(
			'https://test.acaptureservices.com/connectors/demo/ideal/simulator/paymentSimulation.ftl;jsessionid=5D94958C082AE32D58841306599361A5.uat01-vm-con02',
			$payment->get_action_url()
		);

		$this->assertEquals( '0c5b2580-45b9-440b-bef4-1ca016854afd', $payment->get_transaction_id() );
	}
}
