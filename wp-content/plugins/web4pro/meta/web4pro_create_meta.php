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
 * Register meta boxes.
 */
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
function hcf_save_meta_box($event_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if ($parent_id = wp_is_post_revision($event_id)) {
        $event_id = $parent_id;
    }
    $fields = [
        'hcf_published_date',
        'hcf_event',
    ];
    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($event_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

add_action('save_post', 'hcf_save_meta_box');