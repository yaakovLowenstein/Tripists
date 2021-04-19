<?php $user = $this->ion_auth->user()->row(); ?>

<div class="fluid-container" style="width: 100%;margin-top: 50px">
    <h3>Subject: <?php echo $getMessages[0]->subject ?></h3>  
    <h4>From: <?php echo $getMessages[0]->from_name ?></h4>  
    <h4>To: <?php echo $getMessages[0]->to_name ?></h4>  
    <?php if ($getMessages[0]->blog_about_id != 0) { ?>
        <h5>About: <?php echo $getMessages[0]->blog_title ?></h5>  
    <?php } ?>
    <?php foreach ($getMessages as $row) { ?>
        <div class="row  " >
            <?php if ($row->to_id == $user->id) { ?>    


                <div class = "prof-image-con-thumb col-md-1" style = "padding-right:0">
                    <img class = "prof-img-thumb"src = "<?php echo base_url() . $fromPic ?>">
                </div>
            <?php }
            ?>
            <div class="col-md-10 " >                
                <div class="row ">

                    <div class="col-md-10 <?php
                    if ($row->from_id == $user->id) {
                        echo 'rep';
                    }
                    ?>">

                        <div class="desc-box  <?php
                        if ($row->from_id == $user->id) {
                            echo 'reply';
                        }
                        ?>" style="width:100%;padding: 20px;margin-top: 5px">

                            <div class="desc-inner-box">

                                <p ><?php echo $row->message ?></p>
                                <p style="float: right" ><?php
                                    $date = date_create($row->date_sent);
                                    echo date_format($date, "m/d/Y g:i A");
                                    ?></p>

                            </div>
                        </div>
                    </div>

                </div>           

            </div>
            <?php if ($row->from_id == $user->id) { ?>    


                <div class = "prof-image-con-thumb col-md-1" style = "padding-right:0">
                    <img class = "prof-img-thumb"src = "<?php echo base_url() . $toPic ?>">
                </div>
            <?php }
            ?>  
        </div>
    <?php }
    ?>
    <div class="row top-row">
        <div class="col-md-10 offset-md-1">
            <label>Reply</label>
            <textarea id="message-text" class="form-control" style="height: 200px;outline: none !important;border:3px solid lightblue;"></textarea>
            <span style="display:none;"class="error-span">This field is required</span>

            <input type="button" value="Send" style="float: right;margin-top: 10px;" class="btn btn-primary b-color" id="message_btn">
        </div>

    </div>
</div>    

<script>
    $("#message_btn").on('click', function (event) {
        event.preventDefault();

        var mess = $('#message-text').val();
        // var select = $('#is_this_blog').val();
        //  var subject = $('#subject').val();

        // alert(select);


        if (mess != '') {
            $.ajax({
                url: '<?php echo base_url("blog-messages") ?>',
                cache: false,
                type: 'post',
                data: {message: mess, select: 0, blog_id: '0', subject: " <?php echo $getMessages[0]->subject ?>", to_blogger:<?php echo $toId ?>, from_user:<?php echo $user->id ?>, is_reply: 1, conversation_id:<?php echo $getMessages[0]->blog_messages_id ?>},
                datatype: 'json',
                success: function (result) { //we got the response
//                        //$('#modal-header').text('Thank you');
//                        $('#modal-p').text("Your message has been sent.");
//                        $('#modal-btn').trigger('click');
//                        $('#message-text').val('');
//                        $('#subject').val('');
////                        $('.error-span').hide();
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
//            } else {
//
//                $('#modal-p').text("You need to login in order to send a message.");
//                $('#modal-header').text('Login');
//                // $('#take-to-blog-btn').show();
//                $('#modal-btn').trigger('click');
//                $('#sign-in-form').show();
//                //$('.modal-footer').hide();
//                $('#modal-a').show();
//                $('.modal-content').height('425px')
//            }
        } else {
            $('.error-span').show();
        }
    });
</script>