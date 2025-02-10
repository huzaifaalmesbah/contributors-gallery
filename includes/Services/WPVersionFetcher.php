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
	 * Cache key for available versions
	 *
	 * @var string
	 */
	private $versions_cache_key = 'wpcg_available_versions';

	/**
	 * Get all available WordPress versions
	 *
	 * @since 1.1.0
	 * @return array List of WordPress versions
	 */
	public function get_available_versions() {
		$cached_versions = get_transient( $this->versions_cache_key );

		if ( false !== $cached_versions ) {
			return $cached_versions;
		}

		$versions = $this->fetch_versions_from_api();

		if ( ! empty( $versions ) ) {
			set_transient( $this->versions_cache_key, $versions, $this->cache_duration );
		}

		return $versions;
	}

	/**
	 * Fetch available versions from WordPress.org API
	 *
	 * @since 1.1.0
	 * @return array List of WordPress versions
	 */
	private function fetch_versions_from_api() {
		$api_response = wp_remote_get( 'https://api.wordpress.org/core/stable-check/1.0/' );

		if ( is_wp_error( $api_response ) ) {
			return array();
		}

		$api_body = wp_remote_retrieve_body( $api_response );
		$data     = json_decode( $api_body, true );

		if ( empty( $data ) ) {
			return array();
		}

		$versions = array_keys( $data );
		
		// Filter to keep versions with one decimal point (x.y) and >= 3.2
		$filtered_versions = array_filter($versions, function($version) {
			if (!preg_match('/^\d+\.\d+$/', $version)) {
				return false;
			}
			return version_compare($version, '3.2', '>=');
		});

		rsort( $filtered_versions, SORT_NATURAL );

		return array_values( $filtered_versions );
	}

	/**
	 * Get the latest WordPress version
	 *
	 * @since 1.0.2
	 * @return string Latest WordPress version
	 */
	public function get_latest_version() {
		$cached_version = get_transient( $this->version_cache_key );

		if ( false !== $cached_version ) {
			return $cached_version;
		}

		$versions = $this->get_available_versions();

		if ( ! empty( $versions ) ) {
			$latest_version = $versions[0];
			set_transient( $this->version_cache_key, $latest_version, $this->cache_duration );
			return $latest_version;
		}

		return '';
	}
}
