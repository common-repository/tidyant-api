<?php

namespace Tidyant_API\Admin;

/**
 * Settings
 *
 * This class manage plugin settings
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Config
{
    static $instance = false;

    private $options;

    /**
     * Singleton
     * @static
     */
    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new Config;
        }

        return self::$instance;
    }

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     *
     * @param void
     *
     * @return void
     */
    public function add_options_page()
    {
        // This page will be under "Settings"
        add_options_page(
            __('Tidyant API settings', 'tidyant'),
            'Tidyant API',
            'manage_options',
            'tidyant-config-admin',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     *
     * @param void
     *
     * @return void
     */
    public function create_admin_page()
    {
        $this->options = get_option('tidyant_api_options');
        ?>
        <div class="wrap">
            <h1>
                <?= __('Tidyant API config', 'tidyant') ?>
            </h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('login_group');
                do_settings_sections('tidyant-config-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     *
     * @param void
     *
     * @return void
     */
    public function page_init()
    {
        register_setting('login_group', 'tidyant_api_options', array($this, 'sanitize'));
        add_settings_section('tidyant-config', __('Main Settings', 'tidyant'), array($this, 'settings_text'), 'tidyant-config-admin');
        add_settings_field('tidyant_api_url_v3', __('Url', 'tidyant'), array($this, 'api_url_v3_callback'), 'tidyant-config-admin', 'tidyant-config', array('label_for' => __('Url', 'tidyant') . ' *'));
        add_settings_field('tidyant_api_tenancy', __('Tenancy', 'tidyant'), array($this, 'api_tenancy_callback'), 'tidyant-config-admin', 'tidyant-config', array('label_for' => __('Tenancy', 'tidyant') . ' *'));
        add_settings_field('tidyant_api_key', __('Key', 'tidyant'), array($this, 'api_key_callback'), 'tidyant-config-admin', 'tidyant-config', array('label_for' => __('Key', 'tidyant') . ' *'));
        -add_settings_field('tidyant_show_repair_link', __('Show go to repair link after save repair', 'tidyant'), array($this, 'show_repair_link_callback'),
            'tidyant-config-admin',
            'tidyant-config'
        );
    }

    /**
     * Add settings text
     *
     * @param void
     *
     * @return void
     */
    function settings_text()
    {
        echo '<p>' . __('Do not forget to add the wildcard {tidyant} on the page or post where you want to show the form', 'tidyant') . '</p>';
        echo '<p>' . __('Put your credentials below. It takes somes seconds to check the credentials, please be patient', 'tidyant') . '</p>';
    }

    /**
     * Api url_v3 callback
     *
     * @param void
     *
     * @return void
     */
    function api_url_v3_callback()
    {
        $options = get_option('tidyant_api_options');
        if (empty($options['api_url_v3'])) {
            $options['api_url_v3'] = 'https://app.tidyant.net';
        }
        echo "<input id='tidyant_api_url_v3' name='tidyant_api_options[api_url_v3]' size='40' type='text' value='{$options['api_url_v3']}' placeholder=\"" . __('Type the url', 'tidyant') . "\"/>";
    }

    /**
     * Api tenancy callback
     *
     * @param void
     *
     * @return void
     */
    function api_tenancy_callback()
    {
        $options = get_option('tidyant_api_options');
        echo "<input id='tidyant_api_tenancy' name='tidyant_api_options[api_tenancy]' size='40' type='text' value='{$options['api_tenancy']}' placeholder=\"" . __('Type your tenancy', 'tidyant') . "\"/>";
    }

    /**
     * Api key callback
     *
     * @param void
     *
     * @return void
     */
    public function api_key_callback()
    {
        printf(
            '<input type="text" id="api_key" name="tidyant_api_options[api_key]" size="40" value="%s" placeholder="' . __('Type your tenancy', 'tidyant') . '"/>',
            isset($this->options['api_key']) ? esc_attr($this->options['api_key']) : ''
        );
    }

    /**
     * Show repair link after save repair
     *
     * @param void
     *
     * @return void
     */
    public function show_repair_link_callback()
    {
        printf('<input type="checkbox" id="show_repair_link" name="tidyant_api_options[show_repair_link]" value="1"' . (($this->options['show_repair_link'] == 1) ? 'checked="checked"' : '') . '/>');
    }

    /**
     * Sanitize and manage settings
     *
     * @param array $input
     *
     * @return array $newInput
     */
    function sanitize($input)
    {
        $newInput['api_tenancy'] = trim($input['api_tenancy']);
        $newInput['api_key'] = trim($input['api_key']);
        $newInput['api_url_v3'] = trim($input['api_url_v3']);

        if (isset($input['show_repair_link'])) {
            $newInput['show_repair_link'] = 1;
        } else {
            $newInput['show_repair_link'] = 0;
        }

        $tenancyOk = $urlOk = $keyOk = false;

        if (!empty($newInput['api_tenancy'])) {
            $newInput['api_tenancy'] = sanitize_text_field($input['api_tenancy']);;
            $tenancyOk = true;
        } else {
            add_settings_error(
                'login_group',
                'required_field',
                __('Tenancy is a required field', 'tidyant'),
                'error'
            );
        }

        if (!empty($newInput['api_key'])) {
            $newInput['api_key'] = sanitize_text_field($input['api_key']);;
            $keyOk = true;
        } else {
            add_settings_error(
                'login_group',
                'required_field',
                __('Key is a required field', 'tidyant'),
                'error'
            );
        }

        if (!empty($newInput['api_url_v3'])) {
            $newInput['api_url_v3'] = sanitize_text_field($input['api_url_v3']);;
            $urlOk = true;
        } else {
            add_settings_error(
                'login_group',
                'required_field',
                __('Url is a required field', 'tidyant'),
                'error'
            );
        }

        if ($tenancyOk == true && $keyOk == true && $urlOk) {
            if (!API::init($newInput['api_key'], $newInput['api_tenancy'], $newInput['api_url_v3'])->checkAPI()) {
                add_settings_error(
                    'login_group',
                    'api_login_error',
                    __('The credentials are wrong, please check that you have the correct credentials', 'tidyant'),
                    'error'
                );
            }
        }

        return $newInput;
    }
}

