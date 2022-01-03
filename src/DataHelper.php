<?php
/**
 * Data helper
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\Payvision
 */

namespace Pronamic\WordPress\Pay\Gateways\Payvision;

/**
 * Data helper
 *
 * @link    https://github.com/wp-pay-gateways/ideal-basic/blob/2.0.0/src/DataHelper.php
 * @author  Reüel van der Steege
 * @version 1.1.0
 * @since   1.1.0
 */
class DataHelper {
	/**
	 * Sanitize string to the specified length.
	 *
	 * @param string $string String.
	 * @param int    $length Length.
	 * @return string
	 */
	public static function sanitize_an( $string, $length ) {
		/**
		 * Remove HTML tags.
		 *
		 * @link https://stackoverflow.com/questions/5732758/detect-html-tags-in-a-string
		 */

		// phpcs:ignore WordPress.WP.AlternativeFunctions.strip_tags_strip_tags -- We don't want the `trim` in `wp_strip_all_tags`.
		$sanitized = \strip_tags( $string );

		$sanitized = \mb_substr( $sanitized, 0, $length );

		return $sanitized;
	}
}
