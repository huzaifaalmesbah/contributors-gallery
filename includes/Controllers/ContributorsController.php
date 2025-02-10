<?php
namespace WPCG\Controllers;

use WPCG\Services\ApiService;
use WPCG\Views\ContributorsView;

/**
 * Contributors Controller Class
 */
class ContributorsController {
	/**
	 * API Service instance
	 *
	 * @var ApiService
	 */
	private $api_service;

	/**
	 * View instance
	 *
	 * @var ContributorsView
	 */
	private $view;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->api_service = new ApiService();
		$this->view        = new ContributorsView();
		add_shortcode( 'wpcg_contributors', array( $this, 'render_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_wpcg_load_contributors', array( $this, 'load_contributors' ) );
		add_action( 'wp_ajax_nopriv_wpcg_load_contributors', array( $this, 'load_contributors' ) );
	}

	/**
	 * Render shortcode
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'version'  => '',
				'switcher' => 'true',
			),
			$atts,
			'wpcg_contributors'
		);

		$data             = $this->api_service->get_contributors_data( $atts['version'] );
		$version_switcher = filter_var( $atts['switcher'], FILTER_VALIDATE_BOOLEAN );
		return $this->view->render( $data, $version_switcher );
	}

	/**
	 * Enqueue styles
	 */
	public function enqueue_scripts() {
		global $post;

		// Only enqueue if post content contains the shortcode
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wpcg_contributors' ) ) {
			$file_modified_time = filemtime( WPCG_PLUGIN_DIR . 'assets/css/wpcg-styles.css' );
			wp_enqueue_style(
				'wpcg-styles',
				WPCG_PLUGIN_URL . 'assets/css/wpcg-styles.css',
				array(),
				$file_modified_time
			);

			$js_modified_time = filemtime( WPCG_PLUGIN_DIR . 'assets/js/wpcg-contributors-handler.js' );
			wp_enqueue_script(
				'wpcg-contributors-handler',
				WPCG_PLUGIN_URL . 'assets/js/wpcg-contributors-handler.js',
				array( 'jquery' ),
				$js_modified_time,
				true
			);

			wp_localize_script(
				'wpcg-contributors-handler',
				'wpcg_ajax',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'wpcg_nonce' ),
				)
			);
		}
	}

	/**
	 * Load contributors for a specific version
	 */
	public function load_contributors() {
		check_ajax_referer( 'wpcg_nonce', 'nonce' );

		$version = sanitize_text_field( $_POST['version'] );
		$data    = $this->api_service->get_contributors_data( $version );

		if ( ! $data ) {
			wp_send_json_error( 'No contributors found for this version.' );
		}

		wp_send_json_success( $this->view->render( $data ) );
	}
}
