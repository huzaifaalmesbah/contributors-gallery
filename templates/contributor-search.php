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
    <form id="wpcg-contributor-search" class="wpcg-search-form">
        <div class="wpcg-search-input-wrapper">
            <input type="text" 
                   id="wpcg-search-input" 
                   class="wpcg-search-input" 
                   placeholder="<?php esc_attr_e('Search contributors...', 'contributors-gallery'); ?>" 
                   required>
            <button type="submit" class="wpcg-search-button">
                <?php esc_html_e('Search', 'contributors-gallery'); ?>
            </button>
        </div>
    </form>
    
    <div id="wpcg-search-results" class="wpcg-search-results">
        <!-- Search results will be loaded here via AJAX -->
    </div>
</div>