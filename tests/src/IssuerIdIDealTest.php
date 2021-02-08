<?php
/**
 * Issuer ID iDEAL Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Issuer ID iDEAL Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class IssuerIdIDealTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$this->assertEquals( '10', IssuerIdIDeal::ABN_AMRO );
	}
}
