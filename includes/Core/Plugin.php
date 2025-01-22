<?php
namespace WPCG\Core;

use WPCG\Controllers\ShortcodeController;

/**
 * Main Plugin Class
 */
class Plugin {
	/**
	 * Plugin instance
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Get plugin instance
	 *
	 * @return self
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize plugin
	 */
	public static function init() {
		$instance = self::get_instance();
		$instance->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Initialize controllers
		new ShortcodeController();
	}
}
