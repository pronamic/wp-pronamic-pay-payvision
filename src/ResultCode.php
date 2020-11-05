<?php
/**
 * Result Code
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Result Code
 *
 * @link    https://developers.acehubpaymentservices.com/reference#result-codes-2
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ResultCode {
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
	 * The transaction was initiated successfully, but a payment was not yet made by the customer or not yet confirmed by the bank. Occurs for brands for which customers have to make a payment separately (like Boletos) or where the bank does not immediately confirm a payment (like SEPA).
	 *
	 * @var int
	 */
	const WAITING = 1;

	/**
	 * Pending.
	 *
	 * Pending transaction, the payment was initiated and waiting for the customer to complete the payment at the bank or payment processor.
	 *
	 * @var int
	 */
	const PENDING = 2;
}
