<?php $this->load->view('lib-site/header'); ?>
<?php $uri1 = $this->uri->segment(1);

if ($uri1 == 'profile'){
    $this->load->view('lib-site/sidebar');
    
}?>

<?php $this->load->view($main_content); ?>
<?php $this->load->view('lib-site/footer'); ?>


