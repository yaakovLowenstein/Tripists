<div class="container-fluid">
    <div class="row">
        <div class="offset-4 col-3 top-row">
            <form method="post" action="<?php echo base_url('auth/create_user'); ?>" class="border top-row ">

                <h4>Create new profile</h4>
                <div class="top-row " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input id="name" name="email" class="form-control" style="margin-bottom: " placeholder="Email" value="<?php echo $this->input->post('email', TRUE); ?>">        
                   <?php echo form_error('email') ?>
                </div>
                <div class="" style="padding: 10px">
                    <!--<label for="name">Username</label>-->
                    <input id="name" name="username" class="form-control" style="margin-bottom: " placeholder="Username" value="<?php echo $this->input->post('username', TRUE); ?>">     
                   <span class="error"><?php echo form_error('username') ?></span>
                </div>
                <div class="" style="padding: 10px">
                    <!--<label for="name">Password</label>-->
                    <input type="password" id="name" name="password" class="form-control" style="margin-bottom: " placeholder="Password" value="<?php echo $this->input->post('password', TRUE); ?>">        
                    <span class="error"><?php echo form_error('password') ?></span>
                </div> 
                <div class="" style="padding: 10px">
                    <!--<label for="name">Confirm Password</label>-->
                    <input type="password" id="name" name="c_password" class="form-control" style="margin-bottom: " placeholder="Confirm Password" value="<?php echo $this->input->post('c_password', TRUE); ?>">         
                    <span class="error"><?php echo form_error('c_password') ?></span>
                </div> 

                <input class="btn btn-primary pull-right submit-btn" type="submit" name="submit" value="Register" style="width: 100%;">


            <!--<p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>-->

            </form>
        </div>


    </div>




</div>