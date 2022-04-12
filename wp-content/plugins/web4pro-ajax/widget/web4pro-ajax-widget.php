<?php

class Web4proAjaxPostsWidget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'true_top_widget',
            'Post Ajax',
            array('description' => 'Allows you to display posts and date')
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']); // к заголовку применяем фильтр (необязательно)
        $posts_per_page = $instance['posts_per_page'];

//        echo $args['before_widget'];

//        if (!empty($title))
//            echo $args['before_title'] . $title . $args['after_title'];

        $q = new WP_Query("posts_per_page=$posts_per_page&orderby=comment_count");
        if ($q->have_posts()):
            ?>
            <ul><?php
            while ($q->have_posts()): $q->the_post();
                ?>
                <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li><?php
            endwhile;
            ?></ul><?php
        endif;
        wp_reset_postdata();

//        echo $args['after_widget'];
    }

    /*
     * бэкэнд виджета
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        if (isset($instance['date'])) {
            $date = $instance['date'];
        }

        if (isset($instance['posts_per_page'])) {
            $posts_per_page = $instance['posts_per_page'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
            <input class="web4pro-title" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('date'); ?>">From date</label>
            <input class="web4pro-date" id="<?php echo $this->get_field_id('date'); ?>"
                   name="<?php echo $this->get_field_name('date'); ?>" type="date"
                   value="<?php echo esc_attr($date); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts_per_page'); ?>">Quantity:</label>
            <input id="<?php echo $this->get_field_id('posts_per_page'); ?>"
                   name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="number"
                   value="<?php echo ($posts_per_page) ? esc_attr($posts_per_page) : '5'; ?>" size="3"/>
        </p>
        <?php
    }

    /*
     * сохранение настроек виджета
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['posts_per_page'] = (is_numeric($new_instance['posts_per_page'])) ? $new_instance['posts_per_page'] : '5'; // по умолчанию выводятся 5 постов
        return $instance;
    }
}

/*
 * регистрация виджета
 */
function true_top_posts_widget_load()
{
    register_widget('Web4proAjaxPostsWidget');
}

add_action('widgets_init', 'true_top_posts_widget_load');