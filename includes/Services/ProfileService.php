<?php
namespace WPCG\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Service class for fetching and parsing WordPress.org profile data
 *
 * @since 1.2.0
 */
class ProfileService {

	/**
	 * Fetch and parse user profile data from WordPress.org
	 *
	 * This method retrieves and processes profile information including:
	 * - Avatar hash from meta og:image
	 * - User metadata from profile page
	 *
	 * @since 1.2.0
	 *
	 * @param string $username WordPress.org username.
	 * @return array|false Profile data array or false on failure. Array contains:
	 *                    - avatar_hash (string) The hash for the user's Gravatar
	 *                    - meta_items (array) Array of profile metadata with labels and values
	 */
	public function get_profile_data( $username ) {
		if ( empty( $username ) || ! is_string( $username ) ) {
			return false;
		}

		$profile_url = 'https://profiles.wordpress.org/' . sanitize_user( $username );
		$response    = wp_remote_get(
			$profile_url,
			array(
				'timeout'   => 15,
				'sslverify' => true,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( empty( $body ) ) {
			return false;
		}

		try {
			$doc = new \DOMDocument();
			// Use proper error handling with libxml
			$previous = libxml_use_internal_errors( true );
			$doc->loadHTML( $body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
			libxml_clear_errors();
			libxml_use_internal_errors( $previous );

			$xpath = new \DOMXPath( $doc );

			// Get avatar hash from meta og:image
			$avatar_hash = $this->extract_avatar_hash( $xpath );

			// Get user metadata
			$meta_items = $this->extract_meta_items( $xpath );

			return array(
				'avatar_hash' => $avatar_hash,
				'meta_items'  => $meta_items,
			);

		} catch ( \Exception $e ) {
			// Use WordPress error logging
			do_action( 'wpcg_profile_error', $e->getMessage() );
			return false;
		}
	}

	/**
	 * Extract avatar hash from meta og:image
	 *
	 * @param \DOMXPath $xpath The XPath object for querying the DOM.
	 * @return string The extracted avatar hash or empty string if not found
	 */
	private function extract_avatar_hash( \DOMXPath $xpath ): string {
		$avatar_hash = '';
		$meta_image  = $xpath->query( "//meta[@property='og:image']/@content" );

		if ( $meta_image->length > 0 ) {
			$meta_src = $meta_image->item( 0 )->nodeValue;
			if ( preg_match( '/avatar\/([a-f0-9]+)\?/', $meta_src, $matches ) ) {
				$avatar_hash = $matches[1];
			}
		}

		return $avatar_hash;
	}

	/**
	 * Extract meta items from profile page
	 *
	 * @param \DOMXPath $xpath The XPath object for querying the DOM.
	 * @return array Array of meta items with label and value pairs
	 */
	private function extract_meta_items( \DOMXPath $xpath ): array {
		$meta_items    = array();
		$meta_elements = $xpath->query( "//ul[@id='user-meta']/li[not(@id='user-social-media-accounts-tag')]" );

		if ( false === $meta_elements ) {
			return $meta_items;
		}

		foreach ( $meta_elements as $meta_element ) {
			$label = $xpath->query( './/span', $meta_element );
			$value = $xpath->query( './/strong', $meta_element );

			if ( $label->length > 0 && $value->length > 0 ) {
				$meta_items[] = array(
					'label' => trim( $label->item( 0 )->textContent ),
					'value' => trim( $value->item( 0 )->textContent ),
				);
			}
		}

		return $meta_items;
	}
}
