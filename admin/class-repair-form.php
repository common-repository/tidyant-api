<?php

namespace Tidyant_API\Admin;

use Tidyant_API\Admin\Models\Repair;

/**
 * Manage repair form
 *
 * This class manage the repair form
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Repair_Form
{
    private $repair = null;
    static $instance = false;

    /**
     * Singleton
     * @static
     */
    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new Repair_Form();
        }

        return self::$instance;
    }

    /**
     * Start up
     */
    public function __construct()
    {
        add_filter('the_content', array($this, 'show_form'));
        add_action('init', array($this, 'save_repair'));
    }

    /**
     * Show repair form
     *
     * @param string $content
     *
     * @return string $content
     */
    function show_form($content)
    {
        if (API::init()->isOk()) {
            $repair = $this->repair;
            ob_start();
            require(TIDYANT_PLUGIN_DIR . 'views/repair-form.php');
            $view = ob_get_clean();

            $content = str_replace('{tidyant}', $view, $content);
        } else {
            $content = str_replace('{tidyant}', __('Could not load repair form. Please contact with the administrator ', 'tidyant'), $content);
        }

        return $content;
    }

    /**
     * Save the repair
     *
     * @param void
     *
     * @return void
     */
    function save_repair()
    {
        if ($_REQUEST['action']) {
            if (wp_verify_nonce($_REQUEST['tidyant-security-code'], 'tidyant_save_repair')) {
                $repair = new Repair();
                $repair->setBrand($_POST['tidyant_brand']);
                $repair->setContact($_POST['tidyant_contact']);
                $repair->setEmail($_POST['tidyant_email']);
                $repair->setCity($_POST['tidyant_city']);
                $repair->setPostcode($_POST['tidyant_postcode']);
                $repair->setObservations($_POST['tidyant_observations']);
                $repair->setModel($_POST['tidyant_model']);
                $repair->setName($_POST['tidyant_name']);
                $repair->setIdentifier($_POST['tidyant_identifier']);
                $repair->setBusinessName($_POST['tidyant_business_name']);
                $repair->setAddress($_POST['tidyant_address']);
                $repair->setPhone($_POST['tidyant_phone']);
                if (isset($_FILES["tidyant_picture"])) {
                    $repair->setPictureName($_FILES["tidyant_picture"]["name"]);
                }

                $this->repair = API::init()->storeRepair($repair);

                if ($this->repair) {
                    // Repair was sent
                    $repair->backup(true);

                } else {
                    // Repair could not be sent
                    $repair->backup(false);
                }
            }
        }
    }
}

