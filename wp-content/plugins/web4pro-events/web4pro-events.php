<?php
/**
 * Plugin Name: Web4pro Events
 * Plugin URI: https://wordpress.com/
 * Description: An Web4pro toolkit that helps you sell anything. Beautifully.
 * Version: 6.3.1
 * Author: Automattic
 * Author URI: https://wordpress.com/
 * Text Domain:
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.0
 *
 * @package Web4pro Events
 */
$dirname = dirname(__FILE__);
function hcf_display_callback()
{
    include dirname(__FILE__) . '/meta/form.php';
}

include dirname(__FILE__) . '/widget/web4pro-create-widget.php';

function hcf_register_meta_boxes()
{
    add_meta_box('hcf-1', __('Status', 'hcf'), 'hcf_display_callback', 'events');
}

add_action('add_meta_boxes', 'hcf_register_meta_boxes');
/**
 * Save meta box content.
 *
 * @param int $event_id
 */
function hcf_save_meta_box( $event_id )
{
    $fields = [
        'hcf_published_date',
        'hcf_event',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $event_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
    }
}

add_action('save_post', 'hcf_save_meta_box');
/**
 * events_register
 */
function events_register()
{
    $labels = array(
        'name' => _x('Events', 'web4pro-events'),
        'singular_name' => _x('Events Item', 'web4pro-events'),
        'add_new' => _x('Add New', 'web4pro-events'),
        'add_new_item' => __('Add New Events Item', 'web4pro-events'),
        'edit_item' => __('Edit Events Item', 'web4pro-events'),
        'new_item' => __('New Events Item', 'web4pro-events'),
        'view_item' => __('View Events Item', 'web4pro-events'),
        'search_items' => __('Search Events Items', 'web4pro-events'),
        'not_found' => __('Nothing found', 'web4pro-events'),
        'not_found_in_trash' => __('Nothing found in Trash', 'web4pro-events'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 8,
        'supports' => array('title', 'editor', 'thumbnail')
    );
    register_post_type('events', $args);
}

add_action('init', 'events_register');

/**
 * create_events_taxonomies
 */
function create_events_taxonomies()
{
    $labels = array(
        'name' => _x('Status', 'web4pro-events'),
        'singular_name' => _x('Option', 'web4pro-events'),
        'search_items' => __('Search Status', 'web4pro-events'),
        'all_items' => __('All Status', 'web4pro-events'),
        'parent_item' => __('Parent Option', 'web4pro-events'),
        'parent_item_colon' => __('Parent Option:', 'web4pro-events'),
        'edit_item' => __('Edit Option', 'web4pro-events'),
        'update_item' => __('Update Option', 'web4pro-events'),
        'add_new_item' => __('Add New Option', 'web4pro-events'),
        'new_item_name' => __('New Option Name', 'web4pro-events'),
        'menu_name' => __('Status', 'web4pro-events'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'status'),
    );

    register_taxonomy('events_status', array('events'), $args);
}

add_action('wp_loaded', 'create_events_taxonomies');
/**
 * @param $atts
 * @return string
 */
function recent_posts_function( $atts )
{
    $args = [
        'post_type' => 'events',
        'meta_query' => [
            [
                'key' => 'hcf_event',
                'value' => $atts['status']
            ]
        ],
        'posts_per_page' => $atts['quantity']
    ];
    $events_query = new WP_Query( $args );
    if ( $events_query->have_posts() ) :
        while ( $events_query->have_posts() ) : $events_query->the_post();
            $return_string .= '<li>' . get_the_title() . ' ' . get_the_date() . '</li>';
        endwhile;
        else:
        return '<p><strong>' . _e('not found','web4pro-events') . '</strong></p>';
    endif;
    wp_reset_query();
    return $return_string;
}

add_shortcode('events', 'recent_posts_function');

function plugin_load_textdomain()
{
    load_plugin_textdomain('web4pro-events', false, basename(dirname(__FILE__)) . '/languages/');
}

add_action('init', 'plugin_load_textdomain');