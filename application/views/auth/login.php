<div class="container-fluid">
    <div class="row">
        <div class="offset-4 col-3 top-row">
            <form method="post" action="<?php echo base_url('login'); ?>" class="border top-row ">

                <h4>Login</h4>
                <?php if ($this->session->flashdata('message')){
                    echo $this->session->flashdata('message');
                } ?>
                <div class="top-row " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input id="name" name="identity" class="form-control" style="margin-bottom: " placeholder="Email/ Username" value="<?php echo $this->input->post('identity', TRUE); ?>">        
                    <span class="error"><?php echo form_error('identity') ?></span>
                </div>

                <div class="" style="padding: 10px">
                    <!--<label for="name">Password</label>-->
                    <input type="password" id="name" name="password" class="form-control" style="margin-bottom: " placeholder="Password" value="<?php echo $this->input->post('password', TRUE); ?>">        
                    <span class="error"><?php echo form_error('password') ?></span>
                </div> 
<!--                <p>
                    <?php echo lang('login_remember_label', 'remember'); ?>
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                </p>-->

                <input class="btn btn-primary pull-right submit-btn" type="submit" name="submit" value="Login" style="width: 100%;">


            <!--<p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>-->
                <p><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p>
            </form>
        </div>


    </div>




</div>













