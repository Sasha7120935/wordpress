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
            esc_html__('Web4pro Search'),
            array('description' => esc_html__('Search posts'))
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        $quantity = isset( $instance['number'] ) ?: '';
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        ?>
            <label>
                <input class="web4pro-date" id="date-web4pro"
                       type="date"  name="date" required/>
            </label>
            <label>
                <input type="text" class="web4pro-search" id="title-web4pro"
                       placeholder="<?php esc_attr_e('Search...', 'web4pro-ajax-search'); ?>"
                        name="title" onkeyup="get_ajax_search()" required/>
            </label>
            <input type="hidden" id="web4pro_filters" value="<?php echo $quantity ?>">
        <div id="response"></div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * @param array $instance
     * @return string|void
     */
    function form( $instance )
    {
        $defaults = array(
            'title' => __('Post Search', 'web4pro-ajax-search'),
        );
        $number = @ $instance['number'] ?: '';
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','web4pro-ajax-search'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo $instance['title']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number') ?>">
                <?php _e( 'Quantity:', 'web4pro-ajax-search' ); ?>
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

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
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

add_action( 'widgets_init', 'register_web4pro_search' );
?>
<style>
    .widget .search-form {
        position: relative;
    }

    /*.widget .web4pro-date {*/
    /*    width: 23%;*/
    /*    border: 2px solid #9d9d9d;*/
    /*    padding: 12px 15px;*/
    /*    padding-right: 15px;*/
    /*    font-size: 14px;*/
    /*}*/
    /*.widget .web4pro-search {*/
    /*    width: 41%;*/
    /*    border: 1px solid #9d9d9d;*/
    /*    padding: 10px 15px;*/
    /*    padding-right: 20px;*/
    /*    font-size: 21px;*/
    /*    font-family: revert;*/
    /*}*/
</style>
