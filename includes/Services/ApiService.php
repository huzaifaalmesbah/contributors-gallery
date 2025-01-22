<?php
namespace WPCG\Services;

/**
 * API Service Class
 */
class ApiService {

	/**
	 * Get contributors data
	 *
	 * @param string $version WordPress version.
	 * @return array|false
	 */
	public function get_contributors_data( $version = '' ) {
		if ( empty( $version ) ) {
			$version = get_bloginfo( 'version' );
		}

		$transient_key = 'wpcg_contributors_' . $version;
		$cached_data   = get_transient( $transient_key );

		if ( false !== $cached_data ) {
			return $cached_data;
		}

		$response = wp_remote_get(
			sprintf(
				'https://api.wordpress.org/core/credits/1.1/?version=%s&locale=en',
				$version
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( ! empty( $data ) ) {
			set_transient( $transient_key, $data, DAY_IN_SECONDS );
		}

		return $data;
	}
}
