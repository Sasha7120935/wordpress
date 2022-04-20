<?php
/**
 * Plugin Name: Web4pro Ajax Search
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
include dirname(__FILE__) . '/widget/web4pro-ajax-widget.php';

/**
 * create function for receiving ajax
 */
function web4pro_filters()
{
    $title = array(
        'title' => esc_attr($_POST['title']));
    $args = array(
        'orderby' => 'date',
        's' => esc_attr($_POST['title']),
        'date_query' => array(
        'after' => esc_attr($_POST['date']),
        ),
    );
    ob_start();
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            printf(' <a class="link-web4pro" style="text-decoration: none;" href="%s">%s</a>',
                get_permalink(), esc_html($query->post->post_title)) . '<br>';
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p><strong>' . _e('No posts found', 'web4pro-ajax-search') . '</strong></p>';
    endif;
    echo ob_get_clean();
    die();
}

add_action('wp_ajax_web4pro_filters', 'web4pro_filters');
add_action('wp_ajax_nopriv_web4pro_filters', 'web4pro_filters');

/**
 * create scripts
 */
function custom_front_scripts()
{
    wp_enqueue_style('front-css', plugins_url('/css/front-css.css', __FILE__), array(), null, 'all');
    wp_enqueue_script('front-init', plugins_url('/js/front.init.js', __FILE__), array('jquery'), null, true,);
    wp_localize_script('front-init', 'web4pro_filters', array('url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'custom_front_scripts');