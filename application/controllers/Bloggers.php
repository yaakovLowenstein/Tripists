<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bloggers extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
    }

    public function bloggersList() {
        if ($this->input->get('view_all')) {
            redirect('bloggers/list', 'refresh');
            //$this->input->get('title') = '';
        }

        $query = '';
        $searchstring = array();
//         if ($this->input->get('search')!='') {
//             die;
//    }
//        if (($this->input->get('orderBy') != '')) {
//            //      print_r($this->input->get('orderBy'));
//            //   $searchstring['title'] = $this->input->get('title');
//            if ($query != '') {
//                $query .= '&';
//            }
//            $query .= 'orderBy=' . $this->input->get('orderBy');
//        }
//        if (($this->input->get('title') != '')) {
//            $searchstring['title'] = $this->input->get('title');
//            if ($query != '') {
//                $query .= '&';
//            }
//            $query .= 'title=' . $this->input->get('title');
//        }
//        if (($this->input->get('dates') != '')) {
//            $searchstring['dates'] = $this->input->get('dates');
//            if ($query != '') {
//                $query .= '&';
//            }
//            $query .= 'dates=' . $this->input->get('dates');
//        }
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

        $count = $this->bloggers_model->getBloggersCount($searchstring);

        $config['total_rows'] = $count;
        $config['per_page'] = 15;
        $url = 'blogs';
        if (!empty($query)) {
            $url .= '?' . $query;
        }
        $config['base_url'] = base_url($url); //. 'profile/blogs' . $query;
        $config['page_query_string'] = TRUE;
        $config["uri_segment"] = 2;
        //$config["num_links"] = 3;
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

        //   $data['getAllBLogsByUser'] = $this->profile_model->getAllBLogsByUser($config["per_page"], $page, $this->user->id, $searchstring);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();


        //sort 
        //search
        //list all blogs with cover photo and title and author
//        if (!empty($this->input->get('orderBy'))) {
//            if ($this->input->get('orderBy') == 'Oldest') {
//                $orderBy = 'publish_date';
//                $orderByDirection = 'asc';
//            } else if ($this->input->get('orderBy') == 'Newest') {
//                $orderBy = 'publish_date';
//                $orderByDirection = 'desc';
//            } else if ($this->input->get('orderBy') == 'Most Popular') {
//                $orderBy = 'clicked_count';
//                $orderByDirection = 'desc';
//            } else if ($this->input->get('orderBy') == 'Most Liked') {
//                $orderBy = 'TotalLikes';
//                $orderByDirection = 'desc';
//            }
//        } else {
//            $orderBy = 'publish_date';
//            $orderByDirection = 'desc';
//        }
        //    $data['blogs'] = $this->blogs_model->getPublishedBlogsForListing($config["per_page"], $page, $searchstring, $orderBy, $orderByDirection);


        $data["getBloggers"] = $this->bloggers_model->getBloggers($config["per_page"], $page, $searchstring);


        $data['main_content'] = 'site/bloggers/bloggers_list.php';
        $this->load->view('lib-site/template', $data);
    }

    public function bloggersDetails($userId) {
        $data["getBloggersDetailsById"] = $this->bloggers_model->getBloggersDetailsById($userId);
        //print_r($data["getBloggers"]);die;
        $data['bloggerDetails'] = $data["getBloggersDetailsById"][0];
        $data['main_content'] = 'site/bloggers/bloggers_details.php';
        $this->load->view('lib-site/template', $data);
    }

    public function subscribe() {
        $subscribe = $this->input->post('subscribe');
        $bloggerId = $this->input->post('blogger_id');
        $userId = $this->input->post('userId');
        $liked = false;
        if ($subscribe == 1) {
            $insertData = array(
                'blogger_id' => $bloggerId,
                "user_id" => $userId
            );
            $this->load->model('blogs_model');
            $this->blogs_model->insert('blogger_subscribers', $insertData);
            $liked = true;
        } else {
            $this->bloggers_model->delete('blogger_subscribers', $bloggerId, $userId);
            $liked = FALSE;
        }
        echo json_encode($liked);
    }

}
