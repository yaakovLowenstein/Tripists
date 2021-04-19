<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title> Travel Enthusiasts</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <script type="text/javascript" src="<?php echo base_url() . 'bower_components/jquery/jquery.js'; ?>"></script>
        <?php if ($this->uri->segment(2) == 'messages' && $this->uri->segment(3) == 'list') { ?>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <?php } ?>
  <!--        <script src="<?php echo base_url() . 'bower_components/jquery/validation/dist/jquery.validate.min.js'; ?>"></script>
                <script src="<?php echo base_url() . 'bower_components/jquery/validation/dist/jquery.validate.js'; ?>"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
        <link href="<?php echo base_url() . 'bower_components/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
        <script src="<?php echo base_url() . 'bower_components/bootstrap/js/bootstrap.min.js'; ?>" ></script>

        <link href="<?php echo base_url() . 'bower_components/css/style.css'; ?>" rel="stylesheet">
        <!-- tiny mce for editor-->
        <script src='https://cdn.tiny.cloud/1/foi2wbkojq6jkme18f7bwuwct65v0zyx5ib5wkap2hj1e7w4/tinymce/5/tinymce.min.js' referrerpolicy="origin">
        </script>

        <!--select 2-->
        <link href="<?php echo base_url() . 'bower_components/select2/dist/css/select2.min.css' ?>" rel="stylesheet" />
        <script src="<?php echo base_url() . 'bower_components/select2/dist/js/select2.min.js' ?>"></script>
        <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />-->
        <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>-->
        <link rel="stylesheet" href="<?php echo base_url() . 'bower_components/fontawesome/css/all.css' ?>">

    </head>
    <header> 
        <?php $user = $this->ion_auth->user()->row(); ?>
        <nav class="navbar navbar-expand-lg navbar-light   " >
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="col-md-8">

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url() . 'Home' ?>">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('blogs') ?>">Blogs</a>
                        </li>
                        <!--                    <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Dropdown
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </li>-->

                        <li>
                            <div class="dropdown">
            <!--                    <p>Hi, <?php
                                if ($this->ion_auth->logged_in()) {
                                    echo $user->username;
                                } else
                                    echo "Sign in"
                                    ?> </p>-->
                                <a href="<?php echo base_url('/profile'); ?>"> <p class="dropbtn">Your Account</p></a>

                                <div class="dropdown-content">
                                    <a href="#">Your Blog</a>                    
                                    <?php if (!$this->ion_auth->logged_in()) { ?>
                                        <a href="<?php echo base_url('login') ?>">Sign in</a>
                                        <a href="<?php echo base_url('register') ?>">Create New Account</a>
                                        <?php
                                    } if ($this->ion_auth->logged_in()) {
                                        ?> <a href="<?php echo base_url('logout') ?>">Logout</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                </div>
            </div>
        </nav>

    </header>