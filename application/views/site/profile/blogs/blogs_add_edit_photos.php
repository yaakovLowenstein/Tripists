
<div class="containter-fluid" style="height: auto;width: 100%">
<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

    <div class="row blog-content " >
        <div class="col-md-8 header">
            <h3 class=""></h3>

        </div>
        <div class="col-md-2">
            <form class="publish publish-from" method="post" action="<?php echo base_url('publish/') . $blogId ?>">
                <input class="btn btn-success publish" type="submit" value="Publish your blog" id="publish_btn" >

            </form>

        </div>
    </div>      <?php //echo form_open_multipart('profile/blogs/add/photos');                             ?> 

    <form  id="form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/photos/') . $blogId; ?>" enctype="multipart/form-data">
        <div class="col-md-6">
            <div class="form-group">
                <br clear="all">
                <div class="drophere">
                    <input type="file" name="images[]" id="ContractFiles" multiple="multiple" accept=".jpg,.png, .gif" onchange="changeDropFileText();">
                    <p id="drop-file-text">Drop files here to upload or click to browse.</p>
                    <span style="color:red"> <?php
                        if ($this->session->flashdata('error')) {
                            echo $this->session->flashdata('error');
                        }
                        ?></span>
                </div>
            </div>
        </div>
        <input  class="btn btn-primary  submit-btn" type="submit" name="submit"  >

    </form>
    <?php
    $count = 0;
    $num = 0;
    if (!empty($getPhotosData)) {
        ?>
        <div class="row top-row">
            <div class="col-md-9">
                <?php
                foreach ($getPhotosData as $row) {
                    $count++;
                    $num++;
                    if ($count == 8) {
                        ?>
                    </div>
                </div>
    <div class="row top-row" style="margin-bottom:20px;">
                    <div class="col-md-9">
                        <?php
                        $count = 1;
                    }
                    ?>

                    <div class="image-wrapper">

                        <img  id="myImg<?php echo $num ?>" src="<?php echo base_url() . $row->path ?>" data-toggle="modal" data-target="#imageInputModal" 
                              data-whatever="<?php echo $num ?>" data-blog-photos-id="<?php echo $row->blog_photos_id ?>" data-description="<?php echo $row->description ?>" >
                        <p  style="margin:0" id="myImgName<?php echo $num ?>" class="image-name"><?php echo $row->original_name ?></p>
                        <input data-path="<?php echo './' . $row->path ?>" id = "<?php echo $row->blog_photos_id ?>" type="button" class="btn btn-danger" value="Delete" style=" height: 20px; font-size: 12px; width: 40%;padding:0;" onclick="deleteImage(this.id)"/>

                    </div>

                    <?php
                }
                ?>

            </div>

        </div>
    <?php }
    ?>

</div>


</div>
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>-->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>-->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>-->

<div class="modal fade" id="imageInputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit name and description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-image-wrapper">
                    <img class="modal-images" id="modal-image" src="" alt="Image" />
                </div>
                <form id="modal-form" class="top-row" method="post" action="<?php echo base_url() . 'profile/blogs/image/' . $blogId ?>">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Image Name</label>
                        <input type="text" class="form-control" id="recipient-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <input type="hidden" name="id" id="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save" name="edit-submit">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




