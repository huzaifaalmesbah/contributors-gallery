<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template for displaying contributor search results
 *
 * @var array $results Search results data containing total_count and versions
 */
?>
<div class="wpcg-contributor-search-results">
	<div class="wpcg-contributor-search-header">
		<div class="wpcg-contributor-search-summary">
			<h3 class="wpcg-contributor-count">
			<?php
				$output = '';
			if ( $results['total_noteworthy'] > 0 ) {
				$output .= sprintf(
					/* translators: 1: display name, 2: total noteworthy versions */
					esc_html__( '%1$s: %2$d Noteworthy ', 'contributors-gallery' ),
					esc_html( $results['display_name'] ),
					esc_html( $results['total_noteworthy'] )
				);
				if ( $results['total_core'] > 0 ) {
					$output .= sprintf(
						/* translators: %d: total core versions */
						esc_html__( ' and %d Core Contributions', 'contributors-gallery' ),
						esc_html( $results['total_core'] )
					);
				}
			} elseif ( $results['total_core'] > 0 ) {
				$output .= sprintf(
					/* translators: 1: display name, 2: total core versions */
					esc_html__( '%1$s: %2$d Core Contributions', 'contributors-gallery' ),
					esc_html( $results['display_name'] ),
					esc_html( $results['total_core'] )
				);
			}
				echo esc_html( $output );
			?>
			</h3>
		</div>
	</div>

	<div class="wpcg-contributor-content-wrapper">
		<div class="wpcg-contributor-profile-section">
			<?php if ( ! empty( $results['avatar_hash'] ) ) : ?>
				<div class="wpcg-contributor-profile-card">
					<div class="wpcg-contributor-avatar-container">
						<img class="wpcg-contributor-avatar" 
							src="<?php echo esc_url( sprintf( 'https://secure.gravatar.com/avatar/%s?s=200&d=mm&r=g', $results['avatar_hash'] ) ); ?>" 
							alt="<?php echo esc_attr( $results['display_name'] ); ?>">
						<a href="https://profiles.wordpress.org/<?php echo esc_attr( $results['username'] ); ?>/" 
							class="wpcg-contributor-profile-link" 
							target="_blank">
							<?php esc_html_e( 'Visit WP Profile', 'contributors-gallery' ); ?>
						</a>
					</div>
					<div class="wpcg-contributor-details">
						<h3 class="wpcg-contributor-name"><?php echo esc_html( $results['display_name'] ); ?></h3>
						<?php if ( ! empty( $results['meta_items'] ) ) : ?>
							<div class="wpcg-contributor-meta-info">
								<?php foreach ( $results['meta_items'] as $meta_item ) : ?>
									<div class="wpcg-contributor-meta-item">
										<span class="wpcg-meta-label"><?php echo esc_html( $meta_item['label'] ); ?>:</span>
										<span class="wpcg-meta-value"><?php echo esc_html( $meta_item['value'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="wpcg-contributor-contributions-section">
			<?php if ( ! empty( $results['noteworthy_versions'] ) ) : ?>
				<div class="wpcg-contribution-list noteworthy">
					<h4 class="wpcg-contribution-title"><?php esc_html_e( 'Noteworthy Contributions:', 'contributors-gallery' ); ?></h4>
					<ul class="wpcg-version-list">
						<?php
							$sorted_noteworthy = $results['noteworthy_versions'];
							sort( $sorted_noteworthy, SORT_NATURAL );
						foreach ( $sorted_noteworthy as $version ) :
							?>
							<li class="wpcg-version-item"><?php echo esc_html( $version ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $results['core_versions'] ) ) : ?>
				<div class="wpcg-contribution-list core">
					<h4 class="wpcg-contribution-title"><?php esc_html_e( 'Core Contributions:', 'contributors-gallery' ); ?></h4>
					<ul class="wpcg-version-list">
						<?php
							$sorted_core = $results['core_versions'];
							sort( $sorted_core, SORT_NATURAL );
						foreach ( $sorted_core as $version ) :
							?>
							<li class="wpcg-version-item"><?php echo esc_html( $version ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>