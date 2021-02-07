<!-- Footer -->
<footer class="page-footer font-small blue pt-4">

    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-6 mt-md-0 mt-3">

                <!-- Content -->
                <h5 class="text-uppercase">Footer Content</h5>
                <p>Here you can use rows and columns to organize your footer content.</p>

            </div>
            <!-- Grid column -->

            <hr class="clearfix w-100 d-md-none pb-3">

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Link 1</a>
                    </li>
                    <li>
                        <a href="#!">Link 2</a>
                    </li>
                    <li>
                        <a href="#!">Link 3</a>
                    </li>
                    <li>
                        <a href="#!">Link 4</a>
                    </li>
                </ul>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Link 1</a>
                    </li>
                    <li>
                        <a href="#!">Link 2</a>
                    </li>
                    <li>
                        <a href="#!">Link 3</a>
                    </li>
                    <li>
                        <a href="#!">Link 4</a>
                    </li>
                </ul>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
        <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
    </div>
    <!-- Copyright -->







    <script>
       function filePickerCallback  (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                /*
                 //                 Note: In modern browsers input[type="file"] is functional without
                 //                 even adding it to the DOM, but that might not be the case in some older
                 //                 or quirky browsers like IE, so you might want to add it to the DOM
                 //                 just in case, and visually hide it. And do not forget do remove it
                 //                 once you do not need it anymore.
                 //                 */
//
                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                         Note: Now we need to register the blob in TinyMCEs image blob
                         registry. In the next release this part hopefully won't be
                         necessary, as we are looking to handle it internally.
                         */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {title: file.name});
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        
        
        tinymce.init({
            selector: '#mytextarea',
            menubar: 'format insert',
            height: 750,
            toolbar: 'insertfile undo redo | styleselect | bold italic underline| alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons| numlist',
            force_br_newlines: true,
           plugins: [
                " autolink  link image  preview  anchor ",
                " wordcount",
                
                "emoticons  paste   "
            ],
            
            image_title: true,
            paste_data_images: true,
            document_base_url: "<?php echo base_url(); ?>",
            relative_urls: false,
            remove_script_host: false,
            /* enable automatic uploads of images represented by blob or data URIs*/
            //  automatic_uploads: true,
//            images_reuse_filename :true,    
            /*
             URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
             images_upload_url: 'postAcceptor.php',
             here we add custom filepicker only to Image dialog
             */
            images_upload_url: ' <?php echo base_url("editorImage/") . $this->uri->segment(5) ?>',
//           file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback:filePickerCallback,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
//editor.uploadImages(),
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                    // alert("as");
                    // tinymce.uploadImages();

                });
                
<?php
//this checks to see if we are in edit mode $getSummaryData is set in the profile controller - 
//if it is set it means we are in edit mode so sets value 
if (isset($getSummaryData->blog_summary) && !empty($getSummaryData->blog_summary)) {
    ?>
                    editor.on('init', function (e) {
                        editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $getSummaryData->blog_summary) ?>');
                    });
<?php }  if ($this->uri->segment(4) == 'summary' && $this->input->post('summary', true)) {
    ?>
                    editor.on('init', function (e) {
                        editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $this->input->post('summary', true)) ?>');
                    });
<?php } ?>
<?php
//this checks to see if we are in edit mode $getBestDayData is set in the profile controller - 
//if it is set it means we are in edit mode so sets value 
if (isset($getBestDayData) && !empty($getBestDayData)) {
    ?>
                    editor.on('init', function (e) {
                        editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $getBestDayData->best_day) ?>');
                    });
<?php }  if ($this->uri->segment(4) == 'best_day' && $this->input->post('best_day', true)) {
    ?>
                    editor.on('init', function (e) {
                        editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $this->input->post('best_day', true)) ?>');
                    });
