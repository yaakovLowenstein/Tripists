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
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark top-nav" style="margin-bottom: 0;height: 30px;">
            <!--<a class="navbar-brand" href="#">Navbar</a>-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto " style="margin-right:30%">
                    <?php if (!isset($user)) { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('login') ?>" style="display: inline;padding: 0;">Login/ </a>
                            <a class="nav-link" href="<?php echo base_url('register') ?>" style="display: inline;padding: 0;">Register </a>
                        </li>

                    <?php } ?>

                    <?php if (isset($user)) { ?>


                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('profile') ?>">Account</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('profile/subscriptions') ?>">Subscriptions </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('profile/messages/list') ?>">Messages </a>
                        </li>
                        <li class="nav-item active dropdown" >
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Likes
                            </a>
                            <div class="dropdown-menu  bg-dark"  aria-labelledby="navbarDropdown" >

                                <a class="nav-link dropdown-item" href="<?php echo base_url('profile/liked/blogs') ?>">Blogs</a>
                                <a class="nav-link dropdown-item" href="<?php echo base_url('profile/liked/attractions') ?>">Attraction</a>
                                <a class="nav-link dropdown-item" href="<?php echo base_url('profile/liked/restaurants') ?>">Restaurants</a>
                            </div>

                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('profile/blogs') ?>">Blogs </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('logout') ?>">Logout </a>
                        </li>



                    <?php } ?>
                    <!--                    <li class="nav-item">
                                            <a class="nav-link" href="#">Link</a>
                                        </li>-->
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
                    <li class="nav-item">
                        <!--<a class="nav-link disabled" href="#">Disabled</a>-->
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <!--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
                    <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
                </form>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light main-nav" style="margin-bottom: 0;background:#47c4e1 !important; text-align: left; ">
            <!--<a class="navbar-brand" href="#">Navbar</a>-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ml-auto" style="font-size: 25px;height: 65px;margin-right: 30%">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url(); ?>">Home </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("blogs")?>">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("attractions")?>">Attractions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("restaurants")?>">Restaurants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("bloggers/list")?>">Bloggers</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDroapdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Destinations
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo base_url("destinations/map")?>">Map</a>
                            <a class="dropdown-item" href="<?php echo base_url("destinations/list")?>">List</a>

                        </div>
                    </li>
                    <!--                    <li class="nav-item">
                                            <a class="nav-link disabled" href="#">Disabled</a>
                                        </li>-->
                </ul>
                <!--                <form class="form-inline my-2 my-lg-0">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form>-->
            </div>
        </nav>
    </header>