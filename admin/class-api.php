<?php

namespace Tidyant_API\Admin;

use Tidyant_API\Admin\Models\Repair;

/**
 * API
 *
 * This class manage all methods to connect to a TidyAnt API
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class API
{
    static $instance = false;

    private $tenancy = null;
    private $key = null;
    private $url = null;
    private $lastError = '';

    /**
     * Start up
     *
     * @param  string $key
     * @param  string $tenancy
     * @param  string $url
     *
     */
    private function __construct($key = null, $tenancy = null, $url = null)
    {
        if ($key != null) {
            $this->key = $key;
        }
        if ($tenancy != null) {
            $this->tenancy = $tenancy;
        }
        if ($url != null) {
            $this->url = $url;
        }
        add_action('rest_api_init', array($this, 'registerAllModelsBrand'));
        add_action('rest_api_init', array($this, 'registerAllBrands'));
    }

    /**
     * Singleton
     *
     * @param  string $key
     * @param  string $tenancy
     * @param  string $url
     *
     * @static
     *
     * @return object
     */
    public static function init($key = null, $tenancy = null, $url = null)
    {
        if (!self::$instance ) {
            self::$instance = new API($key, $tenancy, $url);
        }
        if ($key != null) {
            self::$instance->setKey($key);
        }
        if ($tenancy != null) {
            self::$instance->setTenancy($tenancy);
        }
        if ($url != null) {
            self::$instance->setUrl($url);
        }

        return self::$instance;
    }

    /**
     * Check if the apì tenancy and key was set
     *
     * @param void
     *
     * @return boolean
     */
    private function hasUrlTenancyAndKey()
    {
        if ($this->tenancy != null && $this->key != null && $this->url) {
            return true;
        }

        $options = get_option('tidyant_api_options');
        if ($options) {
            if (!empty($options['api_tenancy']) && !empty($options['api_key']) && !empty($options['api_url_v3'])) {
                $this->tenancy = $options['api_tenancy'];
                $this->key = $options['api_key'];
                $this->url = $options['api_url_v3'];

                return true;
            }
        }

        $this->lastError = __('No tenancy or key! Please check your credentials', 'tidyant');

        return false;
    }

    /**
     * Get all brands form a TidyAnt API
     *
     * This function allow to get all brands from a TidyAnt API
     *
     * @param void
     *
     * @return mixed array $brands or boolean
     */
    public function getAllBrands() {
        if ($this->hasUrlTenancyAndKey()) {
            $response = wp_remote_post($this->URL_ALL_BRANDS, array(
                    'method' => 'GET',
                    'timeout' => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking' => true,
                    'headers' => array('Authorization' => $this->key, 'Tenancy' => $this->tenancy, 'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'),
                    'body' => array(),
                    'cookies' => array()
                )
            );

            if (is_wp_error($response)) {
                $this->lastError = __('Something went wrong, please try again', 'tidyant');
            } else {
                $body = json_decode($response['body']);

                switch ($response['response']['code']) {
                    case 200:
                        $brands = $body->data;
                        return $brands;
                        break;
                    case 401:
                        $this->lastError = __('Unauthorized! Please check your credentials', 'tidyant');
                        break;
                    case 403:
                        $this->lastError = __('Forbidden! Please check your allowed ip list', 'tidyant');
                        break;
                    default:
                        $this->lastError = $response['response']['code'] . ': ' . __('Unexpected error. Please contact with the administrator', 'tidyant');
                }

                if ($body->error) {
                    $this->lastError = serialize($body->error);
                }
            }
        }

        return false;
    }

    /**
     * Get all models for a given brand form a TidyAnt API
     *
     * This function allow to get all models for a given brand from a TidyAnt API
     *
     * @param int $brandId
     *
     * @return mixed array $models or boolean
     */
    private function getAllModelsBrand($brandId)
    {
        if (is_numeric($brandId)) {
            if ($this->hasUrlTenancyAndKey()) {
                $response = wp_remote_post($this->URL_ALL_MODELS_BRAND . $brandId . '/models', array(
                        'method' => 'GET',
                        'timeout' => 45,
                        'redirection' => 5,
                        'httpversion' => '1.0',
                        'blocking' => true,
                        'headers' => array('Authorization' => $this->key, 'Tenancy' => $this->tenancy, 'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'),
                        'body' => array(),
                        'cookies' => array()
                    )
                );

                if (is_wp_error($response)) {
                    $this->lastError = __('Something went wrong, please try again', 'tidyant');
                } else {
                    $body = json_decode($response['body']);

                    switch ($response['response']['code']) {
                        case 200:
                            $models = $body->data;
                            return $models;
                            break;
                        case 401:
                            $this->lastError = __('Unauthorized! Please check your credentials', 'tidyant');
                            break;
                        case 403:
                            $this->lastError = __('Forbidden! Please check your allowed ip list', 'tidyant');
                            break;
                        default:
                            $this->lastError = $response['response']['code'] . ': ' . __('Unexpected error. Please contact with the administrator', 'tidyant');
                    }
                    if ($body->error) {
                        $this->lastError = serialize($body->error);
                    }
                }
            }
        } else {
            $this->lastError(__('Invalid brand id', 'tidyant'));
        }


        return false;
    }

    /**
     * Store a repair into a TidyAnt API
     *
     * This function allow to store a repair into a TidyAnt API
     *
     * @param Repair $repair
     *
     * @return mixed Repair $repair of boolean
     */
    public function storeRepair(Repair $repair)
    {
        $url = $this->URL_STORE_REPAIR;
        if ($this->hasUrlTenancyAndKey()) {
            $repairData = array(
                'brand' => $repair->getBrand(),
                'email' => $repair->getEmail(),
                'observations' => $repair->getObservations(),
                'model' => $repair->getModel(),
                'name' => $repair->getName(),
                'city' => $repair->getCity(),
                'postcode' => $repair->getPostcode(),
                'state' => $repair->getState(),
                'country' => $repair->getCountry(),
                'web' => $repair->getWeb(),
                'contact' => $repair->getContact(),
                'identifier' => $repair->getIdentifier(),
                'business_name' => $repair->getBusinessName(),
                'address' => $repair->getAddress(),
                'phone' => $repair->getPhone(),
                'attachments' => $repair->getPicture()
            );

            $args = array(
                'timeout' => 90,
                'method' => 'POST',
                'headers' => array(
                    'Authorization' => $this->key,
                    'Tenancy' => $this->tenancy
                ),
                'body' => $repairData,
                'sslverify' => false
            );

            $response = wp_remote_request($url, $args);

            if (is_wp_error($response)) {
                $this->lastError = __('Something went wrong, please try again', 'tidyant');
            } else {
                $body = json_decode($response['body']);
                switch ($response['response']['code']) {
                    case 201:
                        $repair->setId($body->data->id);
                        $repair->setSeries($body->data->series);
                        $repair->setCode($body->data->code);
                        $repair->setUrl($body->data->url);
                        return $repair;
                        break;
                    case 401:
                        $this->lastError = __('Unauthorized! Please check your credentials', 'tidyant');
                        break;
                    case 403:
                        $this->lastError = __('Forbidden! Please check your allowed ip list', 'tidyant');
                        break;
                    default:
                        $this->lastError = $response['response']['code'] . ': ' . __('Unexpected error. Please contact with the administrator', 'tidyant');
                }
                if ($body->error) {
                    $this->lastError = serialize($body->error);
                }
            }
        }
        return false;
    }

    /**
     * Magic method for get constants
     *
     * @param string $constName
     *
     * @return string $val or null
     */
    public function __get($constName){
        // Null for non-defined "constants"
        $val = null;
        switch($constName){
            case 'URL_LOGIN':
                $val = $this->url . '/api/v3/login';
                break;
            case 'URL_ALL_BRANDS':
                $val = $this->url . '/api/v3/brands?sort=+name&page=1&limit=1000';
                break;
            case 'URL_STORE_REPAIR':
                $val = $this->url . '/api/v3/repairs';
                break;
            case 'URL_ALL_MODELS_BRAND':
                $val = $this->url . '/api/v3/brands/';
                break;
        }

        return $val;
    }

    /**
     * Check if the api has tenancy and key
     *
     * @param void
     *
     * @return boolean
     */
    public function isOk()
    {
        if ($this->hasUrlTenancyAndKey()) {
            return true;
        }

        return false;
    }

    /**
     * Check if the API can connect
     *
     * @param void
     *
     * @return boolean
     */
    public function checkAPI()
    {
        if ($this->isOk()) {
            if ($this->getAllBrands() != false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get last API error
     *
     * @param void
     *
     * @return string last error description
     */
    public function getLastError() {
        $lastError = $this->lastError;
        $this->lastError = '';
        return $lastError;
    }

    /**
     * Register the rest route
     *
     * This function register a local route for get all models by brand
     *
     * @param void
     *
     * @return void
     */
    function registerAllModelsBrand()
    {
        register_rest_route('tidyant-api/v3/brands', '(?P<id>\d+)/models/', array(
            'methods' => 'GET',
            'callback' => array($this, 'localAllModelsBrand')
        ));
    }

    /**
     * Register the rest route
     *
     * This function register a local route for get all brands
     *
     * @param void
     *
     * @return void
     */
    function registerAllBrands()
    {
        register_rest_route('tidyant-api/v3/brands', '/all/', array(
            'methods' => 'GET',
            'callback' => array($this, 'localAllBrands')
        ));
    }

    /**
     * Get the request and resend to the TidyAnt API
     *
     * This function resend the request from local API to TidyAnt API
     *
     * @param object $request http request
     *
     * @return string JSON with select2 format
     */
    function localAllBrands($request)
    {
        $brands = $this->getAllBrands();
        $brands['text'] = $brands['name'];
        $newBrands = array();
        foreach ($brands as $brand) {
            $newBrands[] = array('id' => $brand->id, 'text' => $brand->name);
        }

        header('Content-Type: application/json');

        return json_decode(json_encode(array('results' => $newBrands)));
    }

    /**
     * Get the request and resend to the TidyAnt API
     *
     * This function resend the request from local API to TidyAnt API
     *
     * @param object $request http request
     *
     * @return string JSON with select2 format
     */
    function localAllModelsBrand($request)
    {
        $brandId = $request->get_param('id');
        $models = $this->getAllModelsBrand($brandId);
        header('Content-Type: application/json');

        return json_decode(json_encode(array('results' => $models)));
    }

    /**
     * Set the tenancy
     *
     * This function set the tenancy, note that the tenancy is not saved in options field
     *
     * @param string $tenancy
     *
     * @return void
     */
    function setTenancy($tenancy)
    {
        $this->tenancy = $tenancy;
    }

    /**
     * Set the key
     *
     * This function set the key, note that the key is not saved in options field
     *
     * @param string $key
     *
     * @return void
     */
    function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Set the url
     *
     * This function set the url, note that the url is not saved in options field
     *
     * @param string $url
     *
     * @return void
     */
    function setUrl($url)
    {
        $this->url = $url;
    }
}