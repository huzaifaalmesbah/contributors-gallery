<?php
namespace WPCG\Views;

use WPCG\Services\WPVersionFetcher;

/**
 * Contributors Data Formatter Class
 *
 * Handles data preparation and formatting for the Contributors Gallery plugin.
 *
 * @since 1.0.2
 */
class ContributorsDataFormatter {

	/**
	 * Latest Version Fetcher instance
	 *
	 * @var WPVersionFetcher
	 */
	private $wp_version_fetcher;

	/**
	 * Constructor
	 *
	 * @since 1.0.2
	 */
	public function __construct() {
		$this->wp_version_fetcher = new WPVersionFetcher();
	}

	/**
	 * Prepare data for templates
	 *
	 * @since 1.0.2
	 * @param array   $data             Raw API data.
	 * @param boolean $version_switcher Whether to show version switcher.
	 * @return array Prepared data for templates
	 */
	public function prepare_template_data( $data, $version_switcher = true ) {
		return array(
			'version'                 => $data['data']['version'] ?? '',
			'noteworthy_contributors' => $this->get_noteworthy_contributors( $data ),
			'core_contributors'       => $this->get_core_contributors( $data ),
			'version_switcher'        => $version_switcher,
			'versions'                => $this->wp_version_fetcher->get_available_versions(),
		);
	}

	/**
	 * Get noteworthy contributors
	 *
	 * @since 1.0.2
	 * @param array $data API response data.
	 * @return array
	 */
	private function get_noteworthy_contributors( $data ) {
		$noteworthy_groups           = array( 'core-developers', 'contributing-developers' );
		$all_noteworthy_contributors = array();

		foreach ( $noteworthy_groups as $group ) {
			if ( isset( $data['groups'][ $group ]['data'] ) ) {
				$all_noteworthy_contributors = array_merge(
					$all_noteworthy_contributors,
					$data['groups'][ $group ]['data']
				);
			}
		}

		return $all_noteworthy_contributors;
	}

	/**
	 * Get core contributors
	 *
	 * @param array $data API response data.
	 * @return array
	 */
	private function get_core_contributors( $data ) {
		return isset( $data['groups']['props']['data'] )
			? $data['groups']['props']['data']
			: array();
	}
}
