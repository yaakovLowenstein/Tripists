<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>
<div class="containter-fluid" style="height: auto">
    <div class="row " >
        <div class="col-md-6 top-row">
<!--             <?php
            if ($this->session->flashdata('mess')) {
                echo '<div class="flash-error col-md-6">'.$this->session->flashdata('mess');
            }
            ?>
                </div>  -->
            <form  id = "form-sum" method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/summary/' . $blogId); ?>" >


                <label for="location" class="top-row">Location Tags*</label>
                <span class="example"><i>&nbsp;&nbsp;&nbsp;This can be Country, Region, State, e.g United States, Midwest, Yellowstone National Park, Arizona etc.</i></span>
                <!--<input id="location" name="location[]" class="form-control" style="margin-bottom: 25px;">-->

                <select class="location-mulitiple" name="locations[]" id="location" multiple="multiple" style="width:100%">       

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
                    } else if (isset($getSummaryDataLocations) && !empty($getSummaryDataLocations)) {
                        foreach ($getSummaryDataLocations as $RowC) {
                            ?>
                            <option value="<?php echo $RowC->id; ?>" selected="selected"><?php echo $RowC->text; ?></option>
                        <?php } ?>
                    <?php } ?>

                </select>
                <?php echo form_error('locations[]'); ?>

                <label for="dates" class="top-row">Dates of your trip*</label>
                <span class="example"><i>&nbsp;&nbsp;&nbsp;e.g. January - March 2019</i></span>
                <?php
                if (isset($getSummaryData) && !empty($getSummaryData)) {
                    $dates = $getSummaryData->blog_dates;
                } else if ($this->input->post('dates')) {
                    $dates = $this->input->post('dates');
                }
                ?>


                <input id="dates" name="dates" class="form-control" style="margin-bottom: " value="<?php
                if (isset($dates)) {
                    echo $dates;
                }
                ?>">
                       <?php echo form_error('dates'); ?>

                <label for="citeis" class="top-row">Cities you visited</label>
                <span class="example"><i>&nbsp;&nbsp;&nbsp;(if the citi is not in the list pressing enter will add it to the list)</i></span>
                <select class="cities-mulitiple" name="cities[]" id="citeis" multiple="multiple" style="width:100%">       

                    <?php
//whole next block is to keep the input text there even when the form errors
                    if ($this->input->post('cities')) {
                        $inputtedCities = $this->input->post('cities');
                        $this->load->model('function_model');
                        $cities = $this->function_model->getCityId($inputtedCities);
                        foreach ($cities as $citi) {
                            ?>
                            <option value="<?php echo $citi->id; ?>" selected="selected"><?php echo $citi->text; ?></option>  
                            <?php
                        }
                        foreach ($inputtedCities as $citi) {
                            if (!is_numeric($citi)) {
                                ?>
                                <option value="<?php echo $citi; ?>" selected="selected"><?php echo $citi; ?></option>  

                                <?php
                            }
                        }
                    }
                   else if (isset($getSummaryDataCities) && !empty($getSummaryDataCities)) {
                        foreach ($getSummaryDataCities as $RowC) {
                            ?>
                            <option value="<?php echo $RowC->id; ?>" selected="selected"><?php echo $RowC->text; ?></option>
                        <?php } ?>
                    <?php } ?>

                </select>
                <?php echo form_error('cities'); ?>

                <label for="summary" style="margin-top: 25px">Your blog post*</label>
                <textarea id="mytextarea" name="summary">
      
                </textarea>
                <?php echo form_error('summary'); ?>

                <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit" >
            </form>

        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/').$blogId?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>

</div>


</div>

