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
            array('description' => esc_html__('Shows the status of the post'), )
        );

        if ( is_active_widget(false, false, $this->id_base ) || is_customize_preview() ) {
            add_action('wp_head', array($this, 'add_widget_style'));
        }
    }

    /**
     * Displaying a Widget in the Front End
     *
     * @param array $args widget arguments.
     * @param array $instance saved data from settings
     */
    function widget( $args, $instance )
    {
        $select = isset( $instance['select'] ) ? : '';
        $number = isset( $instance['number'] ) ? : '';
        $args = [
            'post_type' => 'events',
            'meta_query' => [['key' => 'hcf_event', 'value' => $instance['select']]],
            'posts_per_page' => $instance['number']
        ];
        $events_query = new WP_Query( $args );
        foreach ( $events_query as $value ) {
            echo esc_html($value->post_title) . ' ' . esc_html($value->post_date);
        }
    }

    function events_search()
    {

    }

    /**
     * Widget admin part
     *
     * @param array $instance saved data from settings
     */
    function form( $instance )
    {
        $number = @ $instance['number'] ?: '';
        $select = @ $instance['select'] ?: '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('select') ?>"><?php _e( 'Status', 'web4pro-events' ); ?></label>
            <select name="<?php echo $this->get_field_name('select'); ?>"
                    id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
                <?php
                $options = array(
                    '' => __('Select', 'web4pro-events'),
                    'free' => __('Free', 'web4pro-events'),
                    'by_invitation' => __('By Invitation', 'web4pro-events')
                );
                foreach ( $options as $key => $name ) {
                    echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" ' . selected($select, $key, false) . '>' . $name . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number') ?>">
                <?php _e( 'Quantity:', 'web4pro-events' ); ?>
            </label>
            <input class="tiny-text"
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

        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? sanitize_text_field( $new_instance['number'] ) : '';
        $instance['select'] = isset( $new_instance['select'] ) ? sanitize_text_field( $new_instance['select'] ) : '';

        return $instance;
    }
    function add_widget_style()
    {
        if ( !apply_filters( 'show_widget_style', true, $this->id_base ) ) {
            return;
        }
        ?>
        <style type="text/css">
            .my_widget a {
                display: inline;
            }
        </style>
        <?php
    }

}

function register_events_widget()
{
    register_widget('Events_Widget');
}

add_action('widgets_init', 'register_events_widget');