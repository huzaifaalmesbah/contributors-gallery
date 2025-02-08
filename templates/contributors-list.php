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
				<select class="wpcg-version-select">
					<?php foreach ( $versions as $v ) : ?>
						<option value="<?php echo esc_attr( $v ); ?>" <?php selected( $v, $version ); ?>>
							<?php
							/* translators: %s: WordPress version number */
							printf( esc_html__( 'WordPress %s', 'contributors-gallery' ), esc_html( $v ) );
							?>
						</option>
					<?php endforeach; ?>
				</select>
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
