
<div class="containter-fluid" style="height: auto;width: 100%">
<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

    <div class="row blog-content " >
        <div class="col-md-8 header">
            <h3 class="">Top Attraction!</h3>
            <p>Every trip has those awesome attractions or places you visited that you just want to tell everyone about. Here you can list those
                attractions that you absolutely loved so that others can share in you experience and go visit these places for themselves.
            </p>
        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/') . $blogId ?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>
    <!--     <?php
    if ($this->session->flashdata('mess')) {
        echo '<div class="flash-error col-md-6">' . $this->session->flashdata('mess');
    }
    ?>
                    </div>  -->
    <form  id = "attaction_form" method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/attractions/' . $blogId); ?>">
        <div class="form-row">
            <div class="col-md-4 top-row " style="display: ">
                               <label for="attractions" class="">Attraction Name</label>

                <select class="attraction" name="attractions" id="attr" style="width: 100%" >       

                       <?php
                            if (isset($getAttractionsData->attr_id) || $this->input->post('attractions')) {
                                if (isset($getAttractionsData->attr_id)) {
                                    $attraction = $getAttractionsData->attr_id;
                                    $attractionName = $getAttractionsData->attr_name;
                                } if ($this->input->post('attractions')) {
                                    $attraction = $this->input->post('attractions');
                                    $attractionName = $this->function_model->getAttractionsById($attraction);
                                }
                                ?>
                                <option value="<?php echo $attraction; ?>" selected="selected"><?php echo $attractionName; ?></option>
                            <?php } ?>

                </select>
                <?php echo form_error('attractions'); ?>
            </div>

            <div class="col-md-4 top-row " style="display: ">
                <label for="location" class="">Destination Tag*</label>
                   <!--<span class="example"><i>&nbsp;&nbsp;&nbsp;This can be Country, Region, State, e.g United States, Midwest, Yellowstone National Park, Arizona etc.</i></span>-->
                   <!--<input id="location" name="location[]" class="form-control" style="margin-bottom: 25px;">-->

                <select class="location-mulitiple" name="locations[]" id="location" style="width:100%">       

                    <?php
//whole next block is to keep the input text there even when the form errors
                    if ($this->input->post('locations')) {
                        $inputtedLocations = $this->input->post('locations');
                        $this->load->model('function_model');
                        $locations = $this->function_model->getLocationTagsId($inputtedLocations);
                        foreach ($locations as $location) {
                            ?>
                            <option value="<?php echo $location->id; ?>" selected="selected"><?php echo $location->text; ?></option>  
                            <?php
                        }
                        foreach ($inputtedLocations as $location) {
                            if (!is_numeric($location)) {
                                ?>
                                <option value="<?php echo $location; ?>" selected="selected"><?php echo $location; ?></option>  

                                <?php
                            }
                        }
                    } else if (isset($getAttractionsLocations) && !empty($getAttractionsLocations)) {
                        foreach ($getAttractionsLocations as $RowC) {
                            ?>
                            <option value="<?php echo $RowC->id; ?>" selected="selected"><?php echo $RowC->text; ?></option>
                        <?php } ?>
                    <?php } ?>

                </select>
                <?php echo form_error('locations[]'); ?>

            </div>
        </div>
        <div class="row top-row">
            <div class="col-md-8" style="padding-right: 0">
                <label for="description">Describe the attraction and why you loved it</label>
                <?php
                if (isset($getAttractionsData) && !empty($getAttractionsData)) {
                    $description = $getAttractionsData->attr_description;
                } else if ($this->input->post('description')) {
                    $description = $this->input->post('description');
                } else
                    $description = '';
                ?>

                <textarea id="description" name="description" class="form-control txt-area-desc" ><?php echo $description ?> </textarea>
                <?php echo form_error('description'); ?>

            </div>
        </div>

        <!--        <div class="form-row">
                    <div class="col-md-3 top-row ">
                        <label for="name">Name of attraction</label>
                        <input id="name" name="name" class="form-control" style="margin-bottom: 25px;">
                    </div>
                    <div class="col-md-3 top-row " style="display: ">
                        <label for="location">Location of attraction</label>
                        <input id="location" name="location" class="form-control" style="margin-bottom: 25px;">
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-6" style="padding-right: 0">
                        <label for="description">Describe the attraction and why you loved it</label>
                        <textarea id="description" name="description" class="form-control txt-area-desc"  > </textarea>
                    </div>
                </div>-->
        <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit" >

    </form>

</div>


</div>
</div>