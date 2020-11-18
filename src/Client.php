<?php
/**
 * Payvision client
 *
 * @author Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license GPL-3.0-or-later
 * @package Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payvision client
 *
 * @link https://github.com/payvisionpayments/php/blob/master/generatepaymentform.php
 * @author Remco Tolsma
 * @version 1.0.5
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

		$response = \wp_remote_request(
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

		if ( $response instanceof \WP_Error ) {
			throw new \Exception( $response->get_error_message() );
		}

		// Body.
		$body = \wp_remote_retrieve_body( $response );

		// Response.
		$response_code = \wp_remote_retrieve_response_code( $response );

		$response_message = \wp_remote_retrieve_response_message( $response );

		/**
		 * On PHP 7 or higher the `json_decode` function will return `null` and
		 * `json_last_error` will return `4` (Syntax error). On PHP 5.6 or lower
		 * the `json_decode` will also return `null`, but json_last_error` will
		 * return `0` (No error). Therefore we check if the HTTP response body
		 * is an empty string.
		 *
		 * @link https://3v4l.org/
		 */
		if ( '' === $body ) {
			throw new \Exception(
				\sprintf(
					'Payvision response is empty, HTTP response: "%s %s".',
					$response_code,
					$response_message
				)
			);
		}

		// JSON.
		$data = \json_decode( $body );

		// JSON error.
		$json_error = \json_last_error();

		if ( \JSON_ERROR_NONE !== $json_error ) {
			throw new \Exception(
				\sprintf(
					'Could not JSON decode Payvision response, HTTP response: "%s %s", HTTP body length: "%d", JSON error: "%s".',
					$response_code,
					$response_message,
					\strlen( $body ),
					\json_last_error_msg()
				),
				$json_error
			);
		}

		// Object.
		if ( ! \is_object( $data ) ) {
			throw new \Exception(
				\sprintf(
					'Could not JSON decode Payvision response to an object, HTTP response: "%s %s", HTTP body: "%s".',
					$response_code,
					$response_message,
					$body
				),
				\intval( $response_code )
			);
		}

		return $data;
	}
}
