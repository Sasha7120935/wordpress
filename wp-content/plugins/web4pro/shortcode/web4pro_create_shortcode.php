<?php
/**
 * Plugin Name: Web4pro
 * Plugin URI: https://wordpress.com/
 * Description: An Web4pro toolkit that helps you sell anything. Beautifully.
 * Version: 6.3.1
 * Author: Automattic
 * Author URI: https://wordpress.com/
 * Text Domain:
 * Domain Path: /i18n/languages/
 * Requires at least: 5.7
 * Requires PHP: 7.0
 *
 * @package Web4pro
 */
/**
 * @param $atts
 * @return string
 */
function recent_posts_function($atts)
{
    $args = [
        'post_type' => 'events',
        'meta_query' => [['key' => 'hcf_event', 'value' => $atts['status']]],
        'posts_per_page' => $atts['quantity']
    ];
    $events_query = new WP_Query($args);
    if ($events_query->have_posts()) :
        while ($events_query->have_posts()) : $events_query->the_post();
            $return_string .= '<li>' . get_the_title() . ' ' . get_the_date() . '</li>';
        endwhile;
    endif;
    wp_reset_query();
    return $return_string;
}

add_shortcode('events', 'recent_posts_function');