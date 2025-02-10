<?php
namespace WPCG\Controllers;

use WPCG\Services\WPVersionFetcher;
use WPCG\Services\ApiService;
use WPCG\Views\SearchView;

/**
 * Search Controller Class
 *
 * Handles the contributor search functionality across WordPress versions.
 *
 * @since 1.0.4
 */
class SearchController {

    /**
     * WPVersionFetcher instance
     *
     * @var WPVersionFetcher
     */
    private $version_fetcher;

    /**
     * ApiService instance
     *
     * @var ApiService
     */
    private $api_service;

    /**
     * SearchView instance
     *
     * @var SearchView
     */
    private $search_view;

    /**
     * Constructor
     */
    public function __construct() {
        $this->version_fetcher = new WPVersionFetcher();
        $this->api_service = new ApiService();
        $this->search_view = new SearchView();
        $this->init();
    }

    /**
     * Initialize the controller
     */
    public function init() {
        add_shortcode('wpcg_contributor_search', array($this, 'render_search_form'));
        add_action('wp_ajax_wpcg_search_contributor', array($this, 'handle_search_request'));
        add_action('wp_ajax_nopriv_wpcg_search_contributor', array($this, 'handle_search_request'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'wpcg-search-handler',
            WPCG_PLUGIN_URL . 'assets/js/wpcg-search-handler.js',
            array('jquery'),
            WPCG_VERSION,
            true
        );

        wp_localize_script(
            'wpcg-search-handler',
            'wpcg_search_ajax',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wpcg_search_nonce')
            )
        );

        wp_enqueue_style(
            'wpcg-search-styles',
            WPCG_PLUGIN_URL . 'assets/css/wpcg-search-styles.css',
            array(),
            WPCG_VERSION
        );
    }

    /**
     * Render the search form
     *
     * @return string
     */
    public function render_search_form() {
        return $this->search_view->render_search_form();
    }

    /**
     * Handle the AJAX search request
     */
    public function handle_search_request() {
        check_ajax_referer('wpcg_search_nonce', 'nonce');

        $username = sanitize_text_field($_POST['username']);
        if (empty($username)) {
            wp_send_json_error('Username is required');
        }

        $results = $this->search_contributor($username);
        $output = $this->search_view->render_search_results($results);

        if (empty($output)) {
            wp_send_json_error('No output generated for search results', array('debug' => $results));
        }

        wp_send_json_success($output);
    }

    /**
     * Search for a contributor across all versions
     *
     * @param string $username The username to search for
     * @return array Search results
     */
    private function search_contributor($username) {
        $versions = $this->version_fetcher->get_available_versions();
        $found_versions = array();
        $total_count = 0;

        foreach ($versions as $version) {
            $transient_key = 'wpcg_contributors_' . $version;
            $contributors_data = get_transient($transient_key);

            if (!$contributors_data || empty($contributors_data['groups'])) {
                continue;
            }

            $found = false;
            foreach ($contributors_data['groups'] as $group) {
                if (isset($group['data'][$username])) {
                    $found = true;
                    $total_count++;
                    break;
                }
            }

            if ($found) {
                $found_versions[] = $version;
            }
        }

        return array(
            'total_count' => $total_count,
            'versions' => $found_versions
        );
    }
}