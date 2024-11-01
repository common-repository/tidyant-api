<?php

namespace Tidyant_API\Admin;

/**
 * Configuration banner
 *
 * Show the config banner
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Banner
{

    private static $instance = null;

    /**
     * Start up
     */
    private function __construct()
    {
        add_action('current_screen', array($this, 'maybe_initialize_hooks'));
    }

    /**
     * Singleton
     * @static
     */
    static function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Banner();
        }

        return self::$instance;
    }

    /**
     * Add an admin notice at plugin's page
     *
     * @param void
     *
     * @return void
     */
    function maybe_initialize_hooks()
    {
        global $pagenow;

        if ($pagenow == 'plugins.php') {
            add_action('admin_notices', array($this, 'render_banner'));
        }
    }

    /**
     * Render the banner
     *
     * @param void
     *
     * @return void
     */
    function render_banner()
    {
        require(TIDYANT_PLUGIN_DIR . 'views/config-banner.php');
    }
}
