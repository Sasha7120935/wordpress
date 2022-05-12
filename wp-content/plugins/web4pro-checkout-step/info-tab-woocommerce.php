<?php

class WC_Settings_Tab_Info
{

    public static function init()
    {
        add_filter('woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50);
        add_action('woocommerce_settings_tabs_settings_tab_info', __CLASS__ . '::settings_tab');
        add_action('woocommerce_update_options_settings_tab_info', __CLASS__ . '::update_settings');
    }

    public static function add_settings_tab($settings_tabs)
    {
        $settings_tabs['settings_tab_info'] = __('Additional info', 'woocommerce-settings-tab-info');
        return $settings_tabs;
    }

    public static function settings_tab()
    {
        woocommerce_admin_fields(self::get_settings());
    }

    public static function update_settings()
    {
        woocommerce_update_options(self::get_settings());
    }

    public static function get_settings()
    {

        $settings = array(
            'description' => array(
                'type' => 'textarea',
                'id' => 'wc_settings_tab_info_description'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_info_section_end'
            )
        );

        return apply_filters('wc_settings_tab_info_settings', $settings);
    }

}

WC_Settings_Tab_Info::init();