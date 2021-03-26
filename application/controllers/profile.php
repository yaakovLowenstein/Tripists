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
        $data['getProfileData'] = $this->profile_model->getProfileData($this->user->id);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');



            if ($this->form_validation->run()) {

                $config['upload_path'] = './uploads/profile_pics';
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                // $config["max_size"] = 1024;
                // $config["max_width"] = 400;
                // $config["max_height"] = 400;
                $path = '';
                $newName = time() . '_' . $_FILES["profile_pic"]['name'];
                $config['file_name'] = $newName;
                $this->upload->initialize($config);
                // $this->upload->do_upload('profile_pic');
                if (!$this->upload->do_upload('profile_pic')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                } else {
                    $dataInfo[] = $this->upload->data();
                    // print_r($dataInfo);die;
                    $path = $dataInfo[0]['full_path'];
                    $path = substr($path, strpos($path, 'uploads/profile_pics'));
                }
                if ($path == '' && !empty($data['getProfileData']->profile_pic_path)) {
                    $path = $data['getProfileData']->profile_pic_path;
                    //   print_r('sdg');die;
                }

                //  }
                $inserData = array(
                    'username' => $this->input->post('username'),
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'about' => $this->input->post('about'),
                    'website' => $this->input->post('website'),
                    'facebook' => $this->input->post('facebook'),
                    'twitter' => $this->input->post('twitter'),
                    'youtube' => $this->input->post('youtube'),
                    'instagram' => $this->input->post('instagram'),
                    'profile_pic_path' => $path,
                    'continent_from' => $this->input->post('continent_from'),
                    'country_from' => $this->input->post('country_from'),
                    'state_from' => $this->input->post('state_from'),
                    'city' => $this->input->post('city')
                );

                $setWhere = array('id' => $this->user->id);

                $success = $this->profile_model->updateTable('users', $inserData, $setWhere);
                if ($success) {
                    redirect('profile/index', 'refresh');
                }
            }
        }



        $data['main_content'] = 'site/profile/profile.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsList() {
        //print_r($this->user);die;
        if ($this->input->get('view_all')) {
            redirect('profile/blogs/', 'refresh');
            //$this->input->get('title') = '';
        }
        $query = '';
        $searchstring = array();
        // if ($this->input->get('search')) {
        if (($this->input->get('title') != '')) {
            $searchstring['title'] = $this->input->get('title');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'title=' . $this->input->get('title');
        }
        if (($this->input->get('dates') != '')) {
            $searchstring['dates'] = $this->input->get('dates');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'dates=' . $this->input->get('dates');
        }
        //  if (($this->input->get('published') != '--------Select----------') && ($this->input->get('published') != '')) {
        //    $searchstring['published'] = $this->input->get('published') == 'Published' ? 1 : $this->input->get('published') == 'Not Published' ? '0' : '';
        if (($this->input->get('published') == '1')) {
            $searchstring['published'] = 1;
        } else if (($this->input->get('published') == '0')) {
            $searchstring['published'] = 0;
        }
        if ($query != '') {
            $query .= '&';
        }
        $query .= 'published=' . $this->input->get('published');
        //   }   
        if (($this->input->get('locations') != '')) {
            $searchstring['locations'] = $this->input->get('locations');
            foreach ($searchstring['locations'] as $id) {
                $query .= 'locations%5B%5D=' . $id . '&';
            }

            $idsArrays = $this->function_model->locationSearch($searchstring);
            $blogIds = array();
            foreach ($idsArrays as $id) {
                array_push($blogIds, $id->blog_id);
            }

            $searchstring['blog_ids'] = $blogIds;
            $searchstring['locations'] = $this->function_model->getLocationTagsId($searchstring['locations']);
        }
        $data['searchstring'] = $searchstring;

        $this->load->library('pagination');

        $count = $this->profile_model->getBlogCount($this->user->id, $searchstring);

        $config['total_rows'] = $count;
        $config['per_page'] = 20;
        $url = 'profile/blogs';
        if (!empty($query)) {
            $url .= '?' . $query;
        }
        $config['base_url'] = base_url($url); //. 'profile/blogs' . $query;
        $config['page_query_string'] = TRUE;
        $config["uri_segment"] = 3;
        $config["num_links"] = 3;
        $config['first_tag_open'] = '<div class="page">';
        $config['first_tag_close'] = '</div>';
        $config['last_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="page">';
        $config['last_link'] = '>>';
        $config['first_link'] = '<<';
        $config['next_tag_open'] = '<div class="page">';
        $config['next_tag_close'] = '</div>';
        $config['prev_tag_open'] = '<div class="page">';
        $config['prev_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="page">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '<div class="page">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="page">';
        $config['cur_tag_close'] = '</div>';

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;

        $data['getAllBLogsByUser'] = $this->profile_model->getAllBLogsByUser($config["per_page"], $page, $this->user->id, $searchstring);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

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
        $data['getSummaryData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);
        $data["blogId"] = $blogId;
        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('title', 'Title of Blog', 'trim|required');

            if ($this->form_validation->run()) {

                $config['upload_path'] = './uploads/cover_pics';
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                // $config["max_size"] = 1024;
                // $config["max_width"] = 400;
                // $config["max_height"] = 400;
                $path = '';
                $newName = time() . '_' . $_FILES["cover_pic"]['name'];
                $config['file_name'] = $newName;
                $this->upload->initialize($config);
                // $this->upload->do_upload('profile_pic');
                if (!$this->upload->do_upload('cover_pic')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                } else {
                    $dataInfo[] = $this->upload->data();
                    // print_r($dataInfo);die;
                    $path = $dataInfo[0]['full_path'];
                    $path = substr($path, strpos($path, 'uploads/cover_pics'));
                }
                if ($path == '' && !empty($data['getSummaryData']->cover_pic_path)) {
                    $path = $data['getSummaryData']->cover_pic_path;
                    //   print_r('sdg');die;
                }


                $inputData = array(
                    'user_id' => $this->user->id,
                    'blog_title' => $this->input->post('title', true),
                    'cover_pic_path' => $path
                );
                if ($blogId == null) {
                    $success = $blogId = $this->profile_model->insertIntoTable('blog', $inputData);
                } else {
                    $success = $this->profile_model->updateTable('blog', $inputData, $setWhere);
                }
            }
            if (isset($success) && $success && $blogId) {
                $this->session->set_flashdata('mess', 'Insert successfull');

                redirect('profile/blogs/add/summary/' . $blogId, 'refresh');
            }
            //    die;
        }

        if ($blogId != null) {
            $this->checkUser($data['getSummaryData'], $blogId);
        }
        // $this->session->sess_destroy('blog_id');
        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_overview.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditSummary($blogId = null) {
        $this->checkIfBlogExists($blogId);

        $data["blogId"] = $blogId;
        $data['isPublished'] = $this->function_model->getPublished($blogId);
        // print_r($data['isPublished']);die;
        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {
//                $this->form_validation->set_rules('title', 'Title of trip', 'trim|required');
            //$this->form_validation->set_rules('cities[]', 'Cities', 'trim');
            $this->form_validation->set_rules('continent', 'Continent', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('locations[]', 'Location Tags', 'trim|required');
            $this->form_validation->set_rules('dates', 'Dates', 'trim|required');
            $this->form_validation->set_rules('summary', 'Summary', 'trim|required');
            if ($this->input->post('country', true) == '230') {
                $this->form_validation->set_rules('state', 'State', 'trim|required');
            }

            if ($this->form_validation->run()) {
                $inputData = array(
//                    'user_id' => $this->user->id,
//                        'blog_title' => $this->input->post('title', true),

                    'continent' => $this->input->post('continent', true),
                    'country' => $this->input->post('country', true),
                    'state' => $this->input->post('state', true),
                    'blog_dates' => $this->input->post('dates', true),
                    'blog_summary' => $this->input->post('summary', true),
                );
                $cities = $this->input->post('cities', true);
                $locations = $this->input->post('locations', true);

                $success = $this->profile_model->updateTable('blog', $inputData, $setWhere);
                //$success = $success ? $this->deleteById('blog_cities', $blogId) : $success;
                $success = $success ? $this->deleteById('blog_locations', $blogId) : $success;
                $success = $success ? $this->processMultiInputs($blogId, $cities, $locations) : $success;


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
            //$data['getSummaryDataCities'] = $this->profile_model->getSummaryDataCities($blogId);
//                } else {
//                    redirect('profile/blogs/add/summary', 'refresh');
//                }
        }
        $this->checkUser($data['getSummaryData'], $blogId);

//********************end**********************
        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_summary.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditAttractions($blogId = null) {
        $this->checkIfBlogExists($blogId);
        $data['getAttractionsData'] = $this->profile_model->getAttractionsData($blogId, $this->user->id);
        if (!empty($data['getAttractionsData'])) {
            $data['getAttractionsLocations'] = $this->profile_model->getAttractionsLocations($blogId);
        }
        $this->checkUser($data['getAttractionsData'], $blogId);
        $data['isPublished'] = $this->function_model->getPublished($blogId);

        $data["blogId"] = $blogId;
        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('attractions', 'Name', 'trim|required');
            $this->form_validation->set_rules('locations[]', 'Location', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            if ($this->form_validation->run()) {
                $attrId = $this->determineNewItemsFromSelect2AndInsert('attractions', "attr_name", $this->input->post('attractions', true));
                $inputData = array(
                    'attr_id' => $attrId,
                    'attr_description' => $this->input->post('description', true)
                );
                $locations = $this->input->post('locations[]', true);
                if ($blogId != null && empty($data['getAttractionsData'])) {
                    $inputData['blog_id'] = $blogId;
                    $success = $this->profile_model->insertIntoTable('blog_attractions', $inputData);
                    $success = $success ? $this->determingNewAndOldValuesOfMultiInputsAndInsertIntoBlogTables('blog_attractions_locations', 'location_tags', $blogId, $locations) : $success;
                } else if (!empty($data['getAttractionsData'])) {
                    $inputData['blog_id'] = $blogId;
                    $success = $this->profile_model->updateTable('blog_attractions', $inputData, $setWhere);
                    $success = $success ? $this->deleteById('blog_attractions_locations', $blogId) : $success;
                    $success = $success ? $this->determingNewAndOldValuesOfMultiInputsAndInsertIntoBlogTables('blog_attractions_locations', 'location_tags', $blogId, $locations) : $success;
                }

                if (isset($success) && $success && $blogId) {
                    $this->session->set_flashdata('mess', 'Insert successfull');

                    redirect('profile/blogs/add/restaurants/' . $blogId, 'refresh');
                } else
                    $this->session->set_flashdata('mess', 'Insert not successfull');
            } else
                $this->session->set_flashdata('mess', 'Error - There are required fields below left blank.');
        }
        // $data['getCities'] = $this->function_model->getCities();


        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_attractions.php';
        $this->load->view('lib-site/template', $data);
    }

//    public function restaurantValidation() {
//       $name =  $this->input->post('name');
//       if ($name=='a'){
//           $this->session->set_flashdata('in_err', 'reaquired');
//       }
////$this->form_validation->set_rules('rest_name[]', 'Name', 'trim|required');
//       // $this->form_validation->set_rules('rest_city[]', 'Location', 'trim|required');
//       // $this->form_validation->set_rules('rest_description[]', 'Description', 'trim|required');
//        
//        echo json_encode("success");
//    }

    public function blogsAddEditRestaurants($blogId = null) {
        //todo - figure out the update/insert thing - it is always inserting - I probably need to pass in the id for it to update by

        $this->checkIfBlogExists($blogId);
        $data['getRestaurantData'] = $this->profile_model->getRestaurantData($blogId, $this->user->id);
        $this->checkUser($data['getRestaurantData'], $blogId);

        $data['isPublished'] = $this->function_model->getPublished($blogId);

        $data["blogId"] = $blogId;
        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('rest_name[]', 'Name', 'trim|required');
//            $this->form_validation->set_rules('rest_city[]', 'Location', 'trim|required');
            $this->form_validation->set_rules('rest_description[]', 'Description', 'trim|required');


            if ($this->form_validation->run()) {
                $names = $this->input->post('rest_name[]', true);
                $descriptions = $this->input->post('rest_description[]', true);
                $locations = $this->input->post('locations[]', true);
//                $cities = $this->input->post('rest_city[]', true);
//                $restCities = $this->determineIfNewOrOldCitySingle($cities);
//to do need to set up this method for cities then finish with the insert(easy part) then need to figure out how to do edit 
                //  $citiesWithIdAndName = $this->function_model->getCityID($restCities);

                if (empty($data['getRestaurantData'])) {
                    //print_r('dfg');die;
                    for ($i = 0; $i < sizeof($names); $i++) {
                        $insertData[] = array(
                            //'blog_restaurants_id'=> 23,
                            'rest_id' => $this->determineNewItemsFromSelect2AndInsert("restaurants", "rest_name", $names[$i]),
                            'description' => $descriptions[$i],
                            'location_id' => $this->determineNewItemsFromSelect2AndInsert("location_tags", "location_tags_name", $locations[$i]),
                            'blog_id' => $blogId
                        );
                    }
                    $success = $this->profile_model->insertBatch('blog_restaurants', $insertData);
                } else if (!empty($data['getRestaurantData'])) {
                    for ($i = 0; $i < sizeof($names); $i++) {
                        if (!empty($data['getRestaurantData'][$i]['blog_restaurants_id'])) {
                            $updateData[] = array(
                                'blog_restaurants_id' => $data['getRestaurantData'][$i]['blog_restaurants_id'],
                                'rest_id' => $this->determineNewItemsFromSelect2AndInsert("restaurants", "rest_name", $names[$i]),
                                'description' => $descriptions[$i],
                                'location_id' => $this->determineNewItemsFromSelect2AndInsert("location_tags", "location_tags_name", $locations[$i]),
                                'blog_id' => $blogId
                            );
                        } else {
                            //print_r("sdfg");die;
                            $insertData[] = array(
                                //'blog_restaurants_id'=> 23,
                                'rest_id' => $this->determineNewItemsFromSelect2AndInsert("restaurants", "rest_name", $names[$i]),
                                'description' => $descriptions[$i],
                                'description' => $descriptions[$i],
                                'location_id' => $this->determineNewItemsFromSelect2AndInsert("location_tags", "location_tags_name", $locations[$i]),
                                'blog_id' => $blogId
                            );
                        }
                    }
                    $success = $this->profile_model->updateBatch('blog_restaurants', $updateData, 'blog_restaurants_id');
                    if (!empty($insertData)) {
                        //  print_r("sdfg");die;
                        $success = $this->profile_model->insertBatch('blog_restaurants', $insertData);
                    }
                }
                //print_r(sizeof($names) . " " . sizeof($data['getRestaurantData']));
                if (sizeof($names) < sizeof($data['getRestaurantData'])) {
                    $deleteArray = array();
                    for ($i = sizeof($names) - 1; $i < sizeof($data['getRestaurantData']) - sizeof($names); $i++) {
                        array_push($deleteArray, $data['getRestaurantData'][$i]['blog_restaurants_id']);
                    }
                    $success = $this->profile_model->deleteMultipleById('blog_restaurants', $deleteArray, 'blog_restaurants_id');
                }

                if (isset($success) && $success && $blogId) {

                    $this->session->set_flashdata('mess', 'Insert successfull');

                    redirect('profile/blogs/add/best_day/' . $blogId, 'refresh');
                } else
                    $this->session->set_flashdata('mess', 'Insert not successfull');
            }
        }

        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_restaurants.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditBestDay($blogId = null) {
        $this->checkIfBlogExists($blogId);
        $data['getBestDayData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);
        $this->checkUser($data['getBestDayData'], $blogId);
        $data["blogId"] = $blogId;
        $data['isPublished'] = $this->function_model->getPublished($blogId);

        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {
            $inputData = array(
                'best_day' => $this->input->post('best_day', true)
            );
            $success = $this->profile_model->updateTable('blog', $inputData, $setWhere);
        }


        if (isset($success) && $success && $blogId) {

            $this->session->set_flashdata('mess', 'Insert successfull');

            redirect('profile/blogs/add/advice/' . $blogId, 'refresh');
        } else {
            $this->session->set_flashdata('mess', 'Insert not successfull');
        }

        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_best_day.php';
        $this->load->view('lib-site/template', $data);
    }

//    public function blogsAddEditWorstParts($blogId = null) {
//        $this->checkIfBlogExists($blogId);
//        $data['getWorstPartsData'] = $this->profile_model->getWorstPartsData($blogId, $this->user->id);
//        $this->checkUser($data['getWorstPartsData'], $blogId);
//        $data['isPublished'] = $this->function_model->getPublished($blogId);
//
//
//        $data["blogId"] = $blogId;
//        $setWhere = array('blog_id' => $blogId);
//
//        if ($this->input->post('submit')) {
//            $this->form_validation->set_rules('name[]', 'Name', 'trim|required');
//            $this->form_validation->set_rules('description[]', 'Location', 'trim|required');
//            // $this->form_validation->set_rules('rest_description[]', 'Description', 'trim|required');
//
//
//            if ($this->form_validation->run()) {
//                $names = $this->input->post('name[]', true);
//                $descriptions = $this->input->post('description[]', true);
//                // $cities = $this->input->post('rest_city[]', true);
//                //  $restCities = $this->determineIfNewOrOldCitySingle($cities);
////to do need to set up this method for cities then finish with the insert(easy part) then need to figure out how to do edit 
//                //  $citiesWithIdAndName = $this->function_model->getCityID($restCities);
//
//                if (empty($data['getWorstPartsData'])) {
//                    //print_r('dfg');die;
//                    for ($i = 0; $i < sizeof($names); $i++) {
//                        $insertData[] = array(
//                            //'blog_restaurants_id'=> 23,
//                            'name' => $names[$i],
//                            'description' => $descriptions[$i],
//                            //  'city' => $restCities[$i],
//                            'blog_id' => $blogId
//                        );
//                    }
//                    $success = $this->profile_model->insertBatch('blog_worst_parts', $insertData);
//                } else if (!empty($data['getWorstPartsData'])) {
//                    for ($i = 0; $i < sizeof($names); $i++) {
//                        if (!empty($data['getWorstPartsData'][$i]['blog_worst_parts_id'])) {
//                            $updateData[] = array(
//                                'blog_worst_parts_id' => $data['getWorstPartsData'][$i]['blog_worst_parts_id'],
//                                'name' => $names[$i],
//                                'description' => $descriptions[$i],
//                                // 'city' => $restCities[$i],
//                                'blog_id' => $blogId
//                            );
//                        } else {
//                            //print_r("sdfg");die;
//                            $insertData[] = array(
//                                //'blog_restaurants_id'=> 23,
//                                'name' => $names[$i],
//                                'description' => $descriptions[$i],
//                                // 'city' => $restCities[$i],
//                                'blog_id' => $blogId
//                            );
//                        }
//                    }
//                    $success = $this->profile_model->updateBatch('blog_worst_parts', $updateData, 'blog_worst_parts_id');
//                    if (!empty($insertData)) {
//                        //  print_r("sdfg");die;
//                        $success = $this->profile_model->insertBatch('blog_worst_parts', $insertData);
//                    }
//                }
//                if (isset($success) && $success && $blogId) {
//
//                    $this->session->set_flashdata('mess', 'Insert successfull');
//
//                    redirect('profile/blogs/add/worst_parts/' . $blogId, 'refresh');
//                } else
//                    $this->session->set_flashdata('mess', 'Insert not successfull');
//            }
//        }
//
//
//        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_worst_parts.php';
//        $this->load->view('lib-site/template', $data);
//    }

    public function blogsAddEditAdivce($blogId = null) {
        $this->checkIfBlogExists($blogId);
        $data['getAdviceData'] = $this->profile_model->getAdviceData($blogId, $this->user->id);
        $this->checkUser($data['getAdviceData'], $blogId);

        $data['isPublished'] = $this->function_model->getPublished($blogId);

        $data["blogId"] = $blogId;
        $setWhere = array('blog_id' => $blogId);

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name[]', 'Name', 'trim|required');
            $this->form_validation->set_rules('description[]', 'Location', 'trim|required');
            // $this->form_validation->set_rules('rest_description[]', 'Description', 'trim|required');


            if ($this->form_validation->run()) {
                $names = $this->input->post('name[]', true);
                $descriptions = $this->input->post('description[]', true);
                // $cities = $this->input->post('rest_city[]', true);
                //  $restCities = $this->determineIfNewOrOldCitySingle($cities);
//to do need to set up this method for cities then finish with the insert(easy part) then need to figure out how to do edit 
                //  $citiesWithIdAndName = $this->function_model->getCityID($restCities);

                if (empty($data['getAdviceData'])) {
                    //print_r('dfg');die;
                    for ($i = 0; $i < sizeof($names); $i++) {
                        $insertData[] = array(
                            //'blog_restaurants_id'=> 23,
                            'name' => $names[$i],
                            'description' => $descriptions[$i],
                            //  'city' => $restCities[$i],
                            'blog_id' => $blogId
                        );
                    }
                    $success = $this->profile_model->insertBatch('blog_advice', $insertData);
                } else if (!empty($data['getAdviceData'])) {
                    for ($i = 0; $i < sizeof($names); $i++) {
                        if (!empty($data['getAdviceData'][$i]['blog_advice_id'])) {
                            $updateData[] = array(
                                'blog_advice_id' => $data['getAdviceData'][$i]['blog_advice_id'],
                                'name' => $names[$i],
                                'description' => $descriptions[$i],
                                // 'city' => $restCities[$i],
                                'blog_id' => $blogId
                            );
                        } else {
                            //print_r("sdfg");die;
                            $insertData[] = array(
                                //'blog_restaurants_id'=> 23,
                                'name' => $names[$i],
                                'description' => $descriptions[$i],
                                // 'city' => $restCities[$i],
                                'blog_id' => $blogId
                            );
                        }
                    }
                    $success = $this->profile_model->updateBatch('blog_advice', $updateData, 'blog_advice_id');
                    if (!empty($insertData)) {
                        //  print_r("sdfg");die;
                        $success = $this->profile_model->insertBatch('blog_advice', $insertData);
                    }
                    if (sizeof($names) < sizeof($data['getAdviceData'])) {
                        $deleteArray = array();
                        for ($i = sizeof($names) - 1; $i < sizeof($data['getAdviceData']) - sizeof($names); $i++) {
                            array_push($deleteArray, $data['getAdviceData'][$i]['blog_advice_id']);
                        }
                        $success = $this->profile_model->deleteMultipleById('blog_advice', $deleteArray, 'blog_advice_id');
                    }
                }
                if (isset($success) && $success && $blogId) {

                    $this->session->set_flashdata('mess', 'Insert successfull');

                    redirect('profile/blogs/add/photos/' . $blogId, 'refresh');
                } else
                    $this->session->set_flashdata('mess', 'Insert not successfull');
            }
        }



        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_advice.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogsAddEditPhotos($blogId = null) {
        $this->checkIfBlogExists($blogId);
        $data['getPhotosData'] = $this->profile_model->getPhotosData($blogId, $this->user->id);
        $this->checkUser($data['getPhotosData'], $blogId);
        $data["blogId"] = $blogId;
        $data['isPublished'] = $this->function_model->getPublished($blogId);

        if ($this->input->post('submit')) {

            if (!is_dir('uploads/' . $blogId)) {
                mkdir('./uploads/' . $blogId, 0777, TRUE);
            }
            //$config = array();
            $config['upload_path'] = './uploads/' . $blogId;
            $config['allowed_types'] = 'gif|jpg|png';
            //  $config['max_size']      = '0';
            $config['overwrite'] = FALSE;

            $files = $_FILES;
            $cpt = count($_FILES['images']['name']);
            //   $dataInfo = array();

            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['images']['name'] = $files['images']['name'][$i];
                $_FILES['images']['type'] = $files['images']['type'][$i];
                $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
                $_FILES['images']['error'] = $files['images']['error'][$i];
                $_FILES['images']['size'] = $files['images']['size'][$i];

                $originalName = $_FILES["images"]['name'];
                $newName = time() . '_' . $_FILES["images"]['name'];
                $config['file_name'] = $newName;

                $this->upload->initialize($config);
                if ($this->upload->do_upload('images')) {
                    $dataInfo[] = $this->upload->data();
                    // print_r($dataInfo[$i]['full_path']);die;
                    $path = $dataInfo[$i]['full_path'];
                    //print_r(substr($path, strpos($path,'uploads')));die;

                    $insertData[] = array(
                        //'blog_restaurants_id'=> 23,
                        'path' => substr($path, strpos($path, 'uploads')),
                        'original_name' => $originalName,
                        //  'city' => $restCities[$i],
                        'blog_id' => $blogId
                    );
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                    redirect('profile/blogs/add/photos/' . $blogId, 'refresh');
                }
            }
            if (!empty($insertData)) {
                $success = $this->profile_model->insertBatch('blog_photos', $insertData);
            }
            if (isset($success) && $success && $blogId) {

                $this->session->set_flashdata('mess', 'Insert successfull');
                sleep(2);
                redirect('profile/blogs/add/photos/' . $blogId, 'refresh');
            } else
                $this->session->set_flashdata('mess', 'Insert not successfull');
        }


        //}
        $data['main_content'] = 'site/profile/blogs/blogs_add_edit_photos.php';
        $this->load->view('lib-site/template', $data);
    }

    public function editImages($blogId = null) {
        if ($this->input->post('edit-submit')) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');


            if ($this->form_validation->run()) {
                $data = array(
                    'original_name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                );
                //  print_r("df");die;
                $setForBlogPhotosId = array(
                    'blog_photos_id' => $this->input->post('id')
                );
                $success = $this->profile_model->updateTable('blog_photos', $data, $setForBlogPhotosId);
            }
            if (isset($success) && $success) {

                $this->session->set_flashdata('mess', 'Insert successfull');
                sleep(2);
                redirect('profile/blogs/add/photos/' . $blogId, 'refresh');
            } else
                redirect('profile/blogs/add/photos/' . $blogId, 'refresh');
        }
    }

    public function publish($blogId) {
        $data['getSummaryData'] = $this->profile_model->getSummaryData($blogId, $this->user->id);
        if (!empty($data['getSummaryData']->blog_summary)) {
            //     print_r($data['getSummaryData']->blog_summary);die;
            $setWhere = array('blog_id' => $blogId);
            $isPublished = $this->function_model->getPublished($blogId);
            $inputData = array(
                'publish' => $isPublished == 1 ? 0 : 1,
                'publish_date' => date("Y/m/d")
            );
            // print_r($isPublished);die;s
            $this->profile_model->updateTable('blog', $inputData, $setWhere);
            if ($isPublished == 0) {
                $this->session->set_userdata('success', 'Congrats! Your blog is now published. Click the button below to see how it looks!.');
                $this->session->set_userdata('blogId', $blogId);

//   echo $this->session->userdata('success');die;
            }
            redirect('profile/blogs/', 'refresh');
        } else {
            $this->session->set_userdata('publish_error', ' You need to fill out the required fields on the summary tab before you can publish your blog.');
            redirect('profile/blogs/add/summary/' . $blogId, 'refresh');
        }
    }

    public function getCities() {
        $q = $this->input->get('q');
        $citi = $this->function_model->getCities($q);
        echo json_encode($citi);
    }

    private function deleteById($table, $blogId) {

        $this->profile_model->deleteById($table, $blogId);
        //$this->profile_model->deleteById($blogId);
        return true;
    }

    private function processMultiInputs($blogId, $cities, $locations) {
        if ($blogId) {
            if (!empty($cities)) {
                // print_r($cities);die;
                $success = $this->determingNewAndOldValuesOfMultiInputsAndInsertIntoBlogTables('blog_cities', 'cities', $blogId, $cities);
            }
            if (!empty($locations)) {
                // print_r($cities);die;
                $success = $this->determingNewAndOldValuesOfMultiInputsAndInsertIntoBlogTables('blog_locations', 'location_tags', $blogId, $locations);
            }
        }
        return $success;
    }

    private function determingNewAndOldValuesOfMultiInputsAndInsertIntoBlogTables($table, $valuesTable, $blogId, $multiInputValues) {
        //initialize arrays
        $oldValueIds = array();
        $newValues = array();
        $valueIds = array();
        $newValueIds = array();
        //run through the cities that were inputted and determine if old ones or new ones or both
        foreach ($multiInputValues as $value) {
            if (is_numeric($value)) {
                array_push($oldValueIds, $value);
            } else {
                array_push($newValues, $value);
            }
        }
        //if there are new cities then will input them into cities table
        if (!empty($newValues)) {
            foreach ($newValues as $value) {
                $data[] = array(
                    $valuesTable . '_name' => $value
                );
            }
            $valueInsertReturnData = $this->profile_model->insertValues($valuesTable, $data);
            $numberOfNewValues = $valueInsertReturnData['affectedRows'];
            $insertId = $valueInsertReturnData['insertId'];
            /* after inputting them - I return the id and number of rows and then
              create new array of the citi ids that just inserted into cities table */
            for ($i = 0; $i < $numberOfNewValues; $i++) {
                array_push($newValueIds, $insertId + $i);
            }
            //if there are also old cities merge the 2 arrays
            if (!empty($oldValueIds)) {
                $valueIds = array_merge($newValueIds, $oldValueIds);
            } else {
                $valueIds = $newValueIds;
            }
        }
        //if there are no new citis then only need to add the old citi ids
        else {
            $valueIds = $oldValueIds;
        }
        //create the array that will insert into the blog_cities table
        foreach ($valueIds as $id) {
            $tabledata[] = array(
                'blog_id' => $blogId,
                $valuesTable . '_id' => $id
            );
        }
        //return true if successfull input
        $success = $this->profile_model->insertBatch($table, $tabledata);
        return $success;
    }

    private function determineNewItemsFromSelect2AndInsert($table, $colName, $selectValue) {
        if (!is_numeric($selectValue)) {
            //array_push($oldValueIds, $value);
            $data = array(
                $colName => $selectValue
            );
            $insertId = $this->profile_model->insertIntoTable($table, $data);

            return $insertId;
        }
        return $selectValue;
    }

    private function checkIfBlogExists($blogId) {
        if ($blogId == null) {
            $this->session->set_flashdata('mess', 'Cannot Access until you set a title for your blog');
            redirect('profile/blogs/add/overview', 'refresh');
        } else
            return true;
    }

    private function checkUser($data, $blogId) {
        if (empty($data)) {
            $userId = $this->profile_model->checkUser($blogId);
            if ($userId != $this->user->id) {
                //   print_r('sdf');die;

                redirect('profile/blogs/add/overview', 'refresh');
            }
        }
    }

    private function determineIfNewOrOldCitySingle($cities) {
        $restCities = array();
        foreach ($cities as $citi) {
            if (is_numeric($citi)) {
                array_push($restCities, $citi);
            } else {
                $data = array(
                    'citi_name' => $citi
                );
                $insertId = $this->profile_model->insertIntoTable('cities', $data);
                array_push($restCities, $insertId);
            }
        }
        return $restCities;
    }

    public function editorImage($blogId) {
        //    print_r("sdfg");die;
        // echo "<script>alert('adfasdf');</script>" ;
        $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

        /*         * *******************************************
         * Change this line to set the upload folder *
         * ******************************************* */
        if (!is_dir('uploads/editor/' . $blogId)) {
            mkdir('./uploads/editor/' . $blogId, 0777, TRUE);
        }
        $imageFolder = "uploads/editor/" . $blogId . '/';
//        if (isset($_SERVER['HTTP_ORIGIN'])) {
//            // same-origin requests won't set an origin. If the origin is set, it must be valid.
//            if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
//                header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
//            } else {
//                header("HTTP/1.1 403 Origin Denied");
//                return;
//            }
//        }
        // Don't attempt to process the upload on an OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            return;
        }

        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {
            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
             */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');
            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Determine the base URL
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
            $baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            echo json_encode(array('location' => base_url() . $filetowrite));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }
    }

    public function deleteImages() {
        $id = $this->input->post('id');
        $path = $this->input->post('path');
        $this->profile_model->delete("blog_photos", $id);
        unlink($path);

        echo json_encode($id);
    }

    public function likedBlogs() {
        $page = $this->uri->segment(3);
        if ($this->input->get('view_all')) {
            redirect(base_url(uri_string()), 'refresh');
            //$this->input->get('title') = '';
        }

        $query = '';
        $searchstring = array();


        if (($this->input->get('title') != '')) {
            $searchstring['title'] = $this->input->get('title');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'title=' . $this->input->get('title');
        }
        if (($this->input->get('dates') != '')) {
            $searchstring['dates'] = $this->input->get('dates');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'dates=' . $this->input->get('dates');
        }
        //  if (($this->input->get('published') != '--------Select----------') && ($this->input->get('published') != '')) {
        //    $searchstring['published'] = $this->input->get('published') == 'Published' ? 1 : $this->input->get('published') == 'Not Published' ? '0' : '';
        if (($this->input->get('user') != '')) {
            $searchstring['user'] = $this->input->get('user');
            $searchstring['username'] = $this->function_model->getUserById($searchstring['user']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'user=' . $this->input->get('user');
        }
        if (($this->input->get('continent') != '')) {
            $searchstring['continent'] = $this->input->get('continent');
            $searchstring['continent_name'] = $this->function_model->getContinentById($searchstring['continent']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'continent=' . $this->input->get('continent');
        }
        if (($this->input->get('country') != '')) {
            $searchstring['country'] = $this->input->get('country');
            $searchstring['country_name'] = $this->function_model->getCountryById($searchstring['country']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'country=' . $this->input->get('country');
        }
        if (($this->input->get('state') != '')) {
            $searchstring['state'] = $this->input->get('state');
            $searchstring['state_name'] = $this->function_model->getStateById($searchstring['state']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'state=' . $this->input->get('state');
        }
        //   }   
        if (($this->input->get('locations') != '')) {
            $searchstring['locations'] = $this->input->get('locations');
            $searchstring['locationIds'] = $searchstring['locations'];
            foreach ($searchstring['locations'] as $id) {
                $query .= 'locations%5B%5D=' . $id . '&';
            }

            $idsArrays = $this->function_model->locationSearch($searchstring);
            $blogIds = array();
            foreach ($idsArrays as $id) {
                array_push($blogIds, $id->blog_id);
            }

            $searchstring['blog_ids'] = $blogIds;
            $searchstring['locations'] = $this->function_model->getLocationTagsId($searchstring['locations']);
        }
        $data['searchstring'] = $searchstring;

        if ($page == 'blogs') {
            $data['blogs'] = $this->profile_model->getLikedBlogsByUser($this->user->id, $searchstring);
            if ($data['blogs'] > 0) {
                $data['similarBlogs'] = $this->profile_model->getBlogsSimilarToLikedBlogs($data['blogs'][0]['state'], $data['blogs'][0]['country'], $data['blogs'][0]['user_id']);
            }
            $data['main_content'] = 'site/profile/liked/liked_blogs.php';
        } else if ($page == 'attractions') {
            $data['blogs'] = $this->profile_model->getLikedAttractionsByUser($this->user->id, $searchstring);
            if ($data['blogs'] > 0) {
                $data['similarBlogs'] = $this->profile_model->getBlogsSimilarToLikedBlogs($data['blogs'][0]['state'], $data['blogs'][0]['country'], $data['blogs'][0]['user_id']);
            }
            $data['main_content'] = 'site/profile/liked/liked_attractions.php';
        } else if ($page == 'restaurants') {
            $data['blogs'] = $this->profile_model->getLikedRestaurantsByUser($this->user->id, $searchstring);
            if ($data['blogs'] > 0) {
                $data['similarBlogs'] = $this->profile_model->getBlogsSimilarToLikedBlogs($data['blogs'][0]['state'], $data['blogs'][0]['country'], $data['blogs'][0]['user_id']);
            }
            $data['main_content'] = 'site/profile/liked/liked_restaurants.php';
        }

        $this->load->view('lib-site/template', $data);
    }

}
