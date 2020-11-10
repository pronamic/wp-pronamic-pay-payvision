<?php
/**
 * Transaction Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Transaction Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class TransactionTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$transaction = new Transaction( '123456', 50, 'EUR', '12345678' );

		$this->assertInstanceOf( Transaction::class, $transaction );
	}
}
