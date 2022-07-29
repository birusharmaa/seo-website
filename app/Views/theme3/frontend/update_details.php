<?= $this->extend("theme3/frontend/layout/master") ?>
<?= $this->section("customCss") ?>
<style>
    .card-body {
        padding: 0px !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section("contentTheme3") ?>
<div class="update-page">
    <section>
        <div class="content-wrap">
            <div class="position-relative backimg">
                <nav class="crumb" aria-label="breadcrumb">
                    <ol class="breadcrumb  justify-content-center">
                        <div class="skew chng">
                            <p class="text-dark">
                                <a class="text-decoration-none text-primary fw-bold" href="<?= base_url(); ?>/">
                                    Home->
                                </a>
                                <?= $update ?>
                            </p>
                        </div>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="section-padding">
            <section>
                <div class="update-slider section-padding container">
                    <div class="text-center my-5">
                        <h1 class="pb-3 fw-bold">Our Updates</h1>
                    </div>

                    <div class="row values mb-5">
                        <?php
                        if (count($all_post) > 0) {
                            foreach ($all_post as $post) {
                                $img = empty($post['image']) ? base_url().'/public/assets/img/services3-img.png' : base_url().'/public/uploads/post_updates_images/' . $post['image'];
                                ?>
                                <div class="col-md-4 d-flex align-items-stretch aos-init aos-animate mb-5" data-aos="fade-up">
                                    <div class="card w-100  border-0 position-relative" style="background-image: url(<?= $img; ?>); height: 250px;">
                                        <div class="card-body py-3 d-flex align-items-center justify-content-center flex-column h-100">
                                            <h5 class="card-title">
                                                <h6 class="card-title fw-bold text-center"><?= date('d-M-Y', strtotime($post['created_at'])); ?></h6>
                                            </h5>
                                            <p class="card-text texts text-center text-uppercase fw-bold h6 "><?= $post['title']; ?></p>
                                            <div class="text-center mb-3">
                                                <a href="<?= base_url() .'/' . 'updates/' . $post['slug']; ?>">
                                                    <button class="btn btn-color text-white rounded-pill  ">
                                                        Read More
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<h4>No update found.</h4>";
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>

<!-- --------Our Custom section----------- -->
<?= $this->include('theme3/frontend/layout/custom') ?>

<!-- --------Our Videos----------- -->
<?= $this->include('theme3/frontend/layout/videos') ?>

<!-- --------Image Gallery---------- -->
<?= $this->include('theme3/frontend/layout/galleries') ?>
	
<!-- --------Testimonial section---------- -->
<?= $this->include('theme3/frontend/layout/testimonials') ?>

<?= $this->endSection() ?>


<?= $this->section("customScripts") ?>
<script type="text/javascript" src="<?= base_url() .'/' . 'theme1/assets/js/pages/common.js' ?>"></script>

<script>
    $(function() {
        AOS.init();
    });
</script>

<?= $this->endSection() ?>