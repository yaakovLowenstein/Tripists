<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

<div class="containter-fluid" style="height: auto;">
    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class=""></h3>

        </div>
    </div>      <?php //echo form_open_multipart('profile/blogs/add/photos');                        ?> 

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
                <div class="row top-row">
                    <div class="col-md-9">
                        <?php
                        $count = 0;
                    }
                    ?>

                    <div class="image-wrapper">
                        <img  id="myImg<?php echo $num ?>" src="<?php echo base_url() . $row->path ?>" data-toggle="modal" data-target="#imageInputModal" 
                              data-whatever="<?php echo $num ?>" data-blog-photos-id="<?php echo $row->blog_photos_id ?>" data-description="<?php echo $row->description ?>">
                        <p  id="myImgName<?php echo $num ?>"" class="image-name"><?php echo $row->original_name ?></p>
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

<script>
    function changeDropFileText() {
        // alert('asfd');
        var numFiles = $("input:file")[0].files.length;
        $('#drop-file-text').text(numFiles + ' image(s) selected');

        if (numFiles == 0) {
            $('#drop-file-text').text('Drop files here to upload or click to browse.');
        }
    }
    $('#imageInputModal').on('show.bs.modal', function (event) {
        var image = $(event.relatedTarget) // image that triggered the modal
        var num = image.data('whatever') // Extract info from data-* attributes
        var id = image.data('blog-photos-id');
        var desc = image.data('description');

        var modal = $(this)
        var img = document.getElementById("myImg" + num);

//        modal.find('.modal-title').text($('#myImg' + num).src);
        modal.find('.modal-body input[type="text"]').val($('#myImgName' + num).text());
//     /document.write(img.src);
        modal.find('#modal-image').attr("src", img.src);
        //$('#modal-form').attr('action',"<?php echo base_url() . 'profile/blogs/image/' . $blogId ?>"  );
        $('#id').val(id);
        $('#description').val(desc);

    })


</script>


