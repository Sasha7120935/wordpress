<?php
/*Plugin Name: Web4pro Page Filter
Description: This plugin filtering records in Page.
Version: 1.0
License: null
*/
$dirname = dirname(__FILE__);
function hcf_callback()
{
    include dirname(__FILE__) . '/form.php';
}


function hcf_register_meta_boxes_web4pro()
{
    add_meta_box('hcf-1', __('City', 'hcf'), 'hcf_callback', 'filter');
}

add_action('add_meta_boxes', 'hcf_register_meta_boxes_web4pro');
/**
 * Save meta box content.
 *
 * @param int $event_id
 */
function hcf_save_meta_box_web4pro( $event_id )
{
    $fields = [
        'hcf_event_web4pro',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists ( $field, $_POST ) ) {
            update_post_meta ( $event_id, $field, sanitize_text_field($_POST[$field] ) );
        }
    }
}

add_action( 'save_post', 'hcf_save_meta_box_web4pro') ;
/**
 * @param $atts
 * @return string
 */
function get_web4pro_filter( $atts )
{
    ?>
    <form action="" method="POST">
        <label class="title-nav"><?php _e('Title', 'web4pro-page-filter'); ?></label>
        <input class="wide-title" type="text" name="title-web4pro" id="title-web4pro"/>
        <label class="title-nav"><?php _e('City', 'web4pro-page-filter'); ?></label>
        <select name="city-web4pro" id="city-web4pro" class="wide-city">
            <?php
            $options = array(
                '' => __('Select', 'web4pro-events'),
                'mariupol' => __('Mariupol', 'web4pro-events'),
                'kiev' => __('Kiev', 'web4pro-events'),
                'kharkov' => __('Kharkov', 'web4pro-events')
            );
            foreach ( $options as $key => $name ) {
                echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" ' . selected( $key, false) . '>' . $name . '</option>';
            }
            ?>
        </select>
        <label class="title-nav"><?php _e('Category', 'web4pro-page-filter'); ?></label>
        <select name="category-web4pro" id="category-web4pro" class="wide-category">
            <?php
            if ( $terms = get_terms( array ( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) :
                foreach ( $terms as $term ) :
                    echo '<option value="' . $term->name . '">' . $term->name . '</option>'; // ID of the category as the value of an option
                endforeach;
            endif;
            ?>
        </select>
        <label>
            <input type="radio" name="date" value="ASC"/><?php _e('Date:Ascending', 'web4pro-page-filter');?>
        </label>
        <label>
            <input type="radio" name="date" value="DESC" selected="selected"/><?php _e('Date:Descending', 'web4pro-page-filter');?>
        </label>
        <button class="city-button" type="submit" name="city-button"><?php _e('Filter', 'web4pro-page-filter');?></button>
        <input type="hidden" name="action" value="web4pro-page-filter">
    </form>
    <?php
    $category = esc_attr( $_POST['category-web4pro'] );
    $city = esc_attr( $_POST['city-web4pro'] );
    $title = esc_attr( $_POST['title-web4pro'] );
    $date = esc_attr( $_POST['date'] );
    if ( ! empty ( $city ) && ! empty ( $category ) && ! empty ( $date ) && ! empty ( $title ) ) {
        $args = [
            'post_type' => 'filter',
            'orderby' => 'date',
            'order' => $date,
            's' => $title,
            'category_name' => $category,
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => 'hcf_event_web4pro',
                    'value' => $city,
                ]
            ]
        ];
        $events_query = new WP_Query( $args );
        if ( $events_query->have_posts() ) :
            while ( $events_query->have_posts() ) : $events_query->the_post();
                $return_string .= '<div class="row"><div class="column"><p>' . get_the_title() . ' <br>' . get_the_date() . '<br>' . get_the_post_thumbnail() . get_the_category_list() . '</p> </div></div>';
            endwhile;
        else:
            return '<p><strong>' . _e('not found', 'web4pro-page-filter') . '</strong></p>';
        endif;
        wp_reset_query();
        return $return_string;
    } else {
        return '<p>' . _e('Fill in all the fields', 'web4pro-page-filter') . '</p>';
    }
}
add_shortcode('filter', 'get_web4pro_filter');
/**
 * create scripts
 */
wp_enqueue_style( 'web4pro-front-css', plugins_url( '/css/style.css' ,__FILE__), array(), null );
?>


