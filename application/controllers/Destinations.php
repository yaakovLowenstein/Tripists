<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations extends CI_Controller {

    private $user = null;

    function __construct() {
        parent::__construct();
        $this->load->model('destinations_model');
    }

    public function destinationsMap() {
        $data["getBlogCountries"] = $this->destinations_model->getBlogCountries();



        $data['main_content'] = 'site/destinations/destinations_map.php';
        $this->load->view('lib-site/template', $data);
    }

    public function destinationsList() {
        $data["getBlogCountries"] = $this->destinations_model->getBlogCountriesWithoutStates();
        $data["getBlogsInUSA"] = $this->destinations_model->getBlogsInUSA();

        $data['main_content'] = 'site/destinations/destinations_list.php';
        $this->load->view('lib-site/template', $data);
    }

}
