<?php
/**
 * System Address
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * System Address
 *
 * @link    https://developers.acehubpaymentservices.com/docs/service-endpoints-and-headers
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class SystemAddress {
	/**
	 * Staging system (used for merchant integration tests).
	 *
	 * @var string
	 */
	const STAGING_SYSTEM = 'https://stagconnect.acehubpaymentservices.com';

	/**
	 * Live system (used for live transaction processing).
	 *
	 * @var string
	 */
	const LIVE_SYSTEM = 'https://connect.acehubpaymentservices.com';
}
