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
 * Adding a new widget Events_Widget.
 */
class Events_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'events_widget',
            esc_html__('Events'),
            array('description' => esc_html__('Shows the status of the post'))
        );

    }

    /**
     * Displaying a Widget in the Front End
     *
     * @param array $args widget arguments.
     * @param array $instance saved data from settings
     */
    function widget( $args, $instance )
    {
        $status = isset( $instance['status'] ) ?: '';
        $quantity = isset( $instance['quantity'] ) ?: '';

        echo recent_posts_function($instance);

    }

    /**
     * Widget admin part
     *
     * @param array $instance saved data from settings
     */
    function form( $instance )
    {
        $quantity = @ $instance['quantity'] ?: '';
        $status = @ $instance['status'] ?: '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('status') ?>"><?php _e('Status', 'web4pro-events'); ?></label>
            <select name="<?php echo $this->get_field_name('status'); ?>"
                    id="<?php echo $this->get_field_id('status'); ?>" class="widefat">
                <?php
                $options = array(
                    '' => __('Select', 'web4pro-events'),
                    'free' => __('Free', 'web4pro-events'),
                    'by_invitation' => __('By Invitation', 'web4pro-events')
                );
                foreach ( $options as $key => $name ) {
                    echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" ' . selected($status, $key, false) . '>' . $name . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('quantity') ?>">
                <?php _e('Quantity:', 'web4pro-events'); ?>
            </label>
            <input class="tiny-text"
                   id="<?php echo $this->get_field_id('quantity') ?>"
                   name="<?php echo $this->get_field_name('quantity') ?>"
                   type="number"
                   step="1"
                   min="1"
                   value="<?php echo absint($quantity) ?>"
                   size="3"
            />
        </p>
        <?php
    }

    /**
     * Saving widget settings. Here the data needs to be cleaned up and returned to save it to the database.
     *
     * @param array $new_instance new settings
     * @param array $old_instance previous settings
     *
     * @return array data to be saved
     * @see WP_Widget::update()
     *
     */
    function update( $new_instance, $old_instance )
    {
        $instance = array();
        $instance['quantity'] = (!empty($new_instance['quantity'])) ? sanitize_text_field($new_instance['quantity']) : '';
        $instance['status'] = isset($new_instance['status']) ? sanitize_text_field($new_instance['status']) : '';
        return $instance;
    }

}

function register_events_widget()
{
    register_widget('Events_Widget');
}

add_action('widgets_init', 'register_events_widget');