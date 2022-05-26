<?php
/*Plugin Name: Web4pro Contact Form City
Description: Sending a City to Different Recipients
Version: 1.0
License: null
*/

add_action('wpcf7_before_send_mail', 'web_before_send_mail');
/**
 * @param $contact_form
 * @return mixed
 */
function web_before_send_mail( $contact_form )
{
    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    $posts = get_field('contact_form_web', get_option('woocommerce_shop_page_id') );
    if ( $posts ):
        while ( the_repeater_field('client', get_option('woocommerce_shop_page_id') ) ):
            foreach ( $posted_data['city'] as $item => $key ) {
                for ( $i = $sub_field_cite = get_sub_field('city'); $i == $key; $i++ ) {
                    if ( $key == $sub_field_cite ) {
                        $recipient_email = get_sub_field('email');
                        break;
                    } else {
                        return $contact_form;
                    }
                }
            }
        endwhile;
    endif;
    $properites = $contact_form->get_properties();
    $properites['mail']['recipient'] .= ', ' . $recipient_email;
    $contact_form->set_properties($properites);
    return ($contact_form);
}

/**
 *  add function anywhere to child theme woocommerce storefront addContactForm() in archive-product.php
 */
function addContactForm(){
    $posts = get_field('contact_form_web', get_option('woocommerce_shop_page_id'));
  if ( $posts ) :
        foreach ( $posts as $p ) :
            $cf7_id = $p->ID;
        echo  do_shortcode('[contact-form-7 id="' . $cf7_id . '" ]');
        endforeach;
    endif;
}
