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
add_action('init', 'events_init');
function events_init() {
    $args = array(
        'labels' => array(
            'name' => __('Events'),
            'singular_name' => __('Event'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array("slug" => "events"),
        'supports' => array('thumbnail','editor','title','custom-fields')
    );
    register_post_type( 'events' , $args );
}
/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies() {
    // Add new "Options" taxonomy to Posts
    register_taxonomy('Option', 'events', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Options', 'taxonomy general name' ),
            'singular_name' => _x( 'Option', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Options' ),
            'all_items' => __( 'All Options' ),
            'parent_item' => __( 'Parent Option' ),
            'parent_item_colon' => __( 'Parent Option:' ),
            'edit_item' => __( 'Edit Option' ),
            'update_item' => __( 'Update Option' ),
            'add_new_item' => __( 'Add New Option' ),
            'new_item_name' => __( 'New Option Name' ),
            'menu_name' => __( 'Options' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'Options', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/options/"
            'hierarchical' => true // This will allow URL's like "/options/boston/cambridge/"
        ),
    ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );