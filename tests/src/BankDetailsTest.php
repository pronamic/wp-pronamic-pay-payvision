<?php
/**
 * Bank Details Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Bank Details Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class BankDetailsTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$bank_details = new BankDetails();

		$bank_details->issuer_id = IssuerIdIDeal::ABN_AMRO;

		$this->assertEquals( IssuerIdIDeal::ABN_AMRO, $bank_details->issuer_id );
	}
}
