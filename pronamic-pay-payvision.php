<?php
/**
 * Plugin Name: Pronamic Pay Payvision Add-On
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-pay-payvision/
 * Description: Extend the Pronamic Pay plugin with the Payvision gateway to receive payments with Payvision through a variety of WordPress plugins.
 *
 * Version: 3.1.0
 * Requires at least: 4.7
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: pronamic-pay-payvision
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 * Depends: wp-pay/core
 *
 * GitHub URI: https://github.com/wp-pay-gateways/payvision
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Adyen
 */

add_filter(
	'pronamic_pay_gateways',
	function( $gateways ) {
		$gateways[] = new \Pronamic\WordPress\Pay\Gateways\Payvision\Integration(
			array(
				'id'            => 'payvision',
				'name'          => 'Payvision',
				'mode'          => 'live',
				'system_url'    => \Pronamic\WordPress\Pay\Gateways\Payvision\SystemAddress::LIVE_SYSTEM,
			)
		);

		$gateways[] = new \Pronamic\WordPress\Pay\Gateways\Payvision\Integration(
			array(
				'id'            => 'payvision-staging',
				'name'          => 'Payvision - Staging',
				'mode'          => 'test',
				'system_url'    => \Pronamic\WordPress\Pay\Gateways\Payvision\SystemAddress::STAGING_SYSTEM,
			)
		);

		return $gateways;
	}
);
