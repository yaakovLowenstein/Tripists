<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Functions extends CI_Controller {

    function getLocationTags() {
        $country = $this->input->post('country');
        $q = $this->input->post('q');
        $location = $this->function_model->getLocationTags($q, $country);
        echo json_encode($location);
    }

    function getContinents() {
        $q = $this->input->get('q');
        $location = $this->function_model->getContinents($q);
        echo json_encode($location);
    }

    function getCountries() {
        $continent = $this->input->post('continent');
        $q = $this->input->post('q');
        $location = $this->function_model->getCountries($q, $continent);
        echo json_encode($location);
    }

    function getStates() {
        $q = $this->input->post('q');
        $location = $this->function_model->getStates($q);
        echo json_encode($location);
    }

    function getUsersForSelect2() {
        $q = $this->input->get('q');
        $location = $this->function_model->getUsersForSelect($q);
        echo json_encode($location);
    }

    function getAttractions() {
        $q = $this->input->post('q');
        $location = $this->function_model->getAttractions($q);
        echo json_encode($location);
    }

    function getRestaurants() {
        $q = $this->input->post('q');
        $location = $this->function_model->getRestaurnats($q);
        echo json_encode($location);
    }

}
