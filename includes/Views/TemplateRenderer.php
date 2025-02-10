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
		error_log('WPCG Debug: Starting template render for: ' . $template);
		ob_start();
		$this->get_template( $template, $data );
		$content = ob_get_clean();
		if (empty($content)) {
			error_log('WPCG Error: Empty content generated for template: ' . $template);
		}
		return $content;
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
		error_log('WPCG Debug: Loading template file: ' . $template_file);

		if ( file_exists( $template_file ) ) {
			// Extract data to template scope
			extract($data);

			try {
				include $template_file;
				error_log('WPCG Debug: Successfully included template: ' . $template);
			} catch (\Exception $e) {
				error_log('WPCG Error: Failed to include template ' . $template . ' - ' . $e->getMessage());
			}
		} else {
			error_log('WPCG Error: Template file not found: ' . $template_file);
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
		error_log('WPCG Debug: Loading partial template: ' . $partial_file);

		if ( file_exists( $partial_file ) ) {
			// Extract data to template scope
			extract($data);

			try {
				include $partial_file;
				error_log('WPCG Debug: Successfully included partial: ' . $partial);
			} catch (\Exception $e) {
				error_log('WPCG Error: Failed to include partial ' . $partial . ' - ' . $e->getMessage());
			}
		} else {
			error_log('WPCG Error: Partial template file not found: ' . $partial_file);
		}
	}
}
