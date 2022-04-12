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
 * events_register
 */
function events_register()
{
    $labels = array(
        'name' => _x('Events', 'post type general name'),
        'singular_name' => _x('Events Item', 'post type singular name'),
        'add_new' => _x('Add New', 'events item'),
        'add_new_item' => __('Add New Events Item'),
        'edit_item' => __('Edit Events Item'),
        'new_item' => __('New Events Item'),
        'view_item' => __('View Events Item'),
        'search_items' => __('Search Events Items'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
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
        'name' => _x('Status', 'taxonomy general name'),
        'singular_name' => _x('Option', 'taxonomy singular name'),
        'search_items' => __('Search Status'),
        'all_items' => __('All Status'),
        'parent_item' => __('Parent Option'),
        'parent_item_colon' => __('Parent Option:'),
        'edit_item' => __('Edit Option'),
        'update_item' => __('Update Option'),
        'add_new_item' => __('Add New Option'),
        'new_item_name' => __('New Option Name'),
        'menu_name' => __('Status'),
    );

    $args = array(
        'hierarchical' => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'status'),
    );

    register_taxonomy('events_status', array('events'), $args);
}

add_action('init', 'create_events_taxonomies', 0);
