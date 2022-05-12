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
$event = esc_attr(get_post_meta(get_the_ID(), 'hcf_event_web4pro', true));
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
        <select id="hcf_event_web4pro"
                name="hcf_event_web4pro">
            <option value=""><?php _e( 'Select', 'web4pro-page-filter' ); ?></option>
            <option value="mariupol" <?php echo ($event === 'mariupol') ? ' selected' : ''; ?>><?php _e( 'Mariupol', 'web4pro-page-filter' ); ?></option>
            <option value="kiev" <?php echo ($event === 'kiev') ? ' selected' : ''; ?>><?php _e( 'Kiev', 'web4pro-page-filter' ); ?></option>
            <option value="kharkov" <?php echo ($event === 'kharkov') ? ' selected' : ''; ?>><?php _e( 'Kharkov', 'web4pro-page-filter' ); ?></option>
        </select required>
    </p>
</div>