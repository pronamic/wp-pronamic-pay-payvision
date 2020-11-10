<?php
/**
 * Payment Request
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Request
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class PaymentRequest implements \JsonSerializable {
	/**
	 * Header.
	 *
	 * @var RequestHeader
	 */
	private $header;

	/**
	 * Transaction.
	 *
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * Bank.
	 *
	 * @var BankDetails
	 */
	public $bank;

	/**
	 * Customer.
	 *
	 * Customer specific data. Needed for some alternative payment methods and fraud checks.
	 *
	 * @var Customer
	 */
	public $customer;

	/**
	 * Construct and initialize payment request
	 *
	 * @param RequestHeader $header      Header.
	 * @param Transaction   $transaction Transaction.
	 */
	public function __construct( $header, $transaction ) {
		$this->header      = $header;
		$this->transaction = $transaction;
	}

	public function jsonSerialize() {
		return (object) array(
			'action' => 'payment',
			'header' => $this->header,
			'body'   => (object) array(
				'transaction' => $this->transaction,
				'bank'        => $this->bank,
				'customer'    => $this->customer,
			),
		);
	}
}
