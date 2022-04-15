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
 * Добавление нового виджета Foo_Widget.
 */
class Foo_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'foo_widget',
            'Events',
            array('description' => 'My Widget', /*'classname' => 'my_widget',*/)
        );

        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'add_my_widget_scripts'));
            add_action('wp_head', array($this, 'add_my_widget_style'));
        }
    }

    /**
     * Вывод виджета во Фронт-энде
     *
     * @param array $args аргументы виджета.
     * @param array $instance сохраненные данные из настроек
     */
    function widget($args, $instance)
    {
        $select = isset($instance['select']) ? $instance['select'] : '';
        $number = isset($instance['number']) ? $instance['number'] : '';
        $atts = [
            'post_type' => 'events',
            'meta_query' => [['key' => 'hcf_event', 'value' => $instance['select']]],
            'posts_per_page' => $instance['number']
        ];
        $events_query = new WP_Query($atts);
        foreach ($events_query as $pst) {
            echo esc_html($pst->post_title) . ' ' . esc_html($pst->post_date);
        }
    }

    /**
     * Админ-часть виджета
     *
     * @param array $instance сохраненные данные из настроек
     */
    function form($instance)
    {
        $number = @ $instance['number'] ?: '';
        $select = @ $instance['select'] ?: '';
        ?>
        <p>
            <label for="<?= $this->get_field_id('select') ?>">Status</label>
            <select name="<?php echo $this->get_field_name('select'); ?>"
                    id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
                <?php
                $options = array(
                    '' => __('Select', 'text_domain'),
                    'free' => __('Free', 'text_domain'),
                    'by_invitation' => __('By Invitation', 'text_domain')
                );
                foreach ($options as $key => $name) {
                    echo '<option value="' . esc_attr($key) . '" id="' . esc_attr($key) . '" ' . selected($select, $key, false) . '>' . $name . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?= $this->get_field_id('number') ?>">
                Quantity:
            </label>
            <input class="tiny-text"
                   id="<?= $this->get_field_id('number') ?>"
                   name="<?= $this->get_field_name('number') ?>"
                   type="number"
                   step="1"
                   min="1"
                   value="<?= absint($number) ?>"
                   size="3"
            />
        </p>
        <?php
    }

    /**
     * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
     *
     * @param array $new_instance новые настройки
     * @param array $old_instance предыдущие настройки
     *
     * @return array данные которые будут сохранены
     * @see WP_Widget::update()
     *
     */
    function update($new_instance, $old_instance)
    {
        $instance = array();

        $instance['number'] = (!empty($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
        $instance['select'] = isset($new_instance['select']) ? wp_strip_all_tags($new_instance['select']) : '';

        return $instance;
    }

    function add_my_widget_scripts()
    {
        if (!apply_filters('show_my_widget_script', true, $this->id_base))
            return;

        $theme_url = get_stylesheet_directory_uri();

        wp_enqueue_script('my_widget_script', $theme_url . '/my_widget_script.js');
    }

    function add_my_widget_style()
    {
        if (!apply_filters('show_my_widget_style', true, $this->id_base))
            return;
        ?>
        <style type="text/css">
            .my_widget a {
                display: inline;
            }
        </style>
        <?php
    }

}
function register_foo_widget()
{
    register_widget('Foo_Widget');
}

add_action('widgets_init', 'register_foo_widget');