<?php
/**
 * Result Code Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Result Code Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ResultCodeTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$this->assertEquals( 0, ResultCode::OK );
	}
}
