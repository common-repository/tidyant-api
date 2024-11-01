<?php

namespace Tidyant_API\Admin;

/**
 * TidyAnt core class
 *
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Tidyant
{
    static $instance = false;

    /**
     * Singleton
     * @static
     */
    public static function init() {
        if ( ! self::$instance ) {
            self::$instance = new Tidyant;
        }

        return self::$instance;
    }

    /**
     * Install table for backup repairs
     *
     * @param void
     *
     * @return void
     */
    public static function installDb()
    {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = 'CREATE TABLE IF NOT EXISTS ' . TIDYANT_REPAIRS_TABLE . ' (
            id INT NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            repair text NOT NULL,
            status boolean DEFAULT 0,
            PRIMARY KEY  (id)
        ) ' . $charset_collate;

        $wpdb->query($sql);
    }

    /**
     * Remove table for backup repairs
     *
     * @param void
     *
     * @return void
     */
    public static function dropDb()
    {
        global $wpdb;

        $sql = 'DROP TABLE IF EXISTS ' . TIDYANT_REPAIRS_TABLE;

        $wpdb->query($sql);
    }

    /**
     * Check show_repair_link value
     *
     * @param void
     *
     * @return boolean
     */
    public static function showRepairLink()
    {
        $options = get_option('tidyant_api_options');
        if ($options['show_repair_link'] == 1) {
            return true;
        }

        return false;
    }
}