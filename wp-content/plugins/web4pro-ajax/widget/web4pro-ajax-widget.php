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

        $title = isset($instance['title']) ? $instance['title'] : '';
        $date = isset($instance['date']) ? $instance['date'] : '';
        $posts_per_page = $instance['posts_per_page'];
        $atts = [
            'post_type' => 'post',
            'orderby' => 'comment_count',
            'title' => $instance['title'],
            'posts_per_page' => $instance['posts_per_page'],
            'date_query' => array(
                'after' => '2021-11-04',
                'before' => $date
            ),
        ];
        $post_query = new WP_Query($atts);
        if ($post_query->have_posts()):
            ?>
            <ul><?php
            while ($post_query->have_posts()): $post_query->the_post();
                ?>
                <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><br></li><?php
            endwhile;
            ?></ul><?php
        endif;
        wp_reset_postdata();

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
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
               let v = $('#widget-true_top_widget-14-title').on('change', function (event) {
                    event.preventDefault();
                    let val = $(this).val();
                    $.ajax({
                        url: '/wp-admin/widgets.php', // сделали запрос
                        type: "POST", // указали метод
                        data: { // передаем параметры отправляемого запроса
                            action: 'my_ajax_action', // вызываем хук который обработает наш ajax запрос
                            name: val, // передаем параметры из кнопки
                        },
                        success: function (data) {// получаем результат в переменной data
                        }
                    });
                });
            });
        </script>
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
        $instance['date'] = (!empty($new_instance['date'])) ? strip_tags($new_instance['date']) : '';
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