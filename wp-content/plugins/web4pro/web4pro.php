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
$dirname = dirname(__FILE__);
function hcf_display_callback()
{
    include dirname(__FILE__) . '/widget/form.php';
}

include dirname(__FILE__) . '/register-events/web4pro_events_register.php';
include dirname(__FILE__) . '/meta/web4pro_create_meta.php';
include dirname(__FILE__) . '/widget/web4pro_create_widget.php';
include dirname(__FILE__) . '/shortcode/web4pro_create_shortcode.php';