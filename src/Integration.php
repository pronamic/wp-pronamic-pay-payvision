<?php
/**
 * Integration
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Dependencies\PhpExtensionDependency;
use Pronamic\WordPress\Pay\AbstractGatewayIntegration;
use Pronamic\WordPress\Pay\Util as Pay_Util;

/**
 * Integration
 *
 * @author  Remco Tolsma
 * @version 1.1.2
 * @since   1.0.0
 */
class Integration extends AbstractGatewayIntegration {
	/**
	 * REST route namespace.
	 *
	 * @var string
	 */
	const REST_ROUTE_NAMESPACE = 'pronamic-pay/payvision/v1';

	/**
	 * Construct Payvision integration.
	 *
	 * @param array<string, array<string>> $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'id'            => 'payvision',
				'name'          => 'Payvision',
				'provider'      => 'payvision',
				'url'           => \__( 'https://www.payvision.com/', 'pronamic_ideal' ),
				'product_url'   => \__( 'https://www.payvision.com/', 'pronamic_ideal' ),
				'dashboard_url' => array(
					\__( 'test', 'pronamic_ideal' ) => 'https://tools.payvisionservices.com/acecontrol/dashboard',
					\__( 'live', 'pronamic_ideal' ) => 'https://tools.payvisionservices.com/acecontrol/dashboard',
				),
				'manual_url'    => \__( 'https://www.pronamic.eu/manuals/using-payvision-pronamic-pay/', 'pronamic_ideal' ),
				'supports'      => array(),
			)
		);

		parent::__construct( $args );

		// Dependencies.
		$dependencies = $this->get_dependencies();

		$dependencies->add( new PhpExtensionDependency( 'intl' ) );
	}

	/**
	 * Setup gateway integration.
	 *
	 * @return void
	 */
	public function setup() {
		// Check if dependencies are met and integration is active.
		if ( ! $this->is_active() ) {
			return;
		}
	}

	/**
	 * Input text.
	 *
	 * @param array<string,string> $args Arguments.
	 * @return void
	 */
	public static function input_element( $args ) {
		$name = $args['label_for'];

		$value = get_option( $name );
		$value = strval( $value );

		printf(
			'<input name="%s" id="%s" value="%s" type="text" class="regular-text" />',
			esc_attr( $name ),
			esc_attr( $name ),
			esc_attr( $value )
		);
	}

	/**
	 * Get settings fields.
	 *
	 * @return array<int, array<string, callable|int|string|bool|array<int|string,int|string>>>
	 */
	public function get_settings_fields() {
		$fields = array();

		// Business Id.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_business_id',
			'title'    => _x( 'Business Id', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
			'tooltip'  => __( 'A Merchant connecting to the platform is identified by its Business ID (“businessId”).', 'pronamic_ideal' ),
		);

		// User.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_username',
			'title'    => _x( 'User', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Password.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_password',
			'title'    => _x( 'Password', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Store Id.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_store_id',
			'title'    => _x( 'Store ID', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Return fields.
		return $fields;
	}

	/**
	 * Get configuration by post ID.
	 *
	 * @param int $post_id Post ID.
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$business_id = $this->get_meta( $post_id, 'payvision_business_id' );
		$username    = $this->get_meta( $post_id, 'payvision_username' );
		$password    = $this->get_meta( $post_id, 'payvision_password' );
		$store_id    = $this->get_meta( $post_id, 'payvision_store_id' );

		$config = new Config( $business_id, $username, $password, $store_id );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return AbstractGateway
	 */
	public function get_gateway( $post_id ) {
		$config = $this->get_config( $post_id );

		return new Gateway( $config );
	}
}
