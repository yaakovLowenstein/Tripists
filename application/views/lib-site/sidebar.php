
<link rel="stylesheet" href="<?php echo base_url('bower_components/css/sidebar-style.css') ?>">
<?php
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
$uri3 = $this->uri->segment(3);

$user = $this->ion_auth->user()->row();
$unreadCount = $this->profile_model->getUnreadMessagesCount($user->id);
?>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar" style="margin-right: 4%;">
        <div class="sidebar-header " style="text-align:center">
            <h1>Tripists</h1>
        </div>

        <ul class="list-unstyled components">
            <!--<p>Account</p>-->
            <li class = "<?php if ($uri2 == '') { ?><?php } ?>">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Account</a>
                <ul class="collapse list-unstyled show" id="homeSubmenu">
                    <li>
                        <a  href="<?php echo base_url('profile') ?>" class = "<?php if ($uri1 == 'profile' && !isset($uri2)) { ?>sidebar-active<?php } ?>">Account Info  </a>                
                    </li>
                    <li>
                        <a  href="<?php echo base_url('profile/subscriptions') ?>" class = "<?php if ($uri2 == 'subscriptions') { ?>sidebar-active<?php } ?>">Subscriptions  </a>                
                    </li>

                    <li>
                        <a href="#LikesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Likes</a>
                        <ul class="collapse list-unstyled <?php
                        if ($uri2 == 'liked') {
                            echo 'show';
                        }
                        ?>" id="LikesSubmenu">
                            <li>
                                <a  href="<?php echo base_url('profile/liked/blogs') ?>" class = "<?php if ($uri3 == 'blogs') { ?>sidebar-active<?php } ?>">Blogs  </a>                
                            </li>
                            <li>
                                <a  href="<?php echo base_url('profile/liked/attractions') ?>" class = "<?php if ($uri3 == 'attractions') { ?>sidebar-active<?php } ?>">Attractions  </a>                
                            </li>
                            <li>
                                <a  href="<?php echo base_url('profile/liked/restaurants') ?>" class = "<?php if ($uri3 == 'restaurants') { ?>sidebar-active<?php } ?>">Restaurants  </a>                
                            </li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li >
                <a  href="<?php echo base_url('profile/messages/list') ?>" class = "<?php if ($uri2 == 'messages') { ?>sidebar-active<?php } ?>">Messages
                    <?php if ($unreadCount > 0) { ?>
                        <span class="unread-icon" data-toggle="tooltip" data-placement="top" title="Unread Messages" >
                            <span class="unread-icon-num"> <?php echo $unreadCount; ?></span>

                        </span>
                    <?php } ?>
                </a>
            </li>
            <!--            <li>
                            <a href="#">About</a>
                        </li>
                        <li>
                            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Blogs </a>
                            <ul class="collapse list-unstyled" id="pageSubmenu">
                                <li>
                                   
                                <li>
                                    <a href="#">Page 2</a>
                                </li>
                                <li>
                                    <a href="#">Page 3</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Portfolio</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
            
                    <ul class="list-unstyled CTAs">
                        <li>
                            <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                        </li>
                        <li>
                            <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                        </li>-->
        </ul>
        <ul class="list-unstyled components">
            <span style="text-align: center"><p>Want to Blog? </br>Click <a href="<?php echo base_url("profile/blogs") ?>" style="text-decoration: underline">Here</a> to get started!</p></span>
            <li>
                <a  href="<?php echo base_url('profile/dashboard') ?>" class = "<?php
                if ($uri2 == 'dashboard') {
                    echo 'sidebar-active';
                }
                ?>">Dashboard  </a>                
            </li> 
            <li>
                <a  href="<?php echo base_url('profile/blogs') ?>" class = "<?php
                if ($uri2 == 'blogs') {
                    echo 'sidebar-active';
                }
                ?>">Blogs  </a>                
            </li> 

        </ul>
    </nav>
    <!--<div class="main" >-->

