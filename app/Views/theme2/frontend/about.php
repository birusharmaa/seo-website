<?= $this->extend('theme2/frontend/layout/master') ?>
<?= $this->section('customCss') ?>
<!-- <style>
    /* write all your custom css here */
</style> -->
<?= $this->endSection() ?>
<?= $this->section('contentTheme2') ?>

<?php
$cls = "pt-100";
if (!empty($sliders)) {
    $cls = "pt-50";
}
?>

<div class="position-relative pb-100 <?= $cls; ?> ">
    <div class="background">
        <div class="background-image jarallax" data-jarallax data-speed="0.8">
        </div>
        <div class="background-color" style="--background-color: #000; opacity: .25;"></div>
    </div>
    <div class="container">
        <h1 class="text-white mb-0 text-center">About Us</h1>
    </div>
</div>
<?php
foreach($sort_order as $myurl){
    if($myurl['url_val'] != "contact"){
      include('layout/'.$myurl['url_val'].'.php');
    }
}
?>


<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<!-- <script>
    //write all your custom script here
</script> -->
<?= $this->endSection() ?>