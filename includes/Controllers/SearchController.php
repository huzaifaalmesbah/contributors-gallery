<?php
namespace WPCG\Controllers;

use WPCG\Services\WPVersionFetcher;
use WPCG\Services\ApiService;
use WPCG\Services\ProfileService;
use WPCG\Views\SearchView;

/**
 * Search Controller Class
 *
 * Handles the contributor search functionality across WordPress versions.
 *
 * @since 1.1.0
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
	 * ProfileService instance
	 *
	 * @var ProfileService
	 */
	private $profile_service;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->version_fetcher = new WPVersionFetcher();
		$this->api_service     = new ApiService();
		$this->search_view     = new SearchView();
		$this->profile_service = new ProfileService();
		$this->init();
	}

	/**
	 * Initialize the controller
	 */
	public function init() {
		add_shortcode( 'wpcg_contributor_search', array( $this, 'render_search_form' ) );
		add_action( 'wp_ajax_wpcg_search_contributor', array( $this, 'handle_search_request' ) );
		add_action( 'wp_ajax_nopriv_wpcg_search_contributor', array( $this, 'handle_search_request' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts() {
		global $post;

		// Only enqueue if post content contains the shortcode
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wpcg_contributor_search' ) ) {
			$css_modified_time = filemtime( WPCG_PLUGIN_DIR . 'assets/css/wpcg-search-styles.css' );
			wp_enqueue_style(
				'wpcg-search-styles',
				WPCG_PLUGIN_URL . 'assets/css/wpcg-search-styles.css',
				array(),
				$css_modified_time
			);

			$js_modified_time = filemtime( WPCG_PLUGIN_DIR . 'assets/js/wpcg-search-handler.js' );
			wp_enqueue_script(
				'wpcg-search-handler',
				WPCG_PLUGIN_URL . 'assets/js/wpcg-search-handler.js',
				array( 'jquery' ),
				$js_modified_time,
				true
			);

			wp_localize_script(
				'wpcg-search-handler',
				'wpcg_search_ajax',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'wpcg_search_nonce' ),
				)
			);
		}
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
		check_ajax_referer( 'wpcg_search_nonce', 'nonce' );
		$username = sanitize_text_field( $_POST['username'] );
		if ( empty( $username ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Username is required', 'contributors-gallery' ),
				)
			);
		}
		$results = $this->search_contributor( $username );
		if ( empty( $results['noteworthy_versions'] ) && empty( $results['core_versions'] ) ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %s: WordPress.org username */
						__( 'No contributions found for %s', 'contributors-gallery' ),
						$username
					),
				)
			);
		}
		$output = $this->search_view->render_search_results( $results );
		if ( empty( $output ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Error generating search results', 'contributors-gallery' ),
				)
			);
		}
		wp_send_json_success( $output );
	}

	/**
	 * Search for a contributor across all versions
	 *
	 * @param string $username The username to search for.
	 * @return array Search results.
	 */
	private function search_contributor( $username ) {
		$versions            = $this->version_fetcher->get_available_versions();
		$noteworthy_versions = array();
		$core_versions       = array();
		$display_name        = '';
		$role                = '';

		foreach ( $versions as $version ) {
			$transient_key     = 'wpcg_contributors_' . $version;
			$contributors_data = get_transient( $transient_key );

			if ( ! $contributors_data || empty( $contributors_data['groups'] ) ) {
				$contributors_data = $this->api_service->get_contributors_data( $version );
				if ( ! $contributors_data || empty( $contributors_data['groups'] ) ) {
					continue;
				}
			}

			// Check for noteworthy contributors (core-developers and contributing-developers)
			if ( isset( $contributors_data['groups']['core-developers']['data'][ $username ] ) ) {
				$noteworthy_versions[] = $version;
				if ( empty( $display_name ) ) {
					$display_name = $contributors_data['groups']['core-developers']['data'][ $username ][0];
					$role         = $contributors_data['groups']['core-developers']['data'][ $username ][3];
				}
			} elseif ( isset( $contributors_data['groups']['contributing-developers']['data'][ $username ] ) ) {
				$noteworthy_versions[] = $version;
				if ( empty( $display_name ) ) {
					$display_name = $contributors_data['groups']['contributing-developers']['data'][ $username ][0];
					$role         = $contributors_data['groups']['contributing-developers']['data'][ $username ][3];
				}
			} elseif ( isset( $contributors_data['groups']['props']['data'][ $username ] ) ) {
				$core_versions[] = $version;
				if ( empty( $display_name ) ) {
					$display_name = $contributors_data['groups']['props']['data'][ $username ];
				}
			}
		}

		$profile_data = $this->profile_service->get_profile_data( $username );

		return array(
			'username'            => $username,
			'display_name'        => $display_name ? $display_name : $username,
			'role'                => $role,
			'noteworthy_versions' => $noteworthy_versions,
			'core_versions'       => $core_versions,
			'total_noteworthy'    => count( $noteworthy_versions ),
			'total_core'          => count( $core_versions ),
			'profile'             => $profile_data,
		);
	}
}
