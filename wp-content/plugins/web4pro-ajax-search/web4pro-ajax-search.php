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
    $quantity = esc_attr($_POST['number']);
    $title = esc_attr($_POST['title']);
    $date = esc_attr($_POST['date']);
    if ( empty( $date ) || empty( $title ) ) {
        echo '<p>' . _e('Fill in all the fields', 'web4pro-ajax-search') . '</p>';
        die();
    }
        $args = array(
            'orderby' => 'date',
            's' => $title,
            'date_query' => array(
                'after' => $date,
            ),
            'posts_per_page' => $quantity
        );
        ob_start();
        $query = new WP_Query($args);
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                printf(' <a class="link-web4pro" style="text-decoration: none;" href="%s">%s</a>',
                    get_permalink(), esc_html($query->post->post_title)) . '<br>';
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>' . _e('No posts found', 'web4pro-ajax-search') . '</p>';
        endif;
        echo ob_get_clean();
        die();
}

add_action( 'wp_ajax_web4pro_ajax_search', 'web4pro_filters' );
add_action( 'wp_ajax_nopriv_web4pro_ajax_search', 'web4pro_filters' );

/**
 * create scripts
 */
function custom_front_scripts()
{
    wp_enqueue_style('front-css', plugins_url('/css/front-css.css', __FILE__), array(), null, 'all');
    wp_enqueue_script('front-init-js', plugins_url('/js/front.init.js', __FILE__), array('jquery'), null, true,);
    wp_localize_script('front-init-js', 'web4pro', array('url' => admin_url('admin-ajax.php')));
}

add_action( 'wp_enqueue_scripts', 'custom_front_scripts' );