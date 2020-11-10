<?php
/**
 * Request Header Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Request Header Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class RequestHeaderTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$request_header = new RequestHeader( '123456' );

		$this->assertInstanceOf( RequestHeader::class, $request_header );
	}
}
