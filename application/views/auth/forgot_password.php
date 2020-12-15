<div class="container-fluid">
    <div class="row">
        <div class="offset-4 col-3 top-row">
            <form method="post" action="<?php echo base_url('forgot_password'); ?>" class="border top-row ">

                <h4>Forgot Password</h4>
                <?php if ($this->session->flashdata('message')){
                    echo $this->session->flashdata('message');
                } ?>
                <div class="top-row " style="padding: 10px">
                    <!--<label for="name">Email</label>-->
                    <input id="name" name="identity" class="form-control" style="margin-bottom: " placeholder="Email" value="<?php echo $this->input->post('identity', TRUE); ?>">        
                    <span class="error"><?php echo form_error('identity') ?></span>
                </div>

              

                <input class="btn btn-primary pull-right submit-btn" type="submit" name="submit" value="Send Email" style="width: 100%;">


            <!--<p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>-->
                <p><a href="<?php echo base_url('login')?>"> Return to Login page </a></p>
            </form>
        </div>


    </div>




</div>







