<?= $this->extend("theme1/frontend/layout/master") ?>
<?= $this->section("customCss") ?>
<style>
    .card-big-shadow:before {
        background-image: url("<?= base_url()?>/public/assets/img/shadow.png");
        background-position: center bottom;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        bottom: -12%;
        content: "";
        display: block;
        left: -12%;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 0;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section("contentTheme1") ?>
<div class="product-page overflow-hidden">
    
    <section>
        <div class="row mx-auto">
            <div class="col-md-12 p-0" data-aos="fade-down" data-aos-duration="1000">
                <div class="heroContent " style="left: 36%;">
                    <h1 class="fw-bold text-color"><?= $slugs ?></h1>
                    <div>
                        <p class="text-white">
                            <a class="text-decoration-none fw-bold text-light " href="<?= base_url(); ?>/">
                                Home >
                            </a>
                            <?= $slugs ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ------Slider------- -->
    <?= $this->include('theme1/frontend/layout/slider') ?>

    <!-- ----- Our Custom Section ------- -->
    <?= $this->include('theme1/frontend/layout/custom') ?>

    <!-- ----- Our Services------- -->
    <?= $this->include('theme1/frontend/layout/services') ?>
    
    <!-- ----------Our Products------ -->
    <?= $this->include('theme1/frontend/layout/products');?>

    <!-- ---------Our Updates-------- -->
    <?= $this->include('theme1/frontend/layout/posts');?>

    <!-- --------Our Videos----------- -->
    <?= $this->include('theme1/frontend/layout/videos') ?>

    <!-- --------Image Gallery---------- -->
    <?= $this->include('theme1/frontend/layout/galleries') ?>

    <!-- --------Testimonial section---------- -->
    <?= $this->include('theme1/frontend/layout/testimonials') ?>

    <!-- --------Our Faq lists----------- -->
    <!-- <?//= $this->include('theme1/frontend/layout/faq_lists') ?> -->

    <!-- --------Contact Us---------- -->
    <section class="mb-4 overflow-hidden">
        <div class="contact section-padding">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                <h6 class="section-title text-center text-primary text-uppercase">Contact Us</h6>
                <h2> <span class="text-color text-uppercase fw-bold">Contact us the Get Started</span></h2>
            </div>
            <div class="row py-4 gx-5">
                <div class="col-md-6 d-flex " data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000">
                    <div class="w-100 top-border">
                        <iframe class="location-height" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%;border-radius:16px; height:320px;"></iframe>
                    </div>
                </div>
                <div class="col-md-6 " data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                    <div class="top-border responsive-form">
                        <?= $this->include('theme1/frontend/layout/message'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
<?= $this->section("customScripts") ?>
<script>
    $(function() {
        AOS.init();
    });
</script>
<?= $this->endSection() ?>