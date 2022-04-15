<?php
/**
 * Plugin Name: Web4pro Field Checkout
 * Plugin URI: https://wordpress.com/
 * Description: An Web4pro toolkit that helps you sell anything. Beautifully.
 * Version: 6.3.1
 * Author: Automattic
 * Author URI: https://wordpress.com/
 * Text Domain:
 * Domain Path: /i18n/languages/
 * Requires at least: 5.7
 * Requires PHP: 7.4
 *
 * @package Web4pro
 */
add_action('woocommerce_before_order_notes', 'additional_information_checkout_field');

function additional_information_checkout_field($checkout)
{
    $current_user = wp_get_current_user();
    $saved_additional_information = $current_user->additional_information;
    woocommerce_form_field('additional_information', array(
        'type' => 'text',
        'class' => array('form-row-wide'),
        'label' => 'Additional Information',
        'placeholder' => 'write a question',
        'required' => true,
        'default' => $saved_additional_information,
    ), $checkout->get_value('additional_information'));
}

add_action('woocommerce_checkout_update_order_meta', 'additional_information_save_new_checkout_field');

function additional_information_save_new_checkout_field($order_id)
{
    if ($_POST['additional_information']) update_post_meta($order_id, 'additional_information', esc_attr($_POST['additional_information']));
}

add_action('woocommerce_admin_order_data_after_billing_address', 'additional_information_show_new_checkout_field_order', 10, 1);

function additional_information_show_new_checkout_field_order($order)
{
    $order_id = $order->get_id();
    if (get_post_meta($order_id, 'additional_information', true)) echo '<p><strong>Additional Information:</strong> ' . get_post_meta($order_id, 'additional_information', true) . '</p>';
}

add_action('woocommerce_email_after_order_table', 'additional_information_show_new_checkout_field_emails', 20, 4);

function additional_information_show_new_checkout_field_emails($order, $sent_to_admin, $plain_text, $email)
{
    if (get_post_meta($order->get_id(), 'additional_information', true)) echo '<p><strong>Additional Information:</strong> ' . get_post_meta($order->get_id(), 'additional_information', true) . '</p>';
    if (get_post_meta($email->get_id(), 'additional_information', true)) echo '<p><strong>Additional Information:</strong> ' . get_post_meta($email->get_id(), 'additional_information', true) . '</p>';
}