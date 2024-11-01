<?php

namespace Tidyant_API\Admin\Util;

/**
 * Assets interface
 *
 * Defines a common set of functions that any class responsible for loading
 * stylesheets, JavaScript, or other assets should implement.
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
interface Assets_Interface {
    public function init();
    public function enqueue();
}