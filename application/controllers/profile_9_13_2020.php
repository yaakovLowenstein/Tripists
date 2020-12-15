<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {

    private $user = null;

    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }
        $this->load->model('profile_model');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {

        $data['main_content'] = 'site/profile/profile.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsList() {

        $data['main_content'] = 'site/profile/blogs/blogs.php';
        $this->load->view('lib-site/template', $data);
    }

    public function unsetBlogId() {
        print_r('asfd');
        die;
        $this->session->unset_userdata('blog_id');
        echo json_encode();
    }

    public function blogsAddEditOverview($blogId = null) {
        $data["blogId"] = $blogId;
        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('title', 'Title of trip', 'trim|required');

            if ($this->form_validation->run()) {
                $inputData = array(
                    'user_id' => $this->user->id,
                    'blog_title' => $this->input->post('title', true)
                );
                if ($blogId == null) {
                    $blogId = $this->profile_model->insertIntoTable('blog', $inputData);
                } else {
                    $this->profile_model->updateTable('blog', $inputData);
                }
            }
            if (isset($blogId)) {
                $this->session->set_flashdata('mess', 'Insert successfull');

                redirect('profile/blogs/add/summary/' . $blogId, 'refresh');
            } else
                $this->session->set_flashdata('mess', 'Insert not successfull');
        }

        $data['getSummaryData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);

        // $this->session->sess_destroy('blog_id');
        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_overview.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditSummary($blogId = null) {
        if ($blogId != null) {
            $data["blogId"] = $blogId;
            if ($this->input->post('submit')) {
//                $this->form_validation->set_rules('title', 'Title of trip', 'trim|required');
                $this->form_validation->set_rules('cities[]', 'Cities', 'trim');
                $this->form_validation->set_rules('locations[]', 'Location Tags', 'trim|required');
                $this->form_validation->set_rules('dates', 'Dates', 'trim|required');
                $this->form_validation->set_rules('summary', 'Summary', 'trim|required');


                if ($this->form_validation->run()) {
                    $inputData = array(
//                    'user_id' => $this->user->id,
//                        'blog_title' => $this->input->post('title', true),
                        'blog_dates' => $this->input->post('dates', true),
                        'blog_summary' => $this->input->post('summary', true),
                    );
                    $cities = $this->input->post('cities', true);
                    $locations = $this->input->post('locations', true);

                    //for add new so id is null
//                if ($blogId == null) {
//                    $blogId = $this->profile_model->insertBlog('blog', $inputData);
//                    $success = $this->insertIntoCitiesAndLocationsAndTheirBlogTables($blogId, $cities, $locations);
                    //*****for updatind data when editing*******
//                } else
                    if ($blogId != null) {
                        $success = $this->profile_model->updateTable('blog', $inputData);
                        $success = $success ? $this->deleteOldCitiesAndLocations($blogId) : $success;
                        $success = $success ? $this->insertIntoCitiesAndLocationsAndTheirBlogTables($blogId, $cities, $locations) : $success;
                    }

                    if (isset($success) && $success && $blogId) {
                        $this->session->set_flashdata('mess', 'Insert successfull');

                        redirect('profile/blogs/add/attractions/' . $blogId, 'refresh');
                    } else
                        $this->session->set_flashdata('mess', 'Insert not successfull');
                }
            }
//************for editing to display previously entered data****************
//            else if ($blogId != null) {
            $data['getSummaryData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);
            if (!empty($data['getSummaryData'])) {
                $data['getSummaryDataLocations'] = $this->profile_model->getSummaryDataLocations($blogId);
                $data['getSummaryDataCities'] = $this->profile_model->getSummaryDataCities($blogId);
//                } else {
//                    redirect('profile/blogs/add/summary', 'refresh');
//                }
            }
//********************end**********************
            $data['main_content'] = 'site/profile/blogs/blogs_add_edit_summary.php';
            $this->load->view('lib-site/template', $data);
        } else {
            $this->session->set_flashdata('mess', 'Cannot Access until you set a title for your blog');
            redirect('profile/blogs/add/overview', 'refresh');
        }
    }

    public function blogsAddEditAttractions($blogId = null) {
        //todo - for locations need to change around method so i can pass in table (prob should do same for cities)----basically some refactoring
        //then can just call same method and pass in table name
        //and need to add to begining of method get data then check if not empty then update not insert
        
//        if ($blogId != null) {
//            $data['getAttrData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);
//            if (!empty($data['getAttrData'])) {
//              //  $data['getSummaryDataLocations'] = $this->profile_model->getSummaryDataLocations($blogId);
//               // $data['getSummaryDataCities'] = $this->profile_model->getSummaryDataCities($blogId);
//            } else {
//                redirect('profile/blogs/add/summary', 'refresh');
//            }
//        } else
                  //  $data['getAttractionData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);

        if ($blogId != null) {
            $data["blogId"] = $blogId;
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('locations[]', 'Location', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
                if ($this->form_validation->run()) {

                    $inputData = array(
                        'attr_name' => $this->input->post('name', true),
                    );
                    $locations = $this->input->post('locations[]', true);
                    //$locations = $this->input->post('locations', true);
                    //for add new so id is null
//                    if ($blogId == null) {
//                    echo "<script>alert('Sorry cannot submit until fill out summary tab')</script>";
                        //$blogId = $this->profile_model->insertBlog('blog', $inputData);
                        //$success = $this->insertIntoCitiesAndLocationsAndTheirBlogTables($blogId, $cities, $locations);
                        //*****for updatind data when editing*******
//                    } else 
                        if ($blogId != null) {
                        $inputData['blog_id'] = $blogId;
                        $success = $this->profile_model->insertIntoTable('blog_attractions', $inputData);


//                        $success = $this->profile_model->updateBlog('blog', $inputData);
//                        $success = $success ? $this->deleteOldCitiesAndLocations($blogId) : $success;
//                        $success = $success ? $this->insertIntoCitiesAndLocationsAndTheirBlogTables($blogId, $cities, $locations) : $success;
                    }

                    if (isset($success) && $success && $blogId) {
                        $this->session->set_flashdata('mess', 'Insert successfull');

                        redirect('profile/blogs/add/attractions/' . $blogId, 'refresh');
                    } else
                        $this->session->set_flashdata('mess', 'Insert not successfull');
                }
            }
            // $data['getCities'] = $this->function_model->getCities();


            $data['main_content'] = 'site/profile/blogs/blogs_add_edit_attractions.php';
            $this->load->view('lib-site/template', $data);
        }else {
            $this->session->set_flashdata('mess', 'Cannot Access until you set a title for your blog');
            redirect('profile/blogs/add/overview', 'refresh');
        }
    }

    public function blogsAddEditRestaurants() {
        if ($this->input->post('submit')) {
            
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_restaurants.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditBestParts() {
        if ($this->input->post('submit')) {
            
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_best_parts.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditWorstParts() {
        if ($this->input->post('submit')) {
            
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_worst_parts.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditPhotos() {
        if ($this->input->post('submit')) {
            
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_photos.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditAdivce() {
        if ($this->input->post('submit')) {
            
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_advice.php';
        $this->load->view('lib-site/template', $data);
    }

    public function getCities() {
        $q = $this->input->get('q');
        $citi = $this->function_model->getCities($q);
        echo json_encode($citi);
    }

    public function getLocationTags() {
        $q = $this->input->get('q');
        $location = $this->function_model->getLocationTags($q);
        echo json_encode($location);
    }

    private function deleteOldCitiesAndLocations($blogId) {

        $this->profile_model->deleteById($blogId);
        $this->profile_model->deleteBlogLocationsById($blogId);
        return true;
    }

    private function insertIntoCitiesAndLocationsAndTheirBlogTables($blogId, $cities, $locations) {
        if ($blogId) {
            if (!empty($cities)) {
                // print_r($cities);die;
                $success = $this->determineIfOldAndNewCitiesAndInsertIntoDB($blogId, $cities);
            }
            if (!empty($locations)) {
                // print_r($cities);die;
                $success = $this->determineIfOldAndNewLocationsAndInsertIntoDB($blogId, $locations);
            }
        }
        return $success;
    }

    private function determineIfOldAndNewCitiesAndInsertIntoDB($blogId, $cities) {
        //initialize arrays
        $oldCitiIds = array();
        $newCities = array();
        $citiIds = array();
        $newCitiIds = array();
        //run through the cities that were inputted and determine if old ones or new ones or both
        foreach ($cities as $citi) {
            if (is_numeric($citi)) {
                array_push($oldCitiIds, $citi);
            } else {
                array_push($newCities, $citi);
            }
        }
        //if there are new cities then will input them into cities table
        if (!empty($newCities)) {
            foreach ($newCities as $citi) {
                $data[] = array(
                    'citi_name' => $citi
                );
            }
            $citiInsertReturnData = $this->profile_model->insertValues($data);
            $numberOfNewCities = $citiInsertReturnData['affectedRows'];
            $insertId = $citiInsertReturnData['insertId'];
            /* after inputting them - I return the id and number of rows and then
              create new array of the citi ids that just inserted into cities table */
            for ($i = 0; $i < $numberOfNewCities; $i++) {
                array_push($newCitiIds, $insertId + $i);
            }
            //if there are also old cities merge the 2 arrays
            if (!empty($oldCitiIds)) {
                $citiIds = array_merge($newCitiIds, $oldCitiIds);
            } else {
                $citiIds = $newCitiIds;
            }
        }
        //if there are no new citis then only need to add the old citi ids
        else {
            $citiIds = $oldCitiIds;
        }
        //create the array that will insert into the blog_cities table
        foreach ($citiIds as $id) {
            $CitBlogdata[] = array(
                'blog_id' => $blogId,
                'citi_id' => $id
            );
        }
        //return true if successfull input
        $success = $this->profile_model->insertBatch($CitBlogdata);
        return $success;
    }

    //for laziness left everything as citi but really is "location"
    private function determineIfOldAndNewLocationsAndInsertIntoDB($blogId, $cities) {
        //initialize arrays
        $oldCitiIds = array();
        $newCities = array();
        $citiIds = array();
        $newCitiIds = array();
        //run through the cities that were inputted and determine if old ones or new ones or both
        foreach ($cities as $citi) {
            if (is_numeric($citi)) {
                array_push($oldCitiIds, $citi);
            } else {
                array_push($newCities, $citi);
            }
        }
        //if there are new cities then will input them into cities table
        if (!empty($newCities)) {
            foreach ($newCities as $citi) {
                $data[] = array(
                    'location_tags_name' => $citi
                );
            }
            $citiInsertReturnData = $this->profile_model->insertLocations($data);
            $numberOfNewCities = $citiInsertReturnData['affectedRows'];
            $insertId = $citiInsertReturnData['insertId'];
            /* after inputting them - I return the id and number of rows and then
              create new array of the citi ids that just inserted into cities table */
            for ($i = 0; $i < $numberOfNewCities; $i++) {
                array_push($newCitiIds, $insertId + $i);
            }
            //if there are also old cities merge the 2 arrays
            if (!empty($oldCitiIds)) {
                $citiIds = array_merge($newCitiIds, $oldCitiIds);
            } else {
                $citiIds = $newCitiIds;
            }
        }
        //if there are no new citis then only need to add the old citi ids
        else {
            $citiIds = $oldCitiIds;
        }
        //create the array that will insert into the blog_cities table
        foreach ($citiIds as $id) {
            $CitBlogdata[] = array(
                'blog_id' => $blogId,
                'location_id' => $id
            );
        }
        //return true if successfull input
        $success = $this->profile_model->insertLocationsIntoCitiBlog($CitBlogdata);
        return $success;
    }

}
