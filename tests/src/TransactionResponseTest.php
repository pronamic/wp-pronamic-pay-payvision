<?php
/**
 * Transaction Response Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction Response Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class TransactionResponseTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$transaction_response = new TransactionResponse(
			'payment',
			'3d40de42-d70f-49e9-8219-a999247945be',
			'0948143a-3f04-4627-94a7-e807fc1949fb',
			1,
			'EUR'
		);

		$this->assertInstanceOf( TransactionResponse::class, $transaction_response );
	}
}