<?php } ?>
            }
        });
    </script>
    <script>
        $(document).ready(function () {

            $("#blog-post img").each(function (index, element) {
                var width = element.clientWidth;
                var height = element.clientHeight;
                if (height > width) {
                    $(element).wrap("<div class='image-con-vertical'></div>");
                    $(element).addClass("img-vertical");
                } else {
                    $(element).wrap("<div class='image-con'></ div>");
                    $(element).addClass("img");
                }
            });
            $("#best-day img").each(function (index, element) {
                var width = element.clientWidth;
                var height = element.clientHeight;
                if (height > width) {
                    $(element).wrap("<div class='image-con-vertical'></div>");
                    $(element).addClass("img-vertical");
                } else {
                    $(element).wrap("<div class='image-con'></div>");
                    $(element).addClass("img");
                }
            });
            $('.cities-mulitiple').select2({
                tags: true,
                ajax: {
                    url: "<?php echo base_url('cities') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
<?php
$count = 1;
if (!empty($getRestaurantData)) {
    //todo maybe call javascript method with php and pass in parameters to set the inputs as
    $count = sizeof($getRestaurantData);


    for ($i = 1; $i < $count; $i++) {
        $name = $getRestaurantData[$i]['name'];
        // $cityId = $getRestaurantData[$i]['city'];
        //$cityName = $getRestaurantData[$i]['citi_name'];
        $description = $getRestaurantData[$i]['description'];

        echo '
                  addMoreRest(`' . $name . '`,`' . "" . '`,`' . "" . '`,`' . $description . '`);
             ';
    }
}
if (!empty($getWorstPartsData)) {
    //todo maybe call javascript method with php and pass in parameters to set the inputs as
    $count = sizeof($getWorstPartsData);


    for ($i = 1; $i < $count; $i++) {
        $name = $getWorstPartsData[$i]['name'];
        //  $cityId = $getRestaurantData[$i]['city'];
        // $cityName = $getRestaurantData[$i]['citi_name'];
        $description = $getWorstPartsData[$i]['description'];

        echo '
                  addMoreRest(`' . $name . '`,`' . '' . '`,`' . '' . '`,`' . $description . '`);
             ';
    }
}
if (!empty($getAdviceData)) {
    //todo maybe call javascript method with php and pass in parameters to set the inputs as
    $count = sizeof($getAdviceData);


    for ($i = 1; $i < $count; $i++) {
        $name = $getAdviceData[$i]['name'];
        //  $cityId = $getRestaurantData[$i]['city'];
        // $cityName = $getRestaurantData[$i]['citi_name'];
        $description = $getAdviceData[$i]['description'];

        echo '
                  addMoreRest(`' . $name . '`,`' . '' . '`,`' . '' . '`,`' . $description . '`);
             ';
    }
}
?>


        });
    </script>

    <script>
        function initializeCountrySelect2() {

            $('.country').select2({
                language: {
                    noResults: function () {
                        return ("Need to select a continent first");
                    }
                },
                allowClear: true,
                ajax: {
                    url: "<?php echo base_url('countries') ?>",
                    dataType: 'json',
                    type: "post",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term,
                            continent: $('.continent').val()
                        }
                        return queryParameters;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
        }
        function inititializeLocationsSelect2() {
            $('.location-mulitiple').select2({
                tags: true,
                ajax: {
                    url: "<?php echo base_url('location_tags') ?>",
                    dataType: 'json',
                    type: "Post",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term,
                            country: $('#country').val()
                        }
                        return queryParameters;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
        }
        function inititializeStatesSelect2() {
            $('.state').select2({
                allowClear: true,
                ajax: {
                    url: "<?php echo base_url('states') ?>",
                    dataType: 'json',
                    type: "post",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term,
                        }
                        return queryParameters;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
        }


        $(document).ready(function () {
            if ($(".continent").val() != null) {
                initializeCountrySelect2();
            } else {
                $('.country').select2({
                    language: {
                        noResults: function () {
                            return ("Need to select a continent first");
                        }
                    }
                });
            }

            if ($(".country").val() != null) {
                inititializeLocationsSelect2();
            } else {
                $('.location-mulitiple').select2({
                    language: {
                        noResults: function () {
                            return ("Need to select a continent and a country first");
                        }
                    }
                });
            }
            if ($(".country").val() == '230') {
                $("#state-con").show();
                inititializeStatesSelect2();
            }

            $('.users').select2({
                allowClear: true,
                tags: true,
                ajax: {
                    url: "<?php echo base_url('users-select2') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
            $('.continent').select2({
                allowClear: true,
                ajax: {
                    url: "<?php echo base_url('continents') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }

            });
            $('.attraction').select2({
                allowClear: true,
                tags: true,
                ajax: {
                    url: "<?php echo base_url('attractions-select') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }

            });
<?php if (($this->uri->segment(1) == "blogs" ) || $this->uri->segment(1) == "bloggers" || $this->uri->segment(4) == "attractions" || $this->uri->segment(1) == "attractions" || $this->uri->segment(1) == "restaurants") { ?>
                inititializeLocationsSelect2();
<?php } ?>

        });
        $('.country').on('change', function () {
            // alert($('#country').val());
            inititializeLocationsSelect2();
            if ($('.country').val() == "230") {
                $("#state-con").show();
                inititializeStatesSelect2();
                //alert("asdf");

            } else {
                $("#state-con").hide();
            }
        });
        $('.continent').on('change', function () {
            $('.country').val(null).trigger('change');
            initializeCountrySelect2();
        });
    </script>


    <script>
        var count = 1;
        function addMoreRest(name, cityId, cityName, description) {
            //document.write(count);   
            count++;
            //find and initalize elements
            var org = $('.group').last();
            var orgSelect = org.find('select');
            //  alert(orgSelect);
            orgSelect.select2('destroy');
            var clone = $('.group').last().clone(true); //.appendTo($('.group-parent'));         
            var input = clone.find('input'); //.attr('id',);
            var select = clone.find('select'); //.attr('id',);
            var txtarea = clone.find('textarea'); //.attr('id',);
            var p = clone.find('p[class="error-span select2"]');
            //   alert(div);

            //set the ids to increment so each clone has unique ids
            p.attr('id', 'select2-error' + count);
            (input).attr('id', 'name' + count);
            (select).attr('id', 'rest_city' + count);
            (txtarea).attr('id', 'description' + count);
            initializeSelect2(orgSelect, select);
            //append the clone to the page
            clone.appendTo($('.group-parent'));
            $('#remove').show();
            $('#btn-col').removeClass('col-md-6');
            $('#btn-col').addClass('col-md-3 text-right');
            $('#remove-btn-col').addClass('text-left');
            if (name != '') {
                //      document.write('#name' + count);
                $('#name' + count).val(name);
                $('#description' + count).val(description);
                $('#rest_city' + count).val('2').trigger('change');
                var studentSelect = $('#rest_city' + count);
                $.ajax({
                    type: 'post',
                    url: "<?php echo base_url('location_tags') ?>"
                }).then(function (data) {
                    // create the option and append to Select2
                    var option = new Option(cityName, cityId, true, true);
                    studentSelect.append(option).trigger('change');
                    // manually trigger the `select2:select` event
                    studentSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                });
            } else {
                //set clones to empty
                $('#name' + count).val('');
                $('#description' + count).val('');
                $('#rest_city' + count).val(-1).trigger('change');
                $('#name' + count).focus();
            }
        }
        //todo maybe numbers before each rest - span with setting count...
        //
        //maybe clean up the following code
        //var count = 1;
        $("#add").click(function () {
            addMoreRest('', '', '');
        });
        $("#remove").click(function () {
            count--;
            if ($('.group').length != 1) {
                $('.group').last().remove()
            }
            if ($('.group').length == 1) {
                $('#remove').hide();
                $('#btn-col').addClass('col-md-6');
                $('#btn-col').removeClass('col-md-3 text-right');
            }
            $('#name' + count).focus();
        });
        function validate(array) {
            var validated = true;
            for (var i = 1; i <= count; i++) {
                for (var j = 0; j < array.length; j++) {
                    if (($('#' + array[j] + i).val() == null)) {
                        validated = false;
                        $('#select2-error' + i).show();
                        // $('#name' + i).focus();
                    } else if (($('#' + array[j] + i).val().trim() == '')) {
                        validated = false;
                        $('#' + array[j] + i).next().show();
                        // $('#name' + i).focus();
                    }
                }
            }
            if (!validated)
            {
                return false;
            }
        }

//        $('#rest-form').submit(function (e) {
//            //     e.preventDefault();
//            var validated = true;
//            for (var i = 1; i <= count; i++) {
//                //  alert(i);    
//                //  alert($('#name' + i).val());
//                //var desc = $('#description' + count).val();
//                //    alert(i +""+ desc);
//                if (($('#name' + i).val().trim() == '')) {
//                    validated = false;
//                    $('#name' + i).next().show();
//                    // $('#name' + i).focus();
//                }
//                if (($('#rest_city' + i).val() == null)) {
//                    validated = false;
//                    $('.error-span.select2').show();
//                }
//
//                //  alert("x2" +i +"" +desc);
//                if ($('#description' + i).val().trim() == '') {
//                    validated = false
//                    $('#description' + i).next().show();
//                }
//
//
//            }
//            if (!validated)
//            {
//                //  alert('#rest_city' + count).val());
//                e.preventDefault();
//
//                //alert($('#description' + count).val());
//            }
////        var name = $('#name' + count).val();
////        alert(name);
////        $.ajax({
////        url: "<?php echo base_url('profile/blogs/restaurants/validate') ?>",
////                type: "POST",
////                dataType: "json",
////                data: {
////                name:name
////                },
////        success: function(result){
////        //window.location.href = "http://stackoverflow.com";
////    //location.reload();
////    
//            //  }
//
//
//            // });
//        });

        function initializeSelect2(orgSelect, select) {
            orgSelect.select2({
                tags: true,
                ajax: {
                    url: "<?php echo base_url('cities') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
            select.select2({
                tags: true,
                ajax: {
                    url: "<?php echo base_url('cities') ?>",
                    dataType: 'json',
                    type: "Get",
                    quietMillis: 50,
                    data: function (params) {

                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id: obj.id, text: obj.text};
                            })
                        };
                    }

                }
            });
        }
    </script>

<!--    <script>
        var count = 1;
        function addWorstPart(name, cityId, cityName, description) {
            //document.write(count);   
            count++;
            //find and initalize elements
           // var org = $('.group').last();
            //var orgSelect = org.find('select');
            //  alert(orgSelect);
           // orgSelect.select2('destroy');
            var clone = $('.group').last().clone(true); //.appendTo($('.group-parent'));         
            var input = clone.find('input'); //.attr('id',);
        //    var select = clone.find('select'); //.attr('id',);
            var txtarea = clone.find('textarea'); //.attr('id',);
           // var p = clone.find('p[class="error-span select2"]');
            //   alert(div);

            //set the ids to increment so each clone has unique ids
          //  p.attr('id', 'select2-error' + count);
            (input).attr('id', 'name' + count);
          //  (select).attr('id', 'rest_city' + count);
            (txtarea).attr('id', 'description' + count);
         //   initializeSelect2(orgSelect, select);
            //append the clone to the page
            clone.appendTo($('.group-parent'));
            $('#remove').show();
            $('#btn-col').removeClass('col-md-6');
            $('#btn-col').addClass('col-md-3 text-right');
            $('#remove-btn-col').addClass('text-left');
            if (name != '') {
                //      document.write('#name' + count);
                $('#name' + count).val(name);
                $('#description' + count).val(description);
            //    $('#rest_city' + count).val('2').trigger('change');
//             //   var studentSelect = $('#rest_city' + count);
//                $.ajax({
//                    type: 'post',
//                    url: "<?php echo base_url('location_tags') ?>"
//                }).then(function (data) {
//                    // create the option and append to Select2
//                    var option = new Option(cityName, cityId, true, true);
//                    studentSelect.append(option).trigger('change');
//                    // manually trigger the `select2:select` event
//                    studentSelect.trigger({
//                        type: 'select2:select',
//                        params: {
//                            data: data
//                        }
//                    });
//                });
            } else {
                //set clones to empty
                $('#name' + count).val('');
                $('#description' + count).val('');
            //    $('#rest_city' + count).val(null).trigger('change');
                $('#name' + count).focus();
            }
        }
        //todo maybe numbers before each rest - span with setting count...
        //
        //maybe clean up the following code
        //var count = 1;
      
//        $("#remove").click(function () {
//            count--;
//            if ($('.group').length != 1) {
//                $('.group').last().remove()
//            }
//            if ($('.group').length == 1) {
//                $('#remove').hide();
//                $('#btn-col').addClass('col-md-6');
//                $('#btn-col').removeClass('col-md-3 text-right');
//            }
//            $('#name' + count).focus();
//        });
        function validate(array) {
            var validated = true;
            for (var i = 1; i <= count; i++) {
                for (var j = 0; j < array.length; j++) {
                    if (($('#' + array[j] + i).val() == null)) {
                        validated = false;
                        $('#select2-error' + i).show();
                        // $('#name' + i).focus();
                    } else if (($('#' + array[j] + i).val().trim() == '')) {
                        validated = false;
                        $('#' + array[j] + i).next().show();
                        // $('#name' + i).focus();
                    }
                }
            }
            if (!validated)
            {
                return false;
            }
        }
    </script>-->

    <script>
<?php if ($this->session->userdata('publish_error')) { ?>
            $(document).ready(function () {
                $('#modal-p').text('<?php echo $this->session->userdata('publish_error') ?>');
                $('#modal-header').text('Error');
                $('#modal-btn').trigger('click');
                // $('#myModal').modal('show')
            });
    <?php
}
$this->session->unset_userdata('publish_error');
?>
<?php if ($this->session->userdata('success')) { ?>
            $(document).ready(function () {
                var message = "<?php echo $this->session->userdata('success'); ?>";
                //test = 'Congrats! Your blog is now published. Click <a href=`#`>"here"</a> to see how it looks!.'           
                $('#modal-p').text(message);
                $('#modal-header').text('Woohoo!');
                $('#take-to-blog-btn').show();
                $('#modal-btn').trigger('click');
                // $('#myModal').modal('show')
            });
    <?php
}
$this->session->unset_userdata('success');
?>


<?php
//$isPublished =           $this->function_model->getPublished($blogId);
if (isset($isPublished) && $isPublished == 1) {
    ?>
            $('#publish_btn').val('Unpublish your blog');
            $('#publish_btn').attr('class', 'btn btn-danger')


    <?php
} else {
    ?>
            $('#publish_btn').val('Publish your blog');
            $('#publish_btn').attr('class', 'btn btn-success')

    <?php
}
?>

    </script>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" hidden="hidden" id="modal-btn">
        Launch demo modal
    </button>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="height:350px; width: 350px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-header" style="color:black">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <p id="modal-p" style="color: black;font-size: 24px"></p> 
                    <a href="<?php echo base_url() . "blog-details/" . $this->session->userdata("blogId") ?>"><input type="button" class="btn btn-success" style="display: none" value="Take me to my blog" id="take-to-blog-btn"></a>
                </div>
                <div align="center" style="display: none" id="sign-in-form" >
                    <form id='modal-sign-in-form' action="<?php echo base_url() . 'Auth/login?fromPage=yes' ?>" method="post"  style="width: 80%;">
                        <input id='identity' name="identity" type="text" class="form-control" placeholder="Username/ Email">
                        <input name="url_string" type="hidden" value="<?php echo uri_string() ?>">
                        <input id='password'name="password" type="password" class="form-control" style="margin: 10px 0" placeholder="Password">
                        <input name="submit" type="submit" class="btn btn-primary" style="width:100%" value="Login">
                    </form>
                    <a id="modal-a"style="color:blue !important;display: none;" href="<?php echo base_url('register'); ?>" > Click here to create an account</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>

    <script>
//        $("#modal-sign-in-form").on('submit', function (event) {
//            event.preventDefault();
//
//            var identity = $('#identity').val();
//            var password = $('#password').val();
//            // alert(select);
//
//            $.ajax({
//                url: '<?php echo base_url("Auth/login") ?>',
//                cache: false,
//                type: 'post',
//                data: {identity: identity, password: password},
//                datatype: 'json',
//                success: function (result) { //we got the response
//                    $('#myModal').modal('toggle');
//                    $('#modal-header').text('Thank you');
//                    $('#modal-p').text("You are signed in now.");
//                    $('#modal-btn').trigger('click');
//                    // $('#message-text').val('');
////location.reload();
//
//                },
//                error: function (jqXHR, textStatus, errorThrown) {
//                    console.log(JSON.stringify(jqXHR));
//                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//                }
//            });
//
//
//        });
    </script>

    <script>$(function () {
            $('[data-toggle="tooltip"]').tooltip()


        })
    </script>

    <script>
        //photos page
        function changeDropFileText() {
            // alert('asfd');
            var numFiles = $("input:file")[0].files.length;
            $('#drop-file-text').text(numFiles + ' image(s) selected');
            if (numFiles == 0) {
                $('#drop-file-text').text('Drop files here to upload or click to browse.');
            }
        }
<?php if ($this->uri->segment(1) == 'profile') { ?>
            $('#imageInputModal').on('show.bs.modal', function (event) {
                //alert("asdf");
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
            });
<?php } ?>

        function deleteImage(id) {
            var ob = $('#' + id);
            // alert(ob.data('path'));
            $.ajax({
                url: '<?php echo base_url("deleteImages") ?>',
                cache: false,
                type: 'post',
                data: {id: id, path: ob.data('path')},
                datatype: 'json',
                success: function (respnse) {
                    location.reload();
                }
            });
        }

    </script>


</footer>
<!-- Footer -->