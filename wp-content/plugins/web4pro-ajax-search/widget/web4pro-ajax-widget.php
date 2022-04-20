<?php
/**
 * Plugin Name: Web4pro Ajax
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
class Web4pro_search extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'true_top_widget',
            'Web4pro Search',
            array('description' => 'Search posts')
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance )
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
            <label>
                <input class="web4pro-date" id="<?php echo $this->get_field_id('date'); ?>"
                       type="date" value="<?php echo get_search_query(); ?>" name="date" required/>
            </label>
            <label>
                <input type="search" class="web4pro-search" id="<?php echo $this->get_field_id('title'); ?>"
                       placeholder="<?php esc_attr_e('Search...', 'Theme_domain'); ?>"
                       value="<?php echo get_search_query(); ?>" name="title" required/>
            </label>
            <input type="hidden" name="action" value="post">
        </form>
        <div id="response"></div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    function form( $instance )
    {
        $defaults = array(
            'title' => 'Post Search',
        );
        $number = @ $instance['number'] ?: '';
        $instance = wp_parse_args((array)$instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'web4pro-events'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo $instance['title']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number') ?>">
                <?php _e( 'Quantity:', 'web4pro-events' ); ?>
            </label>
            <input class="ats-text"
                   id="<?php echo $this->get_field_id('number') ?>"
                   name="<?php echo $this->get_field_name('number') ?>"
                   type="number"
                   step="1"
                   min="1"
                   value="<?php echo absint($number) ?>"
                   size="3"
            />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        return $instance;
    }
}

function register_web4pro_search()
{
    register_widget('Web4pro_search');
}

add_action('widgets_init', 'register_web4pro_search');