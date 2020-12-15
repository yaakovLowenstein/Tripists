<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Functions extends CI_Controller {

    function getLocationTags() {
        $q = $this->input->get('q');
        $location = $this->function_model->getLocationTags($q);
        echo json_encode($location);
    }

    function getUsersForSelect2() {
        $q = $this->input->get('q');
        $location = $this->function_model->getUsersForSelect($q);
        echo json_encode($location);
    }

}
