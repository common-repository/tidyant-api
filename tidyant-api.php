<?php
/**
 * Plugin Name:       TidyAnt API
 * Plugin URI:        https://www.tidyant.com/plugins/wordpress
 * Description:       TidyAnt API repair form
 * Version:           1.1.4
 * Author:            TidyAnt
 * Author URI:        https://www.tidyant.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tidyant
 * Domain Path:       /languages
 */

namespace Tidyant_API;

use Tidyant_API\Admin\API;
use Tidyant_API\Admin\Banner;
use Tidyant_API\Admin\Config;
use Tidyant_API\Admin\Repair_Form;
use Tidyant_API\Admin\Util\Admin_CSS_Loader;
use Tidyant_API\Admin\Util\Public_CSS_Loader;
use Tidyant_API\Admin\Util\Public_Js_Loader;

// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

global $wpdb;

define('TIDYANT_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('TIDYANT_REPAIRS_TABLE', $wpdb->base_prefix . "tidyant_api_repairs");
define('TIDYANT_PLUGIN_VERSION', '1.1.4');

// Include the autoloader so we can dynamically include the rest of the classes.
require_once( trailingslashit( dirname( __FILE__ ) ) . 'include/autoloader.php' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\tidyant_api' );
load_plugin_textdomain('tidyant', false, basename( dirname( __FILE__ ) ) . '/languages' );

register_activation_hook(__FILE__, array('Tidyant_API\Admin\Tidyant', 'installDb'));
register_deactivation_hook(__FILE__, array('Tidyant_API\Admin\Tidyant', 'dropDb'));

function tidyant_api()
{
    if (is_admin()) {
        Config::init();
    }

    API::init();

    $public_js_loader = new Public_Js_Loader();
    $public_js_loader->init();

    $public_css_loader = new Public_CSS_Loader();
    $public_css_loader->init();

    Repair_Form::init();

    $admin_css_loader = new Admin_CSS_Loader();
    $admin_css_loader->init();

    if (!API::init()->checkAPI()) {
        Banner::init();
    }
}



