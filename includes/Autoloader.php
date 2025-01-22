<?php
namespace WPCG;

/**
 * PSR-4 Autoloader
 */
class Autoloader {

	/**
	 * Register autoloader
	 */
	public static function register() {
		spl_autoload_register( array( new self(), 'autoload' ) );
	}

	/**
	 * Autoload callback
	 *
	 * @param string $class Class name.
	 */
	public function autoload( $class ) {
		// Check if the class uses our namespace
		$namespace = 'WPCG\\';
		if ( strpos( $class, $namespace ) !== 0 ) {
			return;
		}

		// Get the relative class name
		$relative_class = substr( $class, strlen( $namespace ) );

		// Convert class name to file path
		$file = WPCG_PLUGIN_DIR . 'includes/' . str_replace( '\\', '/', $relative_class ) . '.php';

		// Include the file if it exists
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
}
