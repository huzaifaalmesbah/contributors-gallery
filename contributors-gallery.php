<?php
/**
 * Plugin Name: Contributors Gallery
 * Plugin URI: https://wordpress.org/plugins/contributors-gallery/
 * Author: Huzaifa Al Mesbah
 * Author URI: https://www.linkedin.com/in/huzaifaalmesbah/
 * Description: Display WordPress contributors in a beautiful gallery with version switcher and powerful search functionality.
 * Version: 1.2.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: contributors-gallery
 *
 * @package WPCG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'WPCG_VERSION', '1.2.0' );
define( 'WPCG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPCG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Autoloader
require_once WPCG_PLUGIN_DIR . 'includes/Autoloader.php';
\WPCG\Autoloader::register();

// Initialize plugin
add_action( 'plugins_loaded', array( '\WPCG\Core\Plugin', 'init' ) );
