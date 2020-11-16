<?php
/**
 * Error Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Error Test
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ErrorTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test() {
		$error = new Error(
			1004,
			'Property not found in request: body.card.number.',
			'Property not found in request: body.card.number.'
		);

		$this->assertInstanceOf( Error::class, $error );
		$this->assertEquals( 1004, $error->getCode() );
		$this->assertEquals( 1004, $error->get_code() );
		$this->assertEquals( 'Property not found in request: body.card.number.', $error->getMessage() );
		$this->assertEquals( 'Property not found in request: body.card.number.', $error->get_message() );
	}

	/**
	 * Test from JSON.
	 */
	public function test_from_json() {
		$json = \file_get_contents( __DIR__ . '/../json/error.json', true );

		$data = \json_decode( $json );

		$error = Error::from_json( $data );

		$this->assertEquals( 1004, $error->getCode() );
		$this->assertEquals( 'Property not found in request: body.card.number.', $error->getMessage() );
	}
}
