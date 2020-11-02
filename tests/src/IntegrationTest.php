<?php
/**
 * Integration test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use WP_UnitTestCase;

/**
 * Integration test
 *
 * @author  Remco Tolsma
 * @version 1.1.2
 * @since   1.0.0
 */
class IntegrationTest extends WP_UnitTestCase {
	/**
	 * Integration.
	 *
	 * @var Integration
	 */
	private $integration;

	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();

		$this->integration = new Integration();
	}

	/**
	 * Test settings fields.
	 */
	public function test_settings_fields() {
		$fields = $this->integration->get_settings_fields();

		$this->assertCount( 3, $fields );
	}
}
