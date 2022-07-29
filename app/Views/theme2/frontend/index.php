<?= $this->extend('theme2/frontend/layout/master') ?>
<?= $this->section('customCss') ?>
<!-- <style>
    /* write all your custom css here */
</style> -->
<?= $this->endSection() ?>


<?= $this->section('contentTheme2');
    foreach($sort_order as $myurl){
        if($myurl['url_val'] != "contact"){
          include('layout/'.$myurl['url_val'].'.php');
        }
    }

$this->endSection() ?>
<?= $this->section('customScripts') ?>
<!-- <script>
    //write all your custom script here
</script> -->
<?= $this->endSection() ?>