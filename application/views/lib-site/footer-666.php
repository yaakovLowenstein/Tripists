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
        tinymce.init({
        selector: '#mytextarea',
                menubar: 'format',
                height: 750,
                toolbar: 'insertfile undo redo | styleselect | bold italic underline| alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons| numlist',
                force_br_newlines: true,
                setup: function (editor) {
                editor.on('submit', function () {
                tinymce.triggerSave();
                });
<?php
//this checks to see if we are in edit mode $getSummaryData is set in the profile controller - 
//if it is set it means we are in edit mode so sets value 
if (isset($getSummaryData) && !empty($getSummaryData)) {
    ?>
                    editor.on('init', function (e) {
                    editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $getSummaryData->blog_summary) ?>');
                    });
<?php } else {
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
<?php } else {
    ?>
                    editor.on('init', function (e) {
                    editor.setContent('<?php echo preg_replace('/\r\n?\r?\n/', '<br>', $this->input->post('best_day', true)) ?>');
                    },
<?php } ?>
                }
                });
    </script>
    <script>
                        $(document).ready(function () {

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
}

for ($i = 1; $i < $count; $i++) {
    $name = $getRestaurantData[$i]['name'];
    $cityId = $getRestaurantData[$i]['city'];
    $cityName = $getRestaurantData[$i]['citi_name'];
    $description = $getRestaurantData[$i]['description'];

    echo '
                  addMoreRest(`' . $name . '`,`' . $cityId . '`,`' . $cityName . '`,`' . $description . '`);
             ';
}
?>
                });
    </script>

    <script>
                        $(document).ready(function () {
                $('.location-mulitiple').select2({
                tags: true,
                        ajax: {
                        url: "<?php echo base_url('location_tags') ?>",
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
                                $('#rest_city' + count).val(null).trigger('change');
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

    <script>

    </script>
</footer>
<!-- Footer -->