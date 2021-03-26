
<div class="containter-fluid" style="height: auto;width: 100%">
<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

    <div class="row blog-content " >
        <div class="col-md-8 header">
            <h3 class="">Favorite restaurants!</h3>
            <p>Every trip has those awesome restaurants or places you visited that you just want to tell everyone about. Here you can list those
                attractions that you absolutely loved so that others can share in you experience and go visit these places for themselves.
            </p>
        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/') . $blogId ?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>
    <form  id="rest-form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/restaurants/' . $blogId); ?>" onsubmit="return validate(['name', 'description','location']);">
        <div class="group-parent">
            <?php
            $count = 1;
            if (!empty($getRestaurantData)) {
                //todo maybe call javascript method with php and pass in parameters to set the inputs as
                $count = sizeof($getRestaurantData);
            }
            //print_r($count);
//           echo "<script>
//              $(document).ready(function(){ ";
//          for ($i=0;$i<$count;$i++) { 
//       //   sleep(10);
//              echo '
//                  addMoreRest();
//             ';
//             // sleep(2);
//          }
//          echo '});
//      </script>'
//
            ?><div class="group" >
                <div class="form-row">


                    <div class="col-md-4 top-row " style="display: ">
                        <label for="rest_name[]" class="">Restaurant Name</label>

                        <select class="restaurants" name="rest_name[]" id="name1" style="width: 100%" >       

                            <?php
                            if (isset($getRestaurantData[0]['rest_id']) || $this->input->post('rest_name[]')) {
                                if (isset($getRestaurantData[0]['rest_id'])) {
                                     
                                    $restaurant = $getRestaurantData[0]['rest_id'];
                                    $restaurantName = $getRestaurantData[0]['rest_name_name'];
                                    print_r($restaurantName) ;
                                } //if ($this->input->post('rest_name[]')) {
                                 //   $restaurant = $this->input->post('rest_name[]');
                                  //  $restaurantName = $this->function_model->getRestaurantsById($restaurant);
                                //}
                                ?>
                                <option value="<?php echo $restaurant; ?>" selected="selected"><?php echo $restaurantName; ?></option>
                            <?php } ?>

                        </select>
                        <p class="error-span select2 name" style="display: none" id="name-select2-error1">This field is required</p>
                        <?php echo form_error('rest_name[]'); ?>
                    </div>

                    <div class="col-md-4 top-row " style="display: ">
                        <label for="location" class="">Destination Tag*</label>
                           <!--<span class="example"><i>&nbsp;&nbsp;&nbsp;This can be Country, Region, State, e.g United States, Midwest, Yellowstone National Park, Arizona etc.</i></span>-->
                           <!--<input id="location" name="location[]" class="form-control" style="margin-bottom: 25px;">-->

                        <select class="location-mulitiple" name="locations[]" id="location1" style="width:100%">       
                            <?php
                            if (isset($getRestaurantData[0]['location_id']) || $this->input->post('location[]')) {
                                if (isset($getRestaurantData[0]['location_id'])) {
                                    $location = $getRestaurantData[0]['location_id'];
                                    $locationName = $getRestaurantData[0]['location_tags_name'];
                                } if ($this->input->post('location[]')) {
                                    $restaurant = $this->input->post('location[]');
                                    $locationName = $this->function_model->getLocationsById($location);
                                }
                                ?>
                                <option value="<?php echo $location; ?>" selected="selected"><?php echo $locationName; ?></option>
                            <?php } ?>


                        </select>
                        <?php echo form_error('locations[]'); ?>
                        <p class="error-span select2 location" style="display: none" id="location-select2-error1">This field is required</p>

                    </div>
                </div>   

                <!--<div class="group" >-->
                <!--                <div class="form-row">
                
                                    <div class="col-md-3 top-row ">
                                        <label for="name">Name of restaurant</label>
                                        <input id="name1" name="rest_name[]" class="form-control" style="margin-bottom: " value="<?php echo isset($getRestaurantData[0]['name']) ? $getRestaurantData[0]['name'] : '' ?> ">
                <?php echo form_error('rest_name[]'); ?>
                                        <span class="error-span">This field is required</span>
                                    </div>
                
                
                                </div>-->
                <div class="row rest-desc">
                    <div class="col-md-8 top-row" style="padding-right: 0">
                        <label for="description">Short description</label>
                        <textarea style="min-height:100px;" id="description1" name="rest_description[]" class="form-control "  ><?php echo isset($getRestaurantData[0]['description']) ? $getRestaurantData[0]['description'] : '' ?> </textarea>
                        <span class="error-span">This field is required</span>

                        <?php echo form_error('rest_description[]'); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php //} ?>
        <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit"  >

    </form>
    <div class="row">
        <div id ="btn-col" class="col-md-8 plus-btn" align="center" style="margin-bottom: 35px;" >
            <input id="add" type="button" class="btn btn-success add" value="Add another restaurant" >
        </div>
        <div id="remove-btn-col" class="col-md-4 plus-btn" align="center" >
            <input style="display: none;" id="remove" type="button" class="btn btn-danger add" value="Remove restaurant">
        </div>
    </div>
</div>


</div>



