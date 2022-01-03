<?php
/**
 * Result Code
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Payments\PaymentStatus;

/**
 * Result Code
 *
 * @link    https://developers.acehubpaymentservices.com/reference#result-codes-2
 * @author  Remco Tolsma
 * @version 1.1.0
 * @since   1.0.0
 */
class ResultCode {
	/**
	 * Customer processing error.
	 *
	 * Error or cancellation of customer at supplier. For example, the customer
	 * abandoned their transaction at the supplier.
	 *
	 * @var int
	 */
	const CUSTOMER_ERROR = -10;

	/**
	 * Declined.
	 *
	 * Declines, etc. In these cases the processing was performed correctly,
	 * but the end-result for the customer is not.
	 *
	 * @var int
	 */
	const DECLINED = -4;

	/**
	 * Failed.
	 *
	 * The transaction failed because of a processing error at Payvision.
	 *
	 * @var int
	 */
	const FAILED = -2;

	/**
	 * Ok.
	 *
	 * The transaction was processed successfully.
	 *
	 * @var int
	 */
	const OK = 0;

	/**
	 * Waiting.
	 *
	 * The transaction was initiated successfully, but a payment was not yet made by the
	 * customer or not yet confirmed by the bank. Occurs for brands for which customers
	 * have to make a payment separately (like Boletos) or where the bank does not
	 * immediately confirm a payment (like SEPA).
	 *
	 * @var int
	 */
	const WAITING = 1;

	/**
	 * Pending.
	 *
	 * Pending transaction, the payment was initiated and waiting for the customer to
	 * complete the payment at the bank or payment processor.
	 *
	 * @var int
	 */
	const PENDING = 2;

	/**
	 * Timeout.
	 *
	 * The payment timeout expired before the customer completed the payment.
	 *
	 * @var int
	 */
	const TIMEOUT = 4;

	/**
	 * Transform Payvision result code to WordPress payment status.
	 *
	 * @param int|null $result_code Payvision result code.
	 * @return string|null WordPress payment status.
	 */
	public static function to_core( $result_code ) {
		switch ( $result_code ) {
			case self::CUSTOMER_ERROR:
				return PaymentStatus::CANCELLED;
			case self::DECLINED:
			case self::FAILED:
				return PaymentStatus::FAILURE;
			case self::TIMEOUT:
				return PaymentStatus::EXPIRED;
			case self::PENDING:
			case self::WAITING:
				return PaymentStatus::OPEN;
			case self::OK:
				return PaymentStatus::SUCCESS;
		}

		return null;
	}
}
