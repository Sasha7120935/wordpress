<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');
add_filter( 'template_include', 'woocommerce_archive_template', 99 );

function woocommerce_archive_template( $template ) {

    if ( is_woocommerce() && is_archive() ) {
        $new_template = get_stylesheet_directory() . '/woocommerce/archive-product.php';
        if ( !empty( $new_template ) ) {
            return $new_template;
        }
    }

    return $template;
}

add_action('acf/render_field_settings', 'my_admin_only_render_field_settings');

function my_admin_only_render_field_settings( $field ) {

    acf_render_field_setting( $field, array(
        'label'			=> __('Admin Only?'),
        'instructions'	=> '',
        'name'			=> 'admin_only',
        'type'			=> 'true_false',
        'ui'			=> 1,
    ), true);

}
add_action('acf/render_field_settings/type=textarea', 'my_textarea_render_field_settings');

function my_textarea_render_field_settings( $field ) {

    acf_render_field_setting( $field, array(
        'label'			=> __('Exclude words'),
        'instructions'	=> __('Enter words separated by a comma'),
        'name'			=> 'exclude_words',
        'type'			=> 'text',
    ));

}


// END ENQUEUE PARENT ACTION
