<?php
namespace WPCG\Views;

/**
 * Search View Class
 *
 * Handles the search form rendering and results display.
 *
 * @since 1.0.4
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
            $rendered_content = $this->template_renderer->render_template('contributor-search', array(
                'nonce' => wp_create_nonce('wpcg_search_nonce'),
                'plugin_url' => WPCG_PLUGIN_URL
            ));
            
            if (empty($rendered_content)) {
                error_log('WPCG Error: Empty content returned from template renderer');
                return '<div class="wpcg-error">Error: Unable to render search form.</div>';
            }
            return $rendered_content;
        } catch (\Exception $e) {
            error_log('WPCG Error: Failed to render search form - ' . $e->getMessage());
            return '<div class="wpcg-error">Error: Unable to render search form.</div>';
        }
    }

    /**
     * Render search results
     *
     * @param array $results Search results data
     * @return string
     */
    public function render_search_results($results) {
        if (!isset($results['total_count']) || !isset($results['versions'])) {
            error_log('WPCG Debug: Invalid search results format');
            return '<div class="wpcg-error">' . esc_html__('Invalid search results format.', 'contributors-gallery') . '</div>';
        }

        error_log('WPCG Debug: Preparing to render search results');
        error_log('WPCG Debug: Results data - Total Count: ' . $results['total_count'] . ', Versions: ' . implode(', ', $results['versions']));

        ob_start();
        $results = array(
            'total_count' => intval($results['total_count']),
            'versions' => array_map('sanitize_text_field', $results['versions'])
        );
        include WPCG_PLUGIN_DIR . 'templates/partials/search-results.php';
        $output = ob_get_clean();

        if (empty($output)) {
            error_log('WPCG Error: No output generated from search results template');
        } else {
            error_log('WPCG Debug: Successfully rendered search results');
        }

        return $output;
    }
}