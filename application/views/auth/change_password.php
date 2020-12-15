<div class="container-fluid">
    <div class="row">
        <div class="offset-4 col-3 top-row">
            <form method="post" action="<?php echo base_url('change_password'); ?>" class="border top-row ">

                <h4>Change Password</h4>
                <?php
                if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                }
                ?>
                <div class="top-row " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input type = "password" id="name" name="old_password" class="form-control" style="margin-bottom: " placeholder="Old Password" value="<?php echo $this->input->post('old_password', TRUE); ?>">        
                    <span class="error"><?php echo form_error('old_password') ?></span>
                </div>
                <div class=" " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input type = "password" id="name" name="new_password" class="form-control" style="margin-bottom: " placeholder="New Password" value="<?php echo $this->input->post('new_password', TRUE); ?>">        
                    <span class="error"><?php echo form_error('new_password') ?></span>
                </div>
                <div class=" " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input type = "password" id="name" name="new_password_confirm" class="form-control" style="margin-bottom: " placeholder="Confirm New Password" value="<?php echo $this->input->post('new_password_confirm', TRUE); ?>">        
                    <span class="error"><?php echo form_error('new_password_confirm') ?></span>
                </div>


                <input class="btn btn-primary pull-right submit-btn" type="submit" name="submit" value="Change Password" style="width: 100%;">


            <!--<p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>-->
                <!--<p><a href="<?php echo base_url('change_password') ?>"> Return to Login page </a></p>change_password-->
            </form>
        </div>


    </div>




</div>












