<?= $this->extend('theme3/frontend/layout/master') ?>
<?= $this->section('customCss') ?>
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<style>
    .swiper {
        width: 100%;
        height: 400px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('contentTheme3'); ?>

<?php
foreach($sort_order as $myurl){
    if($myurl['url_val'] != "contact"){
      include('layout/'.$myurl['url_val'].'.php');
    }
}
?>

<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<!-- <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script> -->
<?= $this->endSection() ?>