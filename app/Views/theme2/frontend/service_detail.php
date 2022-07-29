<?= $this->extend('theme2/frontend/layout/master') ?>
<?= $this->section('customCss') ?>
<!-- <style>
    /* write all your custom css here */
</style> -->
<?= $this->endSection() ?>

<?= $this->section('contentTheme2') ?>
<div class="position-relative pb-50 pt-100 ">
    <div class="background">
        <div class="background-image jarallax" data-jarallax data-speed="0.8">
            <!-- <img class="jarallax-img" loading="lazy" src="<? //= base_url(); 
                                                                ?>/theme2/assets/img/about-us-hero-1920x900.jpg" alt=""> -->
        </div>
        <div class="background-color" style="--background-color: #000; opacity: .25;"></div>
    </div>
    <div class="container">
        <h1 class="text-white mb-0 text-center">Our Services</h1>
    </div>
</div>
<div class="container-fluid pb-60 bg-gray-light">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <?php
                $img = !empty($service['banner']) ? base_url()."/public/uploads/service_banners/" . $service['banner'] : base_url()."/public/assets/img/service1.jpg";
            ?>
            <img src="<?= $img; ?>" class="mt-10" width="100%" alt="">
            <div class="bg-dark p-2 my-2">
                <h4 class="text-color my-20 fw-bold text-center pt-1"><?= $service['service']; ?></h4>
            </div>
            <div class="content p-3 text-alignment">
                <?= $service['content']; ?>
            </div>
        </div>
    </div>
</div>

<div class="pt-30 bg-gray-light callToActionPrev">
    <div class="container">
        <div class="row mb-90">
            <div class="col-lg-4 offset-lg-4 text-center">
                <h2 class="m-0" data-show="startbox" data-show-delay="100">
                    Our services
                </h2>
            </div>
        </div>
        <div class="row gy-30">
            <?php
            if (!empty($all_services)) {
                foreach ($all_services as $service) {                        
                        if (!empty($service['image'])) {
                            $img = base_url() . "/public/uploads/service_images/" . $service['image'];
                        } else {
                            $img = base_url() . "/public/assets/img/services-img.jpg";
                        }

            ?>
                        <div class="col-12 col-md-6 col-lg-4" data-show="startbox">
                        <div class="service-case lift rounded-4 bg-white shadow overflow-hidden">
                            <a class="service-case-image" href="<?= base_url() . '/' . 'services/' . $service['menu_link']; ?>" data-img-height style="--img-height: 64%">
                                <img loading="lazy" src="<?= $img; ?>" alt="" />
                            </a>
                            <div class="service-case-body position-relative">
                                <h4 class="service-case-title text-truncate mb-15"><?= $service['service']; ?></h4>
                                <p class="service-case-text font-size-15 mb-30">
                                    <?= $service['short_description']; ?>
                                </p>
                                <a class="service-case-arrow stretched-link" href="<?= base_url() . '/' . 'services/' . $service['menu_link']; ?>">
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php }
                }
             else {
                echo "<h4 class='text-center'>No services found!</h4>";
            }
            ?>
        </div>
        <div class="text-center mt-80 mb-40">
            <div data-show="startbox">
                <a class="btn btn-light" href="<?= base_url(); ?>/services">
                    All Services
                </a>
            </div>
        </div>
    </div>
</div>
    

    <?= $this->endSection() ?>
    <?= $this->section('customScripts') ?>
    <!-- <script>
        //write all your custom script here
    </script> -->
    <?= $this->endSection() ?>