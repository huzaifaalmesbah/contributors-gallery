<?php
/**
 * Core contributors partial template
 *
 * @package WPCG
 * @var array $contributors
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $contributors ) ) {
	return;
}
?>

<div class="wpcg-section wpcg-core">
	<h3>
		<?php
		printf(
			/* translators: %s: Core contributors count */
			esc_html__( 'Core Contributors (%s)', 'contributors-gallery' ),
			esc_html( count( $contributors ) )
		);
		?>
	</h3>
	
	<div class="wpcg-contributors-inline">
		<?php
		$links = array_map(
			function ( $username, $display_name ) {
				return sprintf(
					'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
					esc_url( "https://profiles.wordpress.org/$username" ),
					esc_html( $display_name )
				);
			},
			array_keys( $contributors ),
			array_values( $contributors )
		);

		echo wp_kses_post( implode( ', ', $links ) );
		?>
	</div>
</div>
