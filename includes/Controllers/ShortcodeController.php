<?php
namespace WPCG\Controllers;

use WPCG\Services\ApiService;
use WPCG\Views\ContributorsView;

/**
 * Shortcode Controller Class
 */
class ShortcodeController {
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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Render shortcode
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array( 'version' => '' ),
			$atts,
			'wpcg_contributors'
		);

		$data = $this->api_service->get_contributors_data( $atts['version'] );
		return $this->view->render( $data );
	}

	/**
	 * Enqueue styles
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'wpcg-styles',
			WPCG_PLUGIN_URL . 'assets/css/wpcg-styles.css',
			array(),
			WPCG_VERSION
		);
	}
}
