<?php
/**
 * Response Header Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Response Header Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ResponseHeaderTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$response_header = new ResponseHeader( '2020-11-16T12:42:56Z' );

		$this->assertEquals( '2020-11-16T12:42:56Z', $response_header->get_request_timestamp() );
	}
}
