<?php
namespace WPCG\Views;

/**
 * Search View Class
 *
 * Handles the search form rendering and results display.
 *
 * @since 1.1.0
 */
class SearchView {
	/**
	 * Template Renderer instance
	 *
	 * @var TemplateRenderer
	 */
	private $template_renderer;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->template_renderer = new TemplateRenderer();
	}

	/**
	 * Render search form
	 *
	 * @return string
	 */
	public function render_search_form() {
		try {
			$rendered_content = $this->template_renderer->render_template(
				'contributor-search',
				array(
					'nonce'      => wp_create_nonce( 'wpcg_search_nonce' ),
					'plugin_url' => WPCG_PLUGIN_URL,
				)
			);

			if ( empty( $rendered_content ) ) {
				return '<div class="wpcg-error">Error: Unable to render search form.</div>';
			}
			return $rendered_content;
		} catch ( \Exception $e ) {
			return '<div class="wpcg-error">Error: Unable to render search form.</div>';
		}
	}

	/**
	 * Render search results
	 *
	 * @param array $results Search results data.
	 * @return string
	 */
	public function render_search_results( $results ) {
		if ( ! isset( $results['noteworthy_versions'] ) || ! isset( $results['core_versions'] ) ) {
			return '<div class="wpcg-error">' . esc_html__( 'Invalid search results format.', 'contributors-gallery' ) . '</div>';
		}

		ob_start();
		$results = array(
			'username'            => sanitize_text_field( $results['username'] ),
			'display_name'        => sanitize_text_field( $results['display_name'] ),
			'role'                => sanitize_text_field( $results['role'] ),
			'noteworthy_versions' => array_map( 'sanitize_text_field', $results['noteworthy_versions'] ),
			'core_versions'       => array_map( 'sanitize_text_field', $results['core_versions'] ),
			'total_noteworthy'    => count( $results['noteworthy_versions'] ),
			'total_core'          => count( $results['core_versions'] ),
		);
		include WPCG_PLUGIN_DIR . 'templates/partials/search-results.php';
		$output = ob_get_clean();

		return $output;
	}
}
