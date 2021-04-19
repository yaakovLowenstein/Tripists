<?php $user = $this->ion_auth->user()->row(); ?>

<div class="fluid-containter" style="width: 100%">
    <h2 class="top-row" style="color: #6d7fcc">Messages <i class="far fa-envelope"></i></h2>

    <div class="col-md-12 ">       
        <div class="col-md-12 " style="text-align: center">       
        </div>

        <form  action="<?php echo base_url('profile/messages/list') ?>" style="width: 100%;display: none;" method="get" onsubmit="" id="message-form">

            <div class="row" id="">
                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input id="datepicker" type="text" placeholder="Date" name="date" class="form-control add_btn"
                           value="<?php echo $this->input->get('date') ?>" >

                </div>

                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input id="search_title" type="text" placeholder="From" name="from" class="form-control add_btn"
                           value="<?php echo $this->input->get('from') ?>" >

                </div>
                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input id="search_title" type="text" placeholder="Subject" name="subject" class="form-control add_btn"
                           value="<?php echo $this->input->get('subject') ?>" >

                </div>

                <div class="col-md-3" >
                    <input name="search" type ="submit" class="btn btn-success add_btn " value="Search" >
                    <input name="view_all" type ="submit" class="btn btn-success add_btn " value="View All" >
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check">

                        <input id="unread" name="unread" type="checkbox" class="form-check-input" value="1" onchange="$('#message-form').submit()"   <?php
                        if ($this->input->get('unread') == 1) {
                            echo 'checked="checked"';
                        }
                        ?>
                               >
                        <label style="font-size:16px" class="form-check-label" for="unread">Only show unread conversations</label><br>
                    </div>

                </div>
            </div>

        </form>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-11">
                <button id="search-toggle" class="btn " style="float: right;background-color: #47c4e1 "> <p style="color: white;margin: 0" >Search Bar<i class="fas fa-search" style="margin-left: 5px;"></i></p></button>
            </div>
        </div>
    </div>

    <div class="row " >
        <div class="col-md-11 ">
            <table class="table table-striped blog-list" width="100%">
                <thead>
                    <tr>
                        <th width="20%">Date</th>
                        <th width="15%">From</th>
                        <th width="15%">To</th>
                        <th width="20%">Subject</th>
                        <!--<th width='25%'>Location Tags</th>-->
                        <!--<th width="5%">likes</th>-->
                        <th width='27%'>Message</th>
                        <th width='3%'></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = $this->input->get('per_page') == '' ? 1 : $this->input->get('per_page') + 1;
                    foreach ($getReceivedMessagesSubjects as $row) {
                        ?>
                        <tr class="click-message" data-href="<?php
                        if ($row->conversation_id == 0) {
                            echo base_url('profile/messages/details/') . $row->blog_messages_id;
                        } else {
                            echo base_url('profile/messages/details/') . $row->conversation_id;
                        }
                        ?>"   data-toggle="tooltip" data-placement="top" title="Click to reply" data-delay='{ "show": 500, "hide": 100 }'> 



                                                                <!--<td><?php echo $i ?></td>-->
                            <td><?php
                                $date = date_create($row->date_sent);
                                echo date_format($date, "m/d/Y g:i A");
                                ?> 
                            </td>
                            <td><?php echo $row->from_name ?></td>
                            <td><?php echo $row->to_name ?></td>



                            <td><?php echo $row->subject ?></td>


                            <td><?php echo character_limiter($row->message, 50, "...") ?></td>
                            <?php
                            $isReadBy = 'is_read_by_from';
                            if ($user->id == $row->to_id) {
                                $isReadBy = 'is_read_by_to';
                            }
                            ?>
                            <td><?php if ($row->$isReadBy == 0) { ?> <i class="far fa-envelope"  data-toggle="tooltip" data-placement="right" title="Unread Message" ></i> <?php } ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <div style="text-align: center">
                <p><?php echo $links; ?></p>
            </div>
        </div>
    </div>
</div>
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->

<script>
    $(document).ready(function ($) {
        $(".click-message").click(function () {
            window.location = $(this).data("href");
        });
    });

    $('#search-toggle').click(function () {
        $('form').slideToggle();
    });
    $(function () {
        $("#datepicker").datepicker();
    });
    $(document).ready(function () {
<?php if ($this->input->get('search') == 'Search' || $this->input->get('unread') == 1) { ?>
            $('form').show();
<?php } ?>
    });
</script>