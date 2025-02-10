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
	public function render_template( $template, $data = array() ) {
		$template_file = WPCG_PLUGIN_DIR . 'templates/' . $template . '.php';
		if ( ! file_exists( $template_file ) ) {
			return '';
		}

		ob_start();
		try {
			// Make data available to template
			foreach ( $data as $key => $value ) {
				$$key = $value;
			}
			include $template_file;
			$content = ob_get_clean();
			return $content;
		} catch ( \Exception $e ) {
			ob_end_clean();
			return '';
		}
	}

	/**
	 * Include a template partial file
	 *
	 * @since 1.0.2
	 * @param string $partial Partial template name.
	 * @param array  $data    Data to pass to partial template.
	 * @return void
	 */
	public function get_template_partial( $partial, $data = array() ) {
		$partial_file = WPCG_PLUGIN_DIR . 'templates/partials/' . $partial . '.php';
		if ( ! file_exists( $partial_file ) ) {
			return;
		}

		try {
			// Make data available to partial template
			foreach ( $data as $key => $value ) {
				$$key = $value;
			}
			include $partial_file;
		} catch ( \Exception $e ) {
			return;
		}
	}
}
