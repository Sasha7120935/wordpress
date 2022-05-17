<?php
/*Plugin Name: Web4pro Contact Form City
Description: Sending a City to Different Recipients
Version: 1.0
License: null
*/

add_action( 'wpcf7_before_send_mail', 'web_before_send_mail' );

function web_before_send_mail($contact_form)
{

    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    foreach ( $posted_data['city'] as $item => $key ) {
        if ( $key == '--select--' ) {
            return $contact_form;
        } elseif ( $key == get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'city1', true ) ) {
            $recipient_email = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'email1', true );
        } elseif ( $key == get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'city2', true ) ) {
            $recipient_email = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'email2', true );
        } elseif ( $key == get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'city3', true ) ) {
            $recipient_email = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'email3', true );
        } elseif ( $key == get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'city4', true ) ) {
            $recipient_email = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'email4', true );
        } elseif ( $key == get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'city5', true ) ) {
            $recipient_email = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'email5', true );
        } else {
            return $contact_form;
        }
    }
    $properites = $contact_form->get_properties();
    $properites['mail']['recipient'] .= ', ' . $recipient_email;
    $contact_form->set_properties($properites);
    return ($contact_form);
}

/**
 * Show or do not show custom contact form on page
 */
add_action( 'woocommerce_before_main_content', 'add_field' );
function add_field()
{

    if ( open_field() == 'Yes' ) {
        echo get_field( 'custom_contact', get_option( 'woocommerce_shop_page_id' ) );
    } else {
        echo '';
    }

}

/**
 * @return mixed|void
 */
function open_field()
{
    $field = get_post_meta(get_option( 'woocommerce_shop_page_id' ), 'open_or_close', true );
    foreach ( $field as $item ) {
        return $item;
    }

}
