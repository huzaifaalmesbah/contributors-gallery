<?php
/**
 * Noteworthy contributors partial template
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

<div class="wpcg-section wpcg-noteworthy">
	<h3>
		<?php
		printf(
			/* translators: %s: Noteworthy contributors count */
			esc_html__( 'Noteworthy Contributors (%s)', 'contributors-gallery' ),
			esc_html( count( $contributors ) )
		);
		?>
	</h3>
	
	<div class="wpcg-contributor-list">
		<?php foreach ( $contributors as $username => $user_data ) : ?>
			<a href="
			<?php
			echo esc_url(
				sprintf(
					'https://profiles.wordpress.org/%s',
					$username
				)
			);
			?>
			" 
			target="_blank" 
			rel="noopener noreferrer"
			class="wpcg-contributor-item">
				<?php if ( ! empty( $user_data[1] ) ) : ?>
					<img src="
					<?php
					echo esc_url(
						sprintf(
							'https://secure.gravatar.com/avatar/%s?s=80&d=mm&r=g',
							$user_data[1]
						)
					);
					?>
					" 
					alt="<?php echo esc_attr( $user_data[0] ); ?>"
					class="wpcg-avatar">
				<?php endif; ?>

				<h4><?php echo esc_html( $user_data[0] ); ?></h4>

				<?php if ( ! empty( $user_data[3] ) ) : ?>
					<span class="wpcg-role">
						<?php echo esc_html( $user_data[3] ); ?>
					</span>
				<?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</div>
