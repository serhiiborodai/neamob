<?php
/**
 * Comparison table data for homepage redesign.
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Rows for "Why choose NeaMob Tech?" comparison table.
 */
function neamob_get_comparison_table_rows(): array
{
    return [
        [
            'feature'  => 'Full transparency',
            'neamob'   => true,
            'corporate'=> false,
            'boutique' => true,
            'internal' => true,
        ],
        [
            'feature'  => 'Proactive approach to strategy and KPI building',
            'neamob'   => true,
            'corporate'=> true,
            'boutique' => false,
            'internal' => true,
        ],
        [
            'feature'  => 'Cross client learnings on seasonality and best practices',
            'neamob'   => true,
            'corporate'=> true,
            'boutique' => true,
            'internal' => false,
        ],
        [
            'feature'  => 'Unique BI tools',
            'neamob'   => true,
            'corporate'=> true,
            'boutique' => false,
            'internal' => false,
        ],
        [
            'feature'  => 'Creative capabilities, and performance first approach',
            'neamob'   => true,
            'corporate'=> true,
            'boutique' => false,
            'internal' => false,
        ],
    ];
}

/**
 * Icon URL for comparison table cells.
 */
function neamob_comparison_icon_url(bool $yes): string
{
    $file = $yes ? 'check.png' : 'cross.png';
    return get_template_directory_uri() . '/assets/icons/redesign/' . $file;
}
