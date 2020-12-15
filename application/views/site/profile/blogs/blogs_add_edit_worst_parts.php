<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

<div class="containter-fluid" style="height: auto;">
    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class="">List a few parts of your trip you think people should avoid.</h3>

        </div>
    </div>
    <form  id="form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/worst_parts/') . $blogId; ?>" onsubmit="return validate(['name', 'description']);">
        <div class="group-parent">
            <div class="group">
                <div class="row top-row">
                    <div class="col-md-6" style="padding-right: 0">
                        <label for="name">Title</label>
                        <input id="name1" name="name[]" class="form-control " style="margin-bottom: " value="<?php echo isset($getWorstPartsData[0]['name']) ? $getWorstPartsData[0]['name']:''  ?> ">         
                        <span class="error-span">This field is required</span>

                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-6" style="padding-right: 0">
                        <label for="description">Reason should be avoided</label>
                        <textarea id="description1" name="description[]" class="form-control txt-area-desc"  ><?php echo isset($getWorstPartsData[0]['description']) ? $getWorstPartsData[0]['description']:''  ?> </textarea>
                        <span class="error-span">This field is required</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-6" style="padding-right: 0">

                <input  class="btn btn-primary  submit-btn" type="submit" name="submit"  >
            </div>
        </div>
    </form>

    <div class="row">
        <div id ="btn-col" class="col-md-6 plus-btn" align="center" >
            <input id="add" type="button" class="btn btn-success add" value="Add another thing to avoid" >
        </div>
        <div id="remove-btn-col" class="col-md-3 plus-btn" align="center" >
            <input style="display: none;" id="remove" type="button" class="btn btn-danger add" value="Remove">
        </div>
    </div>

</div>


</div>


