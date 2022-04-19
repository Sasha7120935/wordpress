<?php
/**
 * Plugin Name: Web4pro
 * Plugin URI: https://wordpress.com/
 * Description: An Web4pro toolkit that helps you sell anything. Beautifully.
 * Version: 6.3.1
 * Author: Automattic
 * Author URI: https://wordpress.com/
 * Text Domain:
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.0
 *
 * @package Web4pro
 */
$event = esc_attr(get_post_meta(get_the_ID(), 'hcf_event', true));
?>
<div class="hcf_box">
    <style scoped>
        .hcf_box {
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }

        .hcf_field {
            display: contents;
        }
    </style>
    <p class="meta-options hcf_field">
        <label for="hcf_published_date"><?php _e( 'Date', 'web4pro-events') ?></label>
        <input id="hcf_published_date"
               type="date"
               name="hcf_published_date"
               value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'hcf_published_date', true)); ?>" required>
    </p>
    <p class="meta-options hcf_field">
        <label for="hcf_event"><?php _e( 'Status','web4pro-events'); ?></label>
        <select id="hcf_event"
                name="hcf_event">
            <option value="free" <?php echo ($event === 'free') ? ' selected' : ''; ?>><?php _e( 'Free', 'web4pro-events' ); ?></option>
            <option value="by_invitation" <?php echo ($event === 'by_invitation') ? ' selected' : ''; ?>><?php _e( 'By Invitation', 'web4pro-events' ); ?>
            </option>
        </select required>
    </p>
</div>