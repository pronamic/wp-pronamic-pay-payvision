<?php
/**
 * Payvision client
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Payvision client
 *
 * @link https://github.com/payvisionpayments/php/blob/master/generatepaymentform.php
 *
 * @author  Remco Tolsma
 * @version 1.0.5
 * @since   1.0.0
 */
class Client {
	/**
	 * Config.
	 *
	 * @var Config
	 */
	private $config;

	/**
	 * Test API URL.
	 *
	 * @link https://developers.acehubpaymentservices.com/docs/service-endpoints-and-headers
	 */
	const API_URL_TEST = 'https://stagconnect.acehubpaymentservices.com/gateway/v3/';

	/**
	 * Live API URL.
	 *
	 * @link https://developers.acehubpaymentservices.com/docs/service-endpoints-and-headers
	 */
	const API_URL_LIVE = 'https://connect.acehubpaymentservices.com/gateway/v3/';

	/**
	 * Constructs and initializes an Payvision client object.
	 *
	 * @param Config $config Payvision config.
	 */
	public function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Get API URL.
	 *
	 * @param string $path Path.
	 * @return string
	 */
	public function get_api_url( $path ) {
		// Remove leading slashes from path.
		$path = \ltrim( $path, '/' );

		if ( Gateway::MODE_TEST === $this->config->mode ) {
			return self::API_URL_TEST . $path;
		}

		return self::API_URL_LIVE . $path;
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
		$response = \wp_remote_request(
			$this->get_api_url( $path ),
			array(
				'method'  => $method,
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( $this->config->username . ':' . $this->config->password ),
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
		$response_code    = \wp_remote_retrieve_response_code( $response );
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
		$data = json_decode( $body );

		// JSON error.
		$json_error = json_last_error();

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

		// Error.
		if ( \property_exists( $data, 'body' ) ) {
			if ( isset( $data->body->error ) ) {
				$error = Error::from_json( $data->body->error );

				throw $error;
			}
		}

		return $data;
	}
}
