<?php
/**
 * Brand ID
 *
 * @author Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license GPL-3.0-or-later
 * @package Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\PaymentMethods;

/**
 * Brand ID
 *
 * @link https://developers.acehubpaymentservices.com/v3.3/reference#brands
 * @author Remco Tolsma
 * @version 1.1.0
 * @since 1.0.0
 */
class BrandId {
	/**
	 * VISA.
	 *
	 * @var string
	 */
	const VISA = '1010';

	/**
	 * American Express.
	 *
	 * @var string
	 */
	const AMERICAN_EXPRESS = '1030';

	/**
	 * Maestro.
	 *
	 * @var string
	 */
	const MAESTRO = '1050';

	/**
	 * Bancontact (BCMC = Bancontact / Mister Cash).
	 *
	 * @var string
	 */
	const BCMC = '1210';

	/**
	 * IDeal.
	 *
	 * @var string
	 */
	const IDEAL = '3010';

	/**
	 * PayPal.
	 *
	 * @var string
	 */
	const PAYPAL = '4010';

	/**
	 * AfterPay.
	 *
	 * Note: this is for AfterPay (afterpay.nl) and not for Afterpay (afterpay.com)
	 *
	 * @var string
	 */
	const AFTERPAY = '5020';

	/**
	 * From core.
	 *
	 * @param string|null $method Method.
	 * @return string|null
	 */
	public static function from_core( $method ) {
		switch ( $method ) {
			case PaymentMethods::AFTERPAY_NL:
				return self::AFTERPAY;

			case PaymentMethods::BANCONTACT:
				return self::BCMC;

			case PaymentMethods::IDEAL:
				return self::IDEAL;

			case PaymentMethods::PAYPAL:
				return self::PAYPAL;

			case PaymentMethods::MAESTRO:
				return self::MAESTRO;

			default:
				return null;
		}
	}
}
