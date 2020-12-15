<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

<div class="containter-fluid" style="height: auto;">
    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class="">List as many pieces of advice as you can think of!</h3>
<!-- <?php
            if ($this->session->flashdata('mess')) {
                echo '<div class="flash-error col-md-6">'.$this->session->flashdata('mess');
            }
            ?>
                </div>  -->
        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/').$blogId?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>
    <form  id="form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/advice/') . $blogId; ?>" onsubmit="return validate(['name', 'description']);">
        <div class="group-parent">

            <div class="group">
                <div class="row top-row">
                    <div class="col-md-6" style="padding-right: 0">
                        <label for="name">Title you give your piece of advice</label>
                        <input id="name1" name="name[]" class="form-control" style="margin-bottom: " value="<?php echo isset($getAdviceData[0]['name']) ? $getAdviceData[0]['name'] : '' ?> ">          
                        <span class="error-span">This field is required</span>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-6" style="padding-right: 0">
                        <label for="description">Advice</label>
                        <textarea id="description1" name="description[]" class="form-control txt-area-desc"  ><?php echo isset($getAdviceData[0]['description']) ? $getAdviceData[0]['description'] : '' ?>  </textarea>
                        <span class="error-span">This field is required</span>

                    </div>
                </div>
            </div>
        </div>
        <input  class="btn btn-primary  submit-btn" type="submit" name="submit"  >

    </form>

    <div class="row">
        <div id ="btn-col" class="col-md-6 plus-btn" align="center" >
            <input id="add" type="button" class="btn btn-success add" value="Add another piece of advice">
        </div>
        <div id="remove-btn-col" class="col-md-3 plus-btn" align="center" >
            <input style="display: none;" id="remove" type="button" class="btn btn-danger add" value="Remove piece of advice">
        </div>
    </div>

</div>


</div>


