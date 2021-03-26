<div class="containter-fluid" style="height: auto;width: 100%">
    <?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

    <div class="row " >
        <div class="col-md-8  top-row">
            <!--             <?php
            $this->load->model('function_model');

            if ($this->session->flashdata('mess')) {
                echo '<div class="flash-error col-md-6">' . $this->session->flashdata('mess');
            }
            ?>
                            </div>  -->
            <form  id = "form-sum" method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/summary/' . $blogId); ?>" >
                <div class="row">
                    <div class="col-md-4" >
                        <!--<label for="location" class="top-row">Location Tags*</label>-->
                        <label for="contient" class="">Continent*</label>
                        <span class="help-icon"   data-toggle="tooltip" data-placement="top" title="If your trip spanned multiple continetns, 
                              choose the one that was the primary destination."><i class="fa fa-question-circle"></i></span>
                        <select data-placeholder="Continent" class="continent" name="continent" id="continent"  style="width:100%" data-tags='false'>      
                            <?php
                            if (isset($getSummaryData->continent) || $this->input->post('continent')) {
                                if (isset($getSummaryData->continent)) {
                                    $continent = $getSummaryData->continent;
                                    $continentName = $getSummaryData->continent_name;
                                } if ($this->input->post('continent')) {
                                    $continent = $this->input->post('continent');
                                    $continentName = $this->function_model->getContinentById($continent);
                                }
                                ?>
                                <option value="<?php echo $continent; ?>" selected="selected"><?php echo $continentName; ?></option>
                            <?php } ?>

                        </select>
                        <?php echo form_error('continent'); ?>

                    </div>
                    <div class="col-md-4" >
                        <label for="country" class="">Country*</label>
                        <span class="help-icon"   data-toggle="tooltip" data-placement="top" title="If your trip spanned 3 or more countries,
                              choose the '3+' option. If it spanned 2, choose the country that was the primary destination."><i class="fa fa-question-circle"></i></span>
                        <select data-placeholder="Country" class="country" name="country" id="country"  style="width:100%" data-tags='false'>      
                            <?php
                            if (isset($getSummaryData->country) || $this->input->post('country')) {
                                if (isset($getSummaryData->country)) {

                                    $country = $getSummaryData->country;
                                    $countryName = $getSummaryData->country_name;
                                } if ($this->input->post('country')) {
                                    $country = $this->input->post('country');
                                    $countryName = $this->function_model->getCountryById($country);
                                }
                                if ($this->input->post('continent') && $this->input->post('country') == "") {
                                    $country = "";
                                    $countryName = "";
                                }
                                ?>
                                <option value="<?php echo $country ?>" selected="selected"><?php echo $countryName; ?></option>
                            <?php } ?>

                        </select>
                        <?php echo form_error('country'); ?>

                    </div>

                    <div class="col-md-2" style="display: none" id="state-con">
                        <label for="country" class="">State*</label>
                        <span class="help-icon"   data-toggle="tooltip" data-placement="top" title="If your trip spanned 3 or more states,
                              choose the '3+' option. If it spanned 2, choose the country that was the primary destination."><i class="fa fa-question-circle"></i></span>
                        <select data-placeholder="State" class="state" name="state" id="state"  style="width:100%" data-tags='false'>      
                            <?php
                            if (isset($getSummaryData->state) || $this->input->post('state')) {
                                if (isset($getSummaryData->state)) {

                                    $state = $getSummaryData->state;
                                    $stateName = $getSummaryData->state_name;
                                } if ($this->input->post('state')) {
                                    $state = $this->input->post('state');
                                    $stateName = $this->function_model->getStateById($state);
                                }
                                if ($this->input->post('country') && $this->input->post('state') == "") {
                                    $state = "";
                                    $stateName = "";
                                }
                                ?>
                                <option value="<?php echo $state ?>" selected="selected"><?php echo $stateName; ?></option>
                            <?php } ?>

                        </select>
                        <?php echo form_error('state'); ?>

                    </div>

                </div>
                <div class="row top-row">
                    <div class="col-md-10">
                        <label for="location" >Destination Tags*</label>
                        <span class="help-icon"   data-toggle="tooltip" data-placement="top" title="Tags purpose is for search. Choose Tags 
                              that get more specific than country. You can put as many tags as you want. The more the merrier. Tags
                              could be states, cities or national parks etc."><i class="fa fa-question-circle"></i></span>                        
                        <span class="example"><i>&nbsp;&nbsp;&nbsp;To add new tags, type it in and press enter.</i></span>
                                                <!--<input id="location" name="location[]" class="form-control" style="margin-bottom: 25px;">-->

                        <select class="location-mulitiple" name="locations[]" id="location" multiple="multiple" style="width:100%">       

                            <?php
//whole next block is to keep the input text there even when the form errors
                            if ($this->input->post('locations')) {
                                $inputtedLocations = $this->input->post('locations');
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label for="dates" class="top-row">Dates of your trip*</label>
                        <span class="example"><i>&nbsp;&nbsp;&nbsp;e.g. January - March 2019</i></span>
                        <?php
                        if (isset($getSummaryData->blog_dates) && !empty($getSummaryData->blog_dates)) {
                            $dates = $getSummaryData->blog_dates;
                        } else if ($this->input->post('dates')) {
                            $dates = $this->input->post('dates');
                        }
                        ?>

                        <input id="dates" name="dates" class="form-control"  value="<?php
                        if (isset($dates)) {
                            echo $dates;
                        }
                        ?>">
                               <?php echo form_error('dates'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="summary" style="margin-top: 25px">Your blog post*</label>
                        <textarea id="mytextarea" name="summary">
      
                        </textarea>
                        <?php echo form_error('summary'); ?>
                    </div>
                </div>
                <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit" >
            </form>

        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/') . $blogId ?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>

</div>


</div>
<script>
    $('#tinymce').on('change', function () {
        alert("sf");
        $('#tinymce img').each(function () {
            $(this).attr("width", "300");
        });
    });

</script>