<?php
namespace WPCG\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Service class for fetching and parsing WordPress.org profile data
 */
class ProfileService {
	/**
	 * Fetch and parse user profile data from WordPress.org
	 *
	 * @param string $username WordPress.org username.
	 * @return array|false Profile data array or false on failure.
	 */
	public function get_profile_data( $username ) {
		$profile_url = "https://profiles.wordpress.org/" . $username;
		$response = wp_remote_get( $profile_url );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$doc = new \DOMDocument();
		@$doc->loadHTML( $body );
		$xpath = new \DOMXPath( $doc );

		// Get avatar hash from meta og:image
		$avatar_hash = '';
		$meta_image = $xpath->query( "//meta[@property='og:image']/@content" );
		if ( $meta_image->length > 0 ) {
			$meta_src = $meta_image->item( 0 )->nodeValue;
			if ( preg_match( '/avatar\/([a-f0-9]+)\?/', $meta_src, $matches ) ) {
				$avatar_hash = $matches[1];
			}
		}

		// Get user metadata
		$meta_items = [];
		$meta_elements = $xpath->query( "//ul[@id='user-meta']/li[not(@id='user-social-media-accounts-tag')]" );
		foreach ( $meta_elements as $meta_element ) {
			$label = $xpath->query( ".//span", $meta_element );
			$value = $xpath->query( ".//strong", $meta_element );
			if ( $label->length > 0 && $value->length > 0 ) {
				$meta_items[] = [
					'label' => trim( $label->item( 0 )->textContent ),
					'value' => trim( $value->item( 0 )->textContent ),
				];
			}
		}

		return [
			'avatar_hash' => $avatar_hash,
			'meta_items' => $meta_items,
		];
	}
}