<?php
/**
 * Transaction Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class TransactionTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$transaction = new Transaction( '123456', 50, 'EUR', '12345678' );

		$transaction->set_brand_id( BrandId::IDEAL );
		$transaction->set_purchase_id( 123456 );
		$transaction->set_return_url( 'https://example.com/' );

		$this->assertInstanceOf( Transaction::class, $transaction );

		$this->assertEquals( BrandId::IDEAL, $transaction->get_brand_id() );

		// JSON.
		$json_file = __DIR__ . '/../json/transaction-request.json';

		$json_string = \wp_json_encode( $transaction, \JSON_PRETTY_PRINT );

		$this->assertJsonStringEqualsJsonFile( $json_file, $json_string );
	}
}
