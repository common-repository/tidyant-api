<?php

namespace Tidyant_API\Admin\Util;

/**
 * Load admin CSS
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Admin_CSS_Loader implements Assets_Interface
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
            'admin_enqueue_scripts',
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
    public function enqueue() {

        wp_enqueue_style(
            'tidyant-api',
            plugins_url('assets/css/admin.css', dirname(__FILE__)),
            array(),
            filemtime(plugin_dir_path(dirname(__FILE__)) . 'assets/css/admin.css')
        );
    }
}
