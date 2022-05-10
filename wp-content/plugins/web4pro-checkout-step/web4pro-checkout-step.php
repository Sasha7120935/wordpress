<?php
/*Plugin Name: Web4pro Checkout Step
Description: New step in checkout
Version: 1.0
License: null
*/

//include dirname(__FILE__) . '/info-tab-woocommerce.php';

/**
 *  add new step
 */
add_filter( 'wpmc_modify_steps', 'add_additional_info' );
if ( ! function_exists( 'add_additional_info' ) ) {
    function add_additional_info($step)
    {
        $step['settings_tab_info'] = [
            'title' => 'Additional Information','web4pro-checkout-step',
            'position' => 35,
            'class' => 'wpmc-step-custom',
            'sections' => ['settings_tab_info'],
            'priority' => 5,
        ];
        return $step;
    }
}

/**
 *  add content in step
 */
add_action( 'wmsc_step_content_settings_tab_info', 'wmsc_step_content_settings_tab_info' );
if ( ! function_exists( 'wmsc_step_content_settings_tab_info' ) ) {
    function wmsc_step_content_settings_tab_info() {
        echo '<div class="title-info" style="display: inline-grid;"><h2>' . _e('Additional Information', 'web4pro-checkout-step') . '</h2></div>';
        $checkout = WC()->checkout();
        woocommerce_form_field( 'settings_tab_info', array(
            'type'  => 'text',
            'class' => array('field-class form-row-wide'),
        ), $checkout->get_value( 'settings_tab_info' ) );
    }
}

/**
 *  add validate in step
 */
add_action( 'woocommerce_checkout_process', 'validate_settings_tab_info' );
function validate_settings_tab_info() {
    if ( ! $_POST['settings_tab_info'] || empty( $_POST['settings_tab_info'] ) ) {
        wc_add_notice( __( 'Please enter the delivery time.' ), 'error' );
    }
}

/**
 *  save in order
 */
add_action( 'woocommerce_checkout_update_order_meta', 'settings_tab_info_save_new_checkout_field' );
function settings_tab_info_save_new_checkout_field($order_id)
{
    if ( isset ( $_POST['settings_tab_info'] ) ) {
        update_post_meta( $order_id, 'settings_tab_info', sanitize_text_field($_POST['settings_tab_info'] ) );
    }
}

/**
 *  show in order new step
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'settings_tab_info_show_new_checkout_field_order', 10, 1 );
function settings_tab_info_show_new_checkout_field_order( $order )
{
    $order_id = $order->get_id();
    $info = get_post_meta( $order_id, 'settings_tab_info', true );
    if ( $info ) {
        echo '<p><strong>' . _e('Additional Information','web4pro-checkout-step') . '</strong>' . $info . '</p>';
    }
}

/**
 *  show in email new step
 */
add_action( 'woocommerce_email_after_order_table', 'settings_tab_info_show_new_checkout_field_emails', 20, 4 );
function settings_tab_info_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email )
{
    $info = get_post_meta( $order->get_id(), 'settings_tab_info', true );
    if ( $info ) {
        echo '<p><strong>' . _e('Additional Information','web4pro-checkout-step') . '</strong>' . $info . '</p>';
    }
}