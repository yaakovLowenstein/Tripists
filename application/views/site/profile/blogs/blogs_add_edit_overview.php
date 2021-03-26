
<div class="containter-fluid" style="height: auto;width: 100%">
<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class=""></h3>

            <?php if ($this->session->flashdata('mess')) { ?>
                <span style="border: 2px solid red; padding:5px;">
                    <?php
                    echo $this->session->flashdata('mess');
                }
                ?></span>
            <form  id = "form-sum" method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/overview/' . $blogId); ?>" enctype="multipart/form-data" >

                <label for="title">Title of your Blog*</label>
                <span class="example"><i>&nbsp;&nbsp;&nbsp;e.g. The time I went skiing in the Alps</i></span>
                <?php
                if (isset($getSummaryData) && !empty($getSummaryData)) {
                    $title = $getSummaryData->blog_title;
                } else if ($this->input->post('title')) {
                    $title = $this->input->post('title');
                }
                ?>

                <input id="title" name="title" class="form-control" style="margin-bottom: " value="<?php
                if (isset($title)) {
                    echo $title;
                }
                ?>">
                       <?php echo form_error('title'); ?>
                <div class="row">
                    <div class="col-md-8 top-row">
                        <label class="top" for="cover_pic">Cover Photo</label>
                        <input  class="" type="file"  name="cover_pic" style="margin-left: 20px;">
                        <?php
                        if ($this->session->set_flashdata('error') != '') {
                            echo $this->session->set_flashdata('error');
                        }
                        ?>
                    </div>

                </div>
                <?php if (!empty($getSummaryData->cover_pic_path)) { ?>
                    <div class="row">
                        <div class="top-row col-md-8 image-con-cover-thumb" style="margin: 0">
                            <img class="img-cover-thumb" src="<?php echo base_url($getSummaryData->cover_pic_path) ?>">
                        </div>


                    </div>

                <?php } ?>


                <input  class="btn btn-primary pull-right submit-btn" type="submit" name="submit" >

            </form>

        </div>
    </div>

</div>


</div>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

