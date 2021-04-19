<?php $this->load->view('lib-site/header'); ?>
<?php
$uri1 = $this->uri->segment(1);

if ($uri1 == 'profile') {
    $this->load->view('lib-site/sidebar');
}
?>
<!--<div style="min-height: 100%;display: grid;grid-template-rows:auto 1fr auto;">-->

<?php $this->load->view($main_content); ?>
<!--</div>-->
<?php $this->load->view('lib-site/footer'); ?>


