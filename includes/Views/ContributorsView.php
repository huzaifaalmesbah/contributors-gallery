<?php
namespace WPCG\Views;

/**
 * Contributors View Class
 */
class ContributorsView {

	/**
	 * Render contributors list
	 *
	 * @param array   $data             Contributors data.
	 * @param boolean $version_switcher Whether to show version switcher.
	 * @return string
	 */
	public function render( $data, $version_switcher = true ) {
		if ( empty( $data ) || ! isset( $data['groups'] ) ) {
			return $this->render_error_message();
		}

		// Prepare data for templates
		$view_data                     = $this->prepare_template_data( $data, $version_switcher );
		$view_data['version_switcher'] = $version_switcher;
		$view_data['versions']         = $this->get_available_versions();

		// Start output buffering
		ob_start();

		// Include main template
		$this->get_template( 'contributors-list', $view_data );

		return ob_get_clean();
	}

	/**
	 * Prepare data for templates
	 *
	 * @param array   $data             Raw API data.
	 * @param boolean $version_switcher Whether to show version switcher.
	 * @return array Prepared data for templates
	 */
	private function prepare_template_data( $data, $version_switcher = true ) {
		return array(
			'version'                 => $data['data']['version'] ?? '',
			'noteworthy_contributors' => $this->get_noteworthy_contributors( $data ),
			'core_contributors'       => $this->get_core_contributors( $data ),
			'version_switcher'        => $version_switcher,
			'versions'                => array(),
		);
	}

	/**
	 * Get template file
	 *
	 * @param string $template Template name.
	 * @param array  $data Data to pass to template.
	 * @return void
	 */
	private function get_template( $template, $data ) {
		$template_file = WPCG_PLUGIN_DIR . "templates/{$template}.php";

		if ( file_exists( $template_file ) ) {
			// Pass data to template scope
			$noteworthy_contributors = $data['noteworthy_contributors'] ?? array();
			$core_contributors       = $data['core_contributors'] ?? array();
			$version                 = $data['version'] ?? '';
			$version_switcher        = $data['version_switcher'] ?? true;
			$versions                = $data['versions'] ?? array();

			include $template_file;
		}
	}

	/**
	 * Include a template partial
	 *
	 * @param string $partial Partial template name.
	 * @param array  $data Data to pass to partial.
	 * @return void
	 */
	public function get_template_partial( $partial, $data ) {
		$partial_file = WPCG_PLUGIN_DIR . "templates/partials/{$partial}.php";

		if ( file_exists( $partial_file ) ) {
			$contributors = $data['contributors'] ?? array();
			include $partial_file;
		}
	}

	/**
	 * Get noteworthy contributors
	 *
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
	 * Get available WordPress versions
	 *
	 * @return array
	 */
	private function get_available_versions() {
		$current_version = get_bloginfo( 'version' );
		$major_version   = (float) $current_version;
		$versions        = array();

		// Add versions from 5.0 to current version
		for ( $v = 5.0; $v <= $major_version; $v += 0.1 ) {
			$versions[] = number_format( $v, 1 );
		}

		return $versions;
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

	/**
	 * Render error message
	 *
	 * @return string
	 */
	private function render_error_message() {
		return sprintf(
			'<p class="wpcg-error">%s</p>',
			esc_html__( 'Unable to fetch contributors data.', 'contributors-gallery' )
		);
	}
}
