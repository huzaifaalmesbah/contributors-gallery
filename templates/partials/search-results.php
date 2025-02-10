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
            $output = '';
            if ($results['total_noteworthy'] > 0) {
                $output .= sprintf(
                    /* translators: 1: display name, 2: total noteworthy versions */
                    esc_html__('%1$s: %2$d Noteworthy ', 'contributors-gallery'),
                    esc_html($results['display_name']),
                    esc_html($results['total_noteworthy'])
                );
                if ($results['total_core'] > 0) {
                    $output .= sprintf(
                        /* translators: %d: total core versions */
                        esc_html__(' and %d Core Contributions', 'contributors-gallery'),
                        esc_html($results['total_core'])
                    );
                }
            } elseif ($results['total_core'] > 0) {
                $output .= sprintf(
                    /* translators: 1: display name, 2: total core versions */
                    esc_html__('%1$s: %2$d Core Contributions', 'contributors-gallery'),
                    esc_html($results['display_name']),
                    esc_html($results['total_core'])
                );
            }
            echo $output;
        ?></h3>
        <a href="https://profiles.wordpress.org/<?php echo esc_attr($results['username']); ?>/" class="wpcg-profile-button" target="_blank">
            <?php esc_html_e('Visit WP Profile', 'contributors-gallery'); ?>
        </a>
    </div>

    <?php if (!empty($results['noteworthy_versions'])) : ?>
        <div class="wpcg-version-list">
            <h4><?php esc_html_e('Noteworthy Contributions:', 'contributors-gallery'); ?></h4>
            <ul>
                <?php 
                    $sorted_noteworthy = $results['noteworthy_versions'];
                    sort($sorted_noteworthy, SORT_NATURAL);
                    foreach ($sorted_noteworthy as $version) : ?>
                    <li><?php echo esc_html($version); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($results['core_versions'])) : ?>
        <div class="wpcg-version-list">
            <h4><?php esc_html_e('Core Contributions:', 'contributors-gallery'); ?></h4>
            <ul>
                <?php 
                    $sorted_core = $results['core_versions'];
                    sort($sorted_core, SORT_NATURAL);
                    foreach ($sorted_core as $version) : ?>
                    <li><?php echo esc_html($version); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>