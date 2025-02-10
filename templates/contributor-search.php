<?php
/**
 * Template for contributor search functionality
 *
 * @package WPCG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wpcg-search-container">
	<h2 class="wpcg-search-heading">
		<?php esc_html_e( 'Find WordPress Core Contributor', 'contributors-gallery' ); ?>
	</h2>
	<p class="wpcg-search-description">
		<?php esc_html_e( 'Search for WordPress.org users who contributed to core development.', 'contributors-gallery' ); ?>
	</p>

	<form id="wpcg-contributor-search" class="wpcg-search-form">
		<div class="wpcg-search-input-wrapper">
			<input type="text" 
					id="wpcg-search-input" 
					class="wpcg-search-input" 
					placeholder="<?php esc_attr_e( 'Enter WP.org username...', 'contributors-gallery' ); ?>" 
					required>
			<button type="submit" class="wpcg-search-button">
				<?php esc_html_e( 'Search', 'contributors-gallery' ); ?>
			</button>
		</div>
	</form>
	
	<div id="wpcg-search-results" class="wpcg-search-results">
		<!-- Search results will be loaded here via AJAX -->
	</div>
</div>
