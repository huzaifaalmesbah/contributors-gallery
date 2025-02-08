<?php
namespace WPCG\Services;

/**
 * Latest WordPress Version Fetcher Class
 *
 * Handles fetching and caching of the latest WordPress version from WordPress.org API.
 *
 * @since 1.0.2
 */
class WPVersionFetcher {

	/**
	 * Transient key for caching the latest version
	 *
	 * @var string
	 */
	private $version_cache_key = 'wpcg_latest_wp_version';

	/**
	 * Cache duration in seconds (24 hours)
	 *
	 * @var int
	 */
	private $cache_duration = DAY_IN_SECONDS;

	/**
	 * Get the latest WordPress version
	 *
	 * @since 1.0.2
	 * @return string Latest WordPress version number
	 */
	public function get_latest_version() {
		$cached_version = get_transient( $this->version_cache_key );

		if ( false !== $cached_version ) {
			return $cached_version;
		}

		$version = $this->fetch_version_from_api();

		if ( $version ) {
			set_transient( $this->version_cache_key, $version, $this->cache_duration );
		}

		if ( $version ) {
			return $version;
		}
		return get_bloginfo( 'version' );
	}

	/**
	 * Fetch version from WordPress.org API
	 *
	 * @since 1.0.2
	 * @return string|false Version number or false on failure
	 */
	private function fetch_version_from_api() {
		$api_response = wp_remote_get( 'https://api.wordpress.org/core/version-check/1.7/' );

		if ( is_wp_error( $api_response ) ) {
			return false;
		}

		$api_body     = wp_remote_retrieve_body( $api_response );
		$version_data = json_decode( $api_body, true );

		return isset( $version_data['offers'][0]['version'] )
			? $version_data['offers'][0]['version']
			: false;
	}
}
