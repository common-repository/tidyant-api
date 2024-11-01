<?php

namespace Tidyant_API\Admin\Util;

/**
 * Load public CSS
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Public_CSS_Loader implements Assets_Interface
{

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     *
     * @param void
     *
     * @return void
     */
    public function init()
    {
        add_action(
            'wp_enqueue_scripts',
            array($this, 'enqueue')
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
        wp_enqueue_style(
            'tidyant-api-public',
            plugins_url('assets/css/public.css', dirname(__FILE__)),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/public.css')
        );

        wp_enqueue_style(
            'tidyant-api-select2',
            plugins_url('assets/css/select2.min.css', dirname(__FILE__)),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/select2.min.css')
        );
    }
}
