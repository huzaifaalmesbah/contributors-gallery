<?php
namespace WPCG\Views;

/**
 * Contributors View Class
 */
class ContributorsView {

	/**
	 * Render contributors list
	 *
	 * @param array $data Contributors data.
	 * @return string
	 */
	public function render( $data ) {
		if ( empty( $data ) || ! isset( $data['groups'] ) ) {
			return $this->render_error_message();
		}

		// Prepare data for templates
		$view_data = $this->prepare_template_data( $data );

		// Start output buffering
		ob_start();

		// Include main template
		$this->get_template( 'contributors-list', $view_data );

		return ob_get_clean();
	}

	/**
	 * Prepare data for templates
	 *
	 * @param array $data Raw API data.
	 * @return array Prepared data for templates
	 */
	private function prepare_template_data( $data ) {
		return array(
			'version'                 => $data['data']['version'] ?? '',
			'noteworthy_contributors' => $this->get_noteworthy_contributors( $data ),
			'core_contributors'       => $this->get_core_contributors( $data ),
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
			// Pass specific data needed for each partial
			switch ( $partial ) {
				case 'noteworthy-contributors':
					$contributors = $data['contributors'] ?? array();
					break;
				case 'core-contributors':
					$contributors = $data['contributors'] ?? array();
					break;
				default:
					$contributors = array();
			}

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
