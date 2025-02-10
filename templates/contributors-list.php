<?php
/**
 * Main template for contributors list
 *
 * @package WPCG
 * @var array $noteworthy_contributors
 * @var array $core_contributors
 * @var string $version
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure variables are set
$noteworthy_contributors = $noteworthy_contributors ?? array();
$core_contributors       = $core_contributors ?? array();
$version                 = $version ?? '';
?>

<div class="wpcg-contributors-wrap">
	<div class="wpcg-header">
		<div class="wpcg-header-title">
			<?php if ( ! empty( $version ) ) : ?>
				<h2>
					<?php
					printf(
						/* translators: 1: WordPress version, 2: Total contributors count */
						esc_html__( 'WordPress %1$s Contributors (%2$s)', 'contributors-gallery' ),
						esc_html( $version ),
						esc_html( count( $noteworthy_contributors ) + count( $core_contributors ) )
					);
					?>
				</h2>
			<?php endif; ?>
		</div>
		<div class="wpcg-header-controls">
			<?php if ( $version_switcher ) : ?>
				<div class="wpcg-version-dropdown">
				<input type="text" class="wpcg-version-input" readonly value="<?php
				printf(
				/* translators: %s: WordPress version number */
					esc_html__( 'WordPress %s', 'contributors-gallery' ),
					esc_html( $version )
				);
				?>">
					<ul class="wpcg-version-list">
						<?php
						// Sort versions in descending order
						rsort( $versions, SORT_NATURAL );
						foreach ( $versions as $v ) :
							?>
							<li class="wpcg-version-item <?php echo $v === $version ? 'active' : ''; ?>" data-value="<?php echo esc_attr( $v ); ?>">
								<?php
								/* translators: %s: WordPress version number */
								printf( esc_html__( 'WordPress %s', 'contributors-gallery' ), esc_html( $v ) );
								?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="wpcg-loading-overlay">
		<img src="<?php echo esc_url( WPCG_PLUGIN_URL . 'assets/img/loading.svg' ); ?>" alt="Loading...">
	</div>

	<?php
	// Include noteworthy contributors section
	$this->get_template_partial(
		'noteworthy-contributors',
		array( 'contributors' => $noteworthy_contributors )
	);

	// Include core contributors section
	$this->get_template_partial(
		'core-contributors',
		array( 'contributors' => $core_contributors )
	);
	?>
</div>
