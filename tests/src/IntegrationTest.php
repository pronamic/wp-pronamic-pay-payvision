<?php
/**
 * Integration test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Integration test
 *
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class IntegrationTest extends \WP_UnitTestCase {
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

		$this->assertCount( 5, $fields );
	}

	/**
	 * Test config / gateway.
	 */
	public function test_config_post() {
		$post_id = $this->factory->post->create();

		\update_post_meta( $post_id, '_pronamic_gateway_mode', Gateway::MODE_TEST );
		\update_post_meta( $post_id, '_pronamic_gateway_payvision_business_id', '123456' );
		\update_post_meta( $post_id, '_pronamic_gateway_payvision_username', 'Test' );
		\update_post_meta( $post_id, '_pronamic_gateway_payvision_password', '●●●●●●●●' );
		\update_post_meta( $post_id, '_pronamic_gateway_payvision_store_id', '1' );

		$config = $this->integration->get_config( $post_id );

		$this->assertInstanceOf( Config::class, $config );
		$this->assertEquals( '123456', $config->get_business_id() );
		$this->assertEquals( '1', $config->get_store_id() );
		$this->assertEquals(
			'{"mode":"test","business_id":"123456","username":"Test","password":"\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf\u25cf","store_id":"1"}',
			\wp_json_encode( $config )
		);

		$gateway = $this->integration->get_gateway( $post_id );

		$this->assertInstanceOf( Gateway::class, $gateway );
	}
}
