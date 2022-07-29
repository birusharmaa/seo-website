<?php
if (!empty($services)) { ?>
    <div class="pt-30 bg-gray-light callToActionPrev">
        <div class="container">
            <div class="row mb-90">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <h2 class="m-0 text-color" data-show="startbox" data-show-delay="100">
                        Our services
                    </h2>
                </div>
            </div>
            <div class="row gy-30">
                <?php
                foreach ($services as $service) {
                    foreach ($service as $s) {
                        if (!empty($s['image'])) {
                            $img = base_url() . "/public/uploads/service_images/" . $s['image'];
                        } else {
                            $img = base_url() . "/public/assets/img/services-img.jpg";
                        }

                ?>
                        <div class="col-12 col-md-6 col-lg-4" data-show="startbox">
                            <div class="service-case lift rounded-4 bg-white shadow overflow-hidden">
                                <a class="service-case-image" href="<?= base_url() . '/' . 'services/' . $s['menu_link']; ?>" data-img-height style="--img-height: 64%">
                                    <img loading="lazy" src="<?= $img; ?>" alt="" />
                                </a>
                                <div class="service-case-body position-relative">
                                    <h4 class="service-case-title text-truncate mb-15"><?= $s['service']; ?></h4>
                                    <p class="service-case-text font-size-15 mb-30">
                                        <?= $s['short_description']; ?>
                                    </p>
                                    <a class="service-case-arrow stretched-link" href="<?= base_url() . '/' . 'services/' . $s['menu_link']; ?>">
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="text-center mt-80">
                <div data-show="startbox">
                    <a class="btn btn-light" href="<?= base_url(); ?>/services">
                        All Services
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }
?>