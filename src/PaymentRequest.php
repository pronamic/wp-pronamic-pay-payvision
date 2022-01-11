<?php
/**
 * Payment Request
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payment Request
 *
 * @author  Remco Tolsma
 * @version 1.1.0
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
	 * @var BankDetails|null
	 */
	private $bank;

	/**
	 * Construct and initialize payment request
	 *
	 * @param RequestHeader $header      Header.
	 * @param Transaction   $transaction Transaction.
	 */
	public function __construct( RequestHeader $header, Transaction $transaction ) {
		$this->header      = $header;
		$this->transaction = $transaction;
	}

	/**
	 * Set bank.
	 *
	 * @param BankDetails|null $bank Bank.
	 * @return void
	 */
	public function set_bank( BankDetails $bank = null ) {
		$this->bank = $bank;
	}

	/**
	 * JSON serialize.
	 *
	 * @return object
	 */
	public function jsonSerialize() {
		return (object) array(
			'action' => 'payment',
			'header' => $this->header,
			'body'   => (object) array(
				'transaction' => $this->transaction,
				'bank'        => $this->bank,
			),
		);
	}
}
