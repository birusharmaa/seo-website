<?= $this->extend('theme3/frontend/layout/master') ?>
<?= $this->section('customCss') ?>

<?= $this->endSection() ?>
<?= $this->section('contentTheme3');?>

<?php
foreach($sort_order as $myurl){
    if($myurl['url_val'] != "contact"){
      include('layout/'.$myurl['url_val'].'.php');
    }
}
?>

<?= $this->endSection() ?>
<?= $this->section('customScripts') ?>
<?= $this->endSection() ?>