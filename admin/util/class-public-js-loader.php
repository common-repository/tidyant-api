<?php

namespace Tidyant_API\Admin\Util;

/**
 * Load admin js
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Public_Js_Loader implements Assets_Interface
{

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     *
     * @param void
     *
     * @return void
     */
    public function init() {
        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue' )
        );
    }

    /**
     * Defines the functionality responsible for loading the file.
     *
     * @param void
     *
     * @return void
     */
    public function enqueue()
    {

        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'jquery-validate',
            plugins_url('assets/js/jquery.validate.min.js', dirname(__FILE__)),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/js/jquery.validate.min.js')
        );

        wp_enqueue_script(
            'select-2',
            plugins_url('assets/js/select2.min.js', dirname(__FILE__)),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/js/select2.min.js')
        );

        // Register the script
        wp_register_script(
            'tidyant-api-public',
            plugins_url( 'assets/js/public.js', dirname( __FILE__ ) ),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/js/public.js')
        );

        // Localize the script with new data
        $translation_array = array(
            'mandatory_field' => __('Mandatory field', 'tidyant'),
            'incorrect_email' => __('The email address is not valid', 'tidyant'),
            'incorrect_phone' => __('The phone is not valid. It must begin with + and contain only digits', 'tidyant'),
            'select_brand' => __('Please select a brand', 'tidyant'),
            'select_model' => __('Please select or create a model', 'tidyant'),
            'new' => __('New', 'tidyant'),
            'input_too_short' => __('Input too short', 'tidyant'),
            'no_results' => __('No results', 'tidyant'),
            'searching' => __('Searching', 'tidyant'),
            'loading_more' => __('Loading more', 'tidyant'),
            'loading_brands' => __('Loading brands', 'tidyant'),
            'error_loading' => __('Wait a second, we are loading the models', 'tidyant')
        );
        wp_localize_script('tidyant-api-public', 'trans', $translation_array);

        // Enqueued script with localized data.
        wp_enqueue_script('tidyant-api-public');
    }
}
