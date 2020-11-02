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
	public function jsonSerialize() {
		return (object) array(
			'action' => 'payment',
			'header' => (object) array(
				'businessId' => $this->business_id,
			),
			'body'   => (object) array(
				'transaction' => (object) array(
					'storeId'      => $this->store_id,
					'amount'       => $this->amount,
					'currencyCode' => $this->currency_code,
					'trackingCode' => $this->tracking_code,
					'brandId'      => $this->brand_id,
					'purchaseId'   => $this->purchase_id,
					'returnUrl'    => $this->return_url,
				),
				'bank'         => (object) array(
					'issuerId' => $this->issuer_id,
				),
			),
		);
	}
}
