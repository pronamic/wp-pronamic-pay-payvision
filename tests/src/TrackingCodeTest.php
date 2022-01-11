<?php
/**
 * Tracking Code Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Tracking Code Test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class TrackingCodeTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$tracking_code = TrackingCode::from_id( 1 );

		$this->assertEquals( '00000001', \strval( $tracking_code ) );
		$this->assertEquals( '"00000001"', \wp_json_encode( $tracking_code ) );

		$tracking_code = TrackingCode::from_id( 1234567890 );

		$this->assertEquals( '1234567890', \strval( $tracking_code ) );
		$this->assertEquals( '"1234567890"', \wp_json_encode( $tracking_code ) );
	}

	/**
	 * Test.
	 */
	public function test_exception() {
		$this->expectException( \InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Minimum length: 8 characters.' );

		new TrackingCode( '1' );
	}
}
