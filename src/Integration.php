<?php
/**
 * Integration
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Integration
 *
 * @author  Remco Tolsma
 * @version 1.1.0
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
	 * System URL.
	 *
	 * @var string
	 */
	private $system_url;

	/**
	 * Construct Payvision integration.
	 *
	 * @param array<string, array<string>> $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$args = \wp_parse_args(
			$args,
			array(
				'id'            => 'payvision',
				'name'          => 'Payvision',
				'mode'          => 'live',
				'system_url'    => SystemAddress::LIVE_SYSTEM,
				'provider'      => 'payvision',
				'url'           => \__( 'https://www.payvision.com/', 'pronamic_ideal' ),
				'product_url'   => \__( 'https://www.payvision.com/', 'pronamic_ideal' ),
				'dashboard_url' => 'https://tools.payvisionservices.com/acecontrol/dashboard',
				'manual_url'    => \__(
					'https://www.pronamic.eu/manuals/using-payvision-pronamic-pay/',
					'pronamic_ideal'
				),
				'supports'      => array(),
			)
		);

		parent::__construct( $args );

		$this->system_url = $args['system_url'];
	}

	/**
	 * Setup.
	 */
	public function setup() {
		\add_filter(
			'pronamic_gateway_configuration_display_value_' . $this->get_id(),
			array( $this, 'gateway_configuration_display_value' ),
			10,
			2
		);
	}

	/**
	 * Gateway configuration display value.
	 *
	 * @param string $display_value Display value.
	 * @param int    $post_id       Gateway configuration post ID.
	 * @return string
	 */
	public function gateway_configuration_display_value( $display_value, $post_id ) {
		$config = $this->get_config( $post_id );

		return $config->get_business_id();
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
			'filter'   => \FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_business_id',
			'title'    => \_x( 'Business Id', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
			'tooltip'  => \__(
				'A Merchant connecting to the platform is identified by its Business ID (“businessId”).',
				'pronamic_ideal'
			),
		);

		// User.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => \FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_username',
			'title'    => \_x( 'User', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Password.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => \FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_password',
			'title'    => \_x( 'Password', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Store Id.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => \FILTER_SANITIZE_STRING,
			'meta_key' => '_pronamic_gateway_payvision_store_id',
			'title'    => \_x( 'Store ID', 'payvision', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
		);

		// Purchase ID.
		$code_field = \sprintf( '<code>%s</code>', 'purchaseId' );

		$fields[] = array(
			'section'     => 'advanced',
			'filter'      => \FILTER_SANITIZE_STRING,
			'meta_key'    => '_pronamic_gateway_payvision_purchase_id',
			'title'       => \__( 'Order ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'regular-text', 'code' ),
			'tooltip'     => \sprintf(
				/* translators: %s: <code>purchaseId</code> */
				\__( 'The Payvision parameter %s', 'pronamic_ideal' ),
				$code_field
			),
			'description' => \sprintf(
				'%s %s<br />%s',
				\__( 'Available tags:', 'pronamic_ideal' ),
				\sprintf(
					'<code>%s</code> <code>%s</code>',
					'{order_id}',
					'{payment_id}'
				),
				\sprintf(
					/* translators: %s: default code */
					\__( 'Default: <code>%s</code>', 'pronamic_ideal' ),
					'{payment_id}'
				)
			),
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
		$purchase_id = $this->get_meta( $post_id, 'payvision_purchase_id' );

		$config = new Config( $this->system_url, $business_id, $username, $password, $store_id );

		if ( '' !== $purchase_id ) {
			$config->set_purchase_id( $purchase_id );
		}

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		$config = $this->get_config( $post_id );

		$gateway = new Gateway( $config );

		$gateway->set_mode( $this->get_mode() );

		return $gateway;
	}
}
