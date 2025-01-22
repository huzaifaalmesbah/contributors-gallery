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
?>

<div class="wpcg-contributors-wrap">
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

	<?php
	// Include noteworthy contributors section
	$this->get_template_partial(
		'noteworthy-contributors',
		array(
			'contributors' => $noteworthy_contributors,
		)
	);

	// Include core contributors section
	$this->get_template_partial(
		'core-contributors',
		array(
			'contributors' => $core_contributors,
		)
	);
	?>
</div>
