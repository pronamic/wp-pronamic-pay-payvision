<?php
/**
 * Payvision client
 *
 * @author Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license GPL-3.0-or-later
 * @package Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

use Pronamic\WordPress\Http\Facades\Http;

/**
 * Payvision client
 *
 * @link https://github.com/payvisionpayments/php/blob/master/generatepaymentform.php
 * @author Remco Tolsma
 * @version 1.1.2
 * @since 1.0.0
 */
class Client {
	/**
	 * Config.
	 *
	 * @var Config
	 */
	private $config;

	/**
	 * Constructs and initializes an Payvision client object.
	 *
	 * @param Config $config Payvision config.
	 */
	public function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Send request with the specified action and parameters
	 *
	 * @param string                       $method  Payvision API method.
	 * @param string                       $path    Path.
	 * @param object|string[]|string|false $request Request object.
	 * @return object
	 * @throws \Exception Throws exception when error occurs.
	 */
	public function send_request( $method, $path, $request = null ) {
		// Request.
		$authorization = 'Basic ' . \base64_encode( $this->config->get_username() . ':' . $this->config->get_password() );

		$response = Http::request(
			$this->config->get_endpoint_url( $path ),
			array(
				'method'  => $method,
				'headers' => array(
					'Authorization' => $authorization,
					'Content-Type'  => 'application/json',
				),
				'body'    => $request,
			)
		);

		$data = $response->json();

		// Object.
		if ( ! \is_object( $data ) ) {
			$response_code = $response->status();

			throw new \Exception(
				\sprintf(
					'Could not JSON decode Payvision response to an object, HTTP response: "%s %s", HTTP body: "%s".',
					$response_code,
					$response->message(),
					$response->body()
				),
				\intval( $response_code )
			);
		}

		return $data;
	}
}
