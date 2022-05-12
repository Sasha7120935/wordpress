<?php
/*Plugin Name: Web4pro Contact Form City
Description: Sending a City to Different Recipients
Version: 1.0
License: null
*/

add_action( 'wpcf7_before_send_mail', 'web_before_send_mail' );

function web_before_send_mail( $contact_form )
{

    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    foreach ( $posted_data['city'] as $item => $key ) {
        if ( $key == 'Kharkov' ) {
            $recipient_email =  add_email();
        } elseif ( $key == 'Kiev' ) {
            $recipient_email =  add_email();
        } elseif ( $key == 'Dnepr' ) {
            $recipient_email =  add_email();
        } elseif ( $key == 'Sumy' ) {
            $recipient_email =  add_email();
        } elseif ( $key == 'Mariupol' ) {
            $recipient_email =  add_email();
        } else {
            return $contact_form;
        }
    }
    $properites = $contact_form->get_properties();
    $properites['mail']['recipient'] .= ', ' . $recipient_email;

    $contact_form->set_properties( $properites );
    return ( $contact_form );
}
function add_email(){
    $email = 'test@gmail.com';
    return $email;
}