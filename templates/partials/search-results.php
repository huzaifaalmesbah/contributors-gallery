<?php
if (!defined('ABSPATH')) exit;

/**
 * Template for displaying contributor search results
 *
 * @var array $results Search results data containing total_count and versions
 */
?>
<div class="wpcg-search-results-content">
    <div class="wpcg-search-summary">
        <h3 class="wpcg-search-count">
            <?php
            printf(
                /* translators: %d: number of WordPress versions */
                esc_html(_n(
                    'Found in %d WordPress version',
                    'Found in %d WordPress versions',
                    $results['total_count'],
                    'contributors-gallery'
                )),
                esc_html($results['total_count'])
            );
            ?>
        </h3>
    </div>

    <?php if (!empty($results['versions'])) : ?>
        <div class="wpcg-version-list">
            <h4><?php esc_html_e('Contributed to versions:', 'contributors-gallery'); ?></h4>
            <ul>
                <?php foreach ($results['versions'] as $version) : ?>
                    <li>
                        <?php
                        printf(
                            /* translators: %s: WordPress version number */
                            esc_html__('WordPress %s', 'contributors-gallery'),
                            esc_html($version)
                        );
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>