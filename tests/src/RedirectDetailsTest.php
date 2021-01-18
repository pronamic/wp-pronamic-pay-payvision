<?php
/**
 * Redirect Details Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Redirect Details Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class RedirectDetailsTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$redirect_details = new RedirectDetails();

		$this->assertInstanceOf( RedirectDetails::class, $redirect_details );
	}
}
