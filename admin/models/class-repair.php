<?php

namespace Tidyant_API\Admin\Models;

/**
 * Repair Model
 *
 * @package  Tidyant_API
 * @author   TidyAnt
 */
class Repair
{
    private $id;
    private $contact;
    private $city;
    private $state;
    private $country;
    private $web;
    private $postcode;
    private $email;
    private $observations;
    private $brand;
    private $model;
    private $name;
    private $identifier;
    private $businessName;
    private $address;
    private $phone;
    private $series;
    private $code;
    private $url;
    private $pictureName;

    function __construct($id = '', $city = '', $state = '', $country = '', $web = '', $postcode = '', $contact = '', $email = '', $observations = '', $brand = '', $model = '', $name = '', $identifier = '', $businessName = '', $address = '', $phone = '', $code = '', $series = '', $url = '', $pictureName = '')
    {
        $this->setId($id);
        $this->setContact($contact);
        $this->setCity($city);
        $this->setCountry($country);
        $this->setState($state);
        $this->setWeb($web);
        $this->setPostcode($postcode);
        $this->setEmail($email);
        $this->setObservations($observations);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setName($name);
        $this->setIdentifier($identifier);
        $this->setBusinessName($businessName);
        $this->setAddress($address);
        $this->setPhone($phone);
        $this->setCode($code);
        $this->setSeries($series);
        $this->setUrl($url);
        $this->setPictureName($pictureName);
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = sanitize_text_field($contact);
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = sanitize_text_field($country);
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = sanitize_text_field($state);
    }

    public function getWeb()
    {
        return $this->web;
    }

    public function setWeb($web)
    {
        $this->web = sanitize_text_field($web);
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = sanitize_text_field($city);
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = sanitize_text_field($postcode);
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = sanitize_text_field($brand);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = sanitize_text_field($email);
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setObservations($observations)
    {
        $this->observations = sanitize_textarea_field($observations);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = sanitize_text_field($model);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = sanitize_text_field($name);
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = sanitize_text_field($identifier);
    }

    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function setBusinessName($businessName)
    {
        $this->businessName = sanitize_text_field($businessName);
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = sanitize_text_field($address);
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = sanitize_text_field($phone);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = sanitize_text_field($code);
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries($series)
    {
        $this->series = sanitize_text_field($series);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = sanitize_text_field($url);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = sanitize_text_field($id);
    }

    public function getPictureName()
    {
        return $this->pictureName;
    }

    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;
    }


    public function getPicture()
    {
        if (isset($_FILES["tidyant_picture"]['tmp_name']) && file_exists($_FILES['tidyant_picture']['tmp_name'])) {
            $_FILES["tidyant_picture"]['data'] = base64_encode(file_get_contents($_FILES["tidyant_picture"]['tmp_name']));
            return $_FILES["tidyant_picture"];
        } else {
            return null;
        }
    }

    public function backup($status)
    {
        global $wpdb;
        $wpdb->insert(TIDYANT_REPAIRS_TABLE, array(
            'repair' => serialize($this),
            'status' => boolval($status)
        ));
    }
}