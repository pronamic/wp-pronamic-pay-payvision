<?php
/**
 * Issuer ID iDEAL
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Issuer ID iDEAL
 *
 * @link    https://developers.acehubpaymentservices.com/v3.3/reference#issuer-id-ideal
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class IssuerIdIDeal {
	/**
	 * ABN Amro.
	 *
	 * @var string
	 */
	const ABN_AMRO = '10';

	/**
	 * Rabobank.
	 *
	 * @var string
	 */
	const RABOBANK = '20';

	/**
	 * ING.
	 *
	 * @var string
	 */
	const ING = '30';

	/**
	 * SNS.
	 *
	 * @var string
	 */
	const SNS = '40';

	/**
	 * ASN.
	 *
	 * @var string
	 */
	const ASN = '50';

	/**
	 * RegioBank.
	 *
	 * @var string
	 */
	const REGIOBANK = '60';

	/**
	 * Triodos.
	 *
	 * @var string
	 */
	const TRIODOS = '70';

	/**
	 * Knab.
	 *
	 * @var string
	 */
	const KNAB = '80';

	/**
	 * Van Lanschot Bankiers.
	 *
	 * @var string
	 */
	const VAN_LANSCHOT_BANKIERS = '100';

	/**
	 * Bunq.
	 *
	 * @var string
	 */
	const BUNQ = '110';

	/**
	 * Handelsbanken.
	 *
	 * @var string
	 */
	const HANDELSBANKEN = '130';

	/**
	 * Revolut.
	 *
	 * @var string
	 */
	const REVOLUT = '140';
}
