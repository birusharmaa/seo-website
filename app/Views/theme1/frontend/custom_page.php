<?= $this->extend("theme1/frontend/layout/master") ?>
<?= $this->section("customCss") ?>
<style>
    .card-body {
        padding: 0px !important;
    }

    a {
        text-decoration: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section("contentTheme1") ?>
<section>
    <div class="row mx-auto">
        <div class="col-md-12 p-0" data-aos="fade-up" data-aos-duration="1000">
            <div class="heroContent">
                <h1 class="fw-bold text-color"><?= ucwords($title); ?></h1>
                <div>
                    <p class="text-white">
                        <a class="text-decoration-none fw-bold text-light " href="<?= base_url(); ?>/">
                            Home->
                        </a>
                        <?= $slug ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>   
<?php
if(!empty($custom_data)){
    $img = !empty($custom_data['image'])?base_url()."/public/uploads/custom_pages_image/".$custom_data['image']:"";
    ?>
    <section>
        <div class="services2 section-padding">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if(!empty($custom_data['image'])){
                            ?>
                                <img src="<?= $img;?>" alt="" class="w-100" style="max-height: 500px; object-fit:cover;">
                            <?php    
                    }
                    ?>
                   
                    <div class="bg-dark p-2 my-2">
                        <h4 class="text-color fw-bold text-center pt-1"><?= $custom_data['heading']; ?></h4>
                    </div>
                    <div class="content p-3 text-alignment">
                        <?= $custom_data['content']; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}else{
    echo $this->include('theme1/frontend/layout/videos');
    echo $this->include('theme1/frontend/layout/galleries');
}
?>
    

    <!-- --------Our Videos----------- -->
    


<?= $this->endSection() ?>


<?= $this->section("customScripts") ?>
<script>
    $(function() {
        AOS.init();
    });
</script>

<?= $this->endSection() ?>