<?php
namespace WPCG\Views;

/**
 * Template Renderer Class
 *
 * Handles template rendering functionality for the Contributors Gallery plugin.
 *
 * @since 1.0.2
 */
class TemplateRenderer {

	/**
	 * Get template file
	 *
	 * @since 1.0.2
	 * @param string $template Template name.
	 * @param array  $data Data to pass to template.
	 * @return string
	 */
	public function render_template( $template, $data ) {
		ob_start();
		$this->get_template( $template, $data );
		return ob_get_clean();
	}

	/**
	 * Get template file
	 *
	 * @since 1.0.2
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
	 * Render error message
	 *
	 * @return string
	 */
	public function render_error_message() {
		return sprintf(
			'<p class="wpcg-error">%s</p>',
			esc_html__( 'Unable to fetch contributors data.', 'contributors-gallery' )
		);
	}
}
