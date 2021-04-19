<div class="fluid-container" style="width: 100%">
<div class="row" >
    <div class="col-md-8">
        <?php
//        if ($this->session->flashdata('message')) {
//            echo //$this->session->flashdata('message');
//        }
        ?>


    </div>
</div>
<form method="post" action="<?php echo base_url('profile') ?>" enctype="multipart/form-data" >
    <?php //echo form_open_multipart( base_url().'profile');?>

    <div class="row">
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('name')) {
                $name = $this->input->post('name');
            } else if (!empty($getProfileData->name)) {
                $name = $getProfileData->name;
            } else
                $name = '';
            ?>

            <label class="top" for="name">Name*</label>
            <input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo $name ?>">
            <?php echo form_error('name') ?>
        </div>
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('username')) {
                $username = $this->input->post('username');
            } else if (!empty($getProfileData->username)) {
                $username = $getProfileData->username;
            } else
                $username = '';
            ?>

            <label class="top" for="username">Username*</label>
            <input class="form-control" type="text" placeholder="Username" name="username" value="<?php echo $username ?>">
            <?php echo form_error('username') ?>

        </div>
        <div class="col-md-2">
            <a href="<?php echo base_url('change_password') ?>"> <input type="button" value="Change Password" class="btn btn-primary top-row" ></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('email')) {
                $email = $this->input->post('email');
            } else if (!empty($getProfileData->email)) {
                $email = $getProfileData->email;
            } else
                $email = '';
            ?>

            <label class="top" for="email">Email*</label>
            <input class="form-control" type="text" placeholder="Email" name="email" id="email" value="<?php echo $email ?>">
            <?php echo form_error('email') ?>

        </div>
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('website')) {
                $website = $this->input->post('website');
            } else if (!empty($getProfileData->website)) {
                $website = $getProfileData->website;
            } else
                $website = 'https://www.';
            ?>
            <label class="top" for="website">My personal Website</label>
            <input class="form-control" type="text" placeholder="" name="website" id="website"  value="<?php echo $website ?>">
        </div>

    </div>


    <div class="row">
        <div class="col-md-8 top-row">
            <?php
            if ($this->input->post('about')) {
                $about = $this->input->post('about');
            } else if (!empty($getProfileData->about)) {
                $about = $getProfileData->about;
            } else
                $about = '';
            ?>
            <label class="top" for="email">About Me</label>
            <textarea class="form-control" style="height: 400px" name="about"><?php echo $about ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 top-row">
            <label class="top" for="profile_pic">Profile Pic</label>
            <input  class="" type="file"  name="profile_pic" style="margin-left: 20px;">
            <?php
            if ($this->session->set_flashdata('error') != '') {
                echo $this->session->set_flashdata('error');
            }
            ?>
        </div>

    </div>
    <?php if (!empty($getProfileData->profile_pic_path)) { ?>
        <div class="row">
            <div class="top-row col-md-2 col-sm-6">
                <div class="prof-image-con">
                    <img class="prof-img" src="<?php echo base_url($getProfileData->profile_pic_path) ?>">
                </div>
            </div>


        </div>

    <?php } ?>
    <div class="row top-row" id="profile">
        <div class=" col-md-12 ">        
            <h3 class=" col-md-8 location-title ">Where you from?</h3>
        </div>
        <div class="col-md-2" >
            <!--<label for="location" class="top-row">Location Tags*</label>-->
            <label for="contient" class="">Continent</label>
            <select data-placeholder="Continent" class="continent" name="continent_from" id="continent"  style="width:100%" data-tags='false'>      
                <?php
                if (isset($getProfileData->continent_from) || $this->input->post('continent_from')) {
                    if (isset($getProfileData->continent_from)) {
                        $continent = $getProfileData->continent_from;
                        $continentName = $getProfileData->continent_name;
                    } if ($this->input->post('continent_from')) {
                        $continent = $this->input->post('continent_from');
                        $continentName = $this->function_model->getContinentById($continent);
                    }
                    ?>
                    <option value="<?php echo $continent; ?>" selected="selected"><?php echo $continentName; ?></option>
                <?php } ?>

            </select>
            <?php echo form_error('continent_from'); ?>

        </div>
        <div class="col-md-3" >
            <label for="country" class="">Country</label>
            <select data-placeholder="Country" class="country" name="country_from" id="country"  style="width:100%" data-tags='false'>      
                <?php
                if (isset($getProfileData->country_from) || $this->input->post('country_from')) {
                    if (isset($getProfileData->country_from)) {

                        $country = $getProfileData->country_from;
                        $countryName = $getProfileData->country_name;
                    } if ($this->input->post('country_from')) {
                        $country = $this->input->post('country_from');
                        $countryName = $this->function_model->getCountryById($country);
                    }
                    if ($this->input->post('continent_from') && $this->input->post('country_from') == "") {
                        $country = "";
                        $countryName = "";
                    }
                    ?>
                    <option value="<?php echo $country ?>" selected="selected"><?php echo $countryName; ?></option>
                <?php } ?>

            </select>
            <?php echo form_error('country_from'); ?>

        </div>
        <div class="col-md-2" style="display: none" id="state-con">
            <label for="state" class="">State*</label>
            <select data-placeholder="State" class="state" name="state_from" id="state"  style="width:100%" data-tags='false'>      
                <?php
                if (isset($getProfileData->state_from) || $this->input->post('state_from')) {
                    if (isset($getProfileData->state_from)) {

                        $state = $getProfileData->state_from;
                        $stateName = $getProfileData->state_name;
                    } if ($this->input->post('state_from')) {
                        $state = $this->input->post('state_from');
                        $stateName = $this->function_model->getStateById($state);
                    }
                    if ($this->input->post('country_from') && $this->input->post('state_from') == "") {
                        $state = "";
                        $stateName = "";
                    }
                    ?>
                    <option value="<?php echo $state ?>" selected="selected"><?php echo $stateName; ?></option>
                <?php } ?>

            </select>

        </div>
        <div class="col-md-2">
            <?php
            if ($this->input->post('city')) {
                $city = $this->input->post('city');
            } else if (!empty($getProfileData->city)) {
                $city = $getProfileData->city;
            } else
                $city = '';
            ?>

            <label class="top" for="email">City</label>
            <input class="form-control" type="text" placeholder="City" name="city" id="city" value="<?php echo $city ?>">
        </div>
    </div>
    <div class="row top-row" >
        <div class="col-md-8 top-row" style="border-top: 1px lightgrey dashed">
            <h2>Social Media</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('youtube')) {
                $youtube = $this->input->post('youtube');
            } else if (!empty($getProfileData->youtube)) {
                $youtube = $getProfileData->youtube;
            } else
                $youtube = 'https://www.youtube.com/';
            ?>
            <label class="top" for="website">Youtube</label>
            <input class="form-control" type="text" placeholder="" name="youtube" id="website"  value="<?php echo $youtube ?>">
        </div>
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('facebook')) {
                $facebook = $this->input->post('facebook');
            } else if (!empty($getProfileData->facebook)) {
                $facebook = $getProfileData->facebook;
            } else
                $facebook = 'https://www.facebook.com/';
            ?>
            <label class="top" for="website">Facebook</label>
            <input class="form-control" type="text" placeholder="" name="facebook" id="website" value="<?php echo $facebook ?>">
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('instagram')) {
                $instagram = $this->input->post('instagram');
            } else if (!empty($getProfileData->instagram)) {
                $instagram = $getProfileData->instagram;
            } else
                $instagram = 'https://www.instagram.com/';
            ?>
            <label class="top" for="website">Instagram</label>
            <input class="form-control" type="text" placeholder="" name="instagram" id="website" value="<?php echo $instagram ?>">
        </div>
        <div class="col-md-4 top-row">
            <?php
            if ($this->input->post('twitter')) {
                $twitter = $this->input->post('twitter');
            } else if (!empty($getProfileData->twitter)) {
                $twitter = $getProfileData->twitter;
            } else
                $twitter = 'https://www.twitter.com/';
            ?>
            <label class="top" for="website">Twitter</label>
            <input class="form-control" type="text" placeholder="" name="twitter" id="website" value="<?php echo $twitter ?>">
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 ">
            <input  class="btn btn-primary  submit-btn" type="submit" name="submit" value="Save" style="width: 100px;" >
        </div>

    </div>
</form>

</div>

</div>