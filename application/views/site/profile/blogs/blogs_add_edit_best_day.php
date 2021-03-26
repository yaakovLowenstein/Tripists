
<div class="containter-fluid" style="height: auto;width: 100%; ">
<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>
    <div class="row blog-content " >
        <div class="col-md-8 header">
            <h3 class="">Describe your favorite day.</h3>

        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/').$blogId?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>
    <form  id="form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/best_day/').$blogId; ?>">

        <div class="row ">
            <div class="col-md-6" style="padding-right: 0">
                <textarea id="mytextarea" name="best_day">     </textarea>   
            </div>
        </div>
        <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit"  >

    </form>

</div>


</div>

