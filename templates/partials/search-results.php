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
        <h3 class="wpcg-search-count"><?php
            printf(
                /* translators: 1: username, 2: number of WordPress versions */
                _n(
                    '%1$s: Contributed on %2$d WP Version',
                    '%1$s: Contributed on %2$d WP Versions',
                    $results['total_count'],
                    'contributors-gallery'
                ),
                esc_html($results['username']),
                esc_html($results['total_count'])
            );
        ?></h3>
        <a href="https://profiles.wordpress.org/<?php echo esc_attr($results['username']); ?>/" class="wpcg-profile-button" target="_blank">
            <?php esc_html_e('Visit WP Profile', 'contributors-gallery'); ?>
        </a>
    </div>

    <?php if (!empty($results['versions'])) : ?>
        <div class="wpcg-version-list">
            <h4><?php esc_html_e('Contributed to versions:', 'contributors-gallery'); ?></h4>
            <ul>
                <?php foreach ($results['versions'] as $version) : ?>
                    <li>
<?php echo esc_html($version); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>