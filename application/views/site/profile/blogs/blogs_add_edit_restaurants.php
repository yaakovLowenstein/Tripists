<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

<div class="containter-fluid" style="height: auto;">
    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class="">Favorite restaurants!</h3>
            <p>Every trip has those awesome restaurants or places you visited that you just want to tell everyone about. Here you can list those
                attractions that you absolutely loved so that others can share in you experience and go visit these places for themselves.
            </p>
        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/').$blogId?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>
    <form  id="rest-form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/restaurants/' . $blogId); ?>" onsubmit="return validate(['name','description']);">
        <div class="group-parent">
           <?php 
           $count =1;
           if(!empty($getRestaurantData)){
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
//?>
           
            <div class="group" >
                <div class="form-row">

                    <div class="col-md-3 top-row ">
                        <label for="name">Name of restaurant</label>
                        <input id="name1" name="rest_name[]" class="form-control" style="margin-bottom: " value="<?php echo isset($getRestaurantData[0]['name']) ? $getRestaurantData[0]['name']:''  ?> ">
                        <?php echo form_error('rest_name[]'); ?>
                         <span class="error-span">This field is required</span>
                    </div>


                </div>
                <div class="row rest-desc">
                    <div class="col-md-6 top-row" style="padding-right: 0">
                        <label for="description">Short description</label>
                        <textarea style="height:auto;" id="description1" name="rest_description[]" class="form-control "  ><?php echo isset($getRestaurantData[0]['description']) ? $getRestaurantData[0]['description']:''  ?> </textarea>
                        <span class="error-span">This field is required</span>

                        <?php echo form_error('rest_description[]'); ?>

                    </div>
                </div>

            </div>
           <?php //}?>
        </div>
        <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit"  >

    </form>
    <div class="row">
        <div id ="btn-col" class="col-md-6 plus-btn" align="center" >
            <input id="add" type="button" class="btn btn-success add" value="Add another restaurant" >
        </div>
        <div id="remove-btn-col" class="col-md-3 plus-btn" align="center" >
            <input style="display: none;" id="remove" type="button" class="btn btn-danger add" value="Remove restaurant">
        </div>
    </div>
</div>


</div>



