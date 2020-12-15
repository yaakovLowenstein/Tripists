<?php require_once(APPPATH . "views/site/profile/blogs/tabs.php"); ?>

<div class="containter-fluid" style="height: auto;">
    <div class="row blog-content " >
        <div class="col-md-6 header">
            <h3 class=""></h3>

        </div>
    </div>      <?php //echo form_open_multipart('profile/blogs/add/photos');                ?> 

    <form  id="form"  method="post" class ="blog-content" action="<?php echo base_url('profile/blogs/add/photos/') . $blogId; ?>" enctype="multipart/form-data">
        <div class="col-md-6">
            <div class="form-group">
                <br clear="all">
                <div class="drophere">
                    <input type="file" name="images[]" id="ContractFiles" multiple="multiple" accept=".jpg,.png, .gif" onchange="changeDropFileText();">
                    <p id="drop-file-text">Drop files here to upload or click to browse.</p>
                    <span style="color:red"> <?php if ($this->session->flashdata('error')) {
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
                        <img  id="myImg<?php echo $num ?>" src="<?php echo base_url() . $row->path ?>" onclick="makeBig(<?php echo $num ?>);">
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
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
    <!--<textarea class="image-caption"></textarea>-->
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

//    $(document).ready(function () {
    var modal = document.getElementById("myModal");

    function makeBig(num) {
        var img = document.getElementById("myImg" + num);// $('#myImg' + num);
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = $('#myImgName' + num).text();
        // close();


// Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }
    }
//function close(){
//       var modal = document.getElementById("myModal");
//
//        if (  modal.style.display == "block"){
//            $('body').click(function (event) {
//              modal.style.display = "none";
//            });
//        }
//}
////    });
</script>


