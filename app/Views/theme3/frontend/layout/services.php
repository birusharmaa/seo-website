<?php
if (!empty($services)) { ?>
    <section>
        <div class="services section-padding">
            <div class="container my-5">
                <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="pb-3 fw-bold text-color">Our Services</h2>
                </div>
                <div class="row ms-auto">
                    <?php foreach ($services as $service) {
                        foreach ($service as $s) {
                            if (!empty($s['image'])) {
                                $img = base_url() . "/public/uploads/service_images/" . $s['image'];
                            } else {
                                $img = base_url() . "/public/assets/img/services-img.jpg";
                            }
                    ?>
                            <div class="col-md-4" data-aos="fade-left" data-aos-duration="1000">
                                <div class="card">
                                    <div class="card-header">
                                        <img class="img-transparent rounded" src="<?= $img; ?>" width="100%" height="250px" alt="card image">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="text-color fw-bold text-truncate">
                                            <?= $s['service']; ?>
                                        </h4>
                                        <a href="<?= base_url() . '/' . 'services/' . $s['menu_link']; ?>">
                                            <button class="btn btn-light m-0">
                                                Know More
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                    <?php }
                    } ?>
                </div>

                <div class="btn_box text-center mt-4">
                    <a class="btn btn-light" href="<?= base_url(); ?>/services">
                        <button class="btn-two"><span>Services</span></button>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php }
?>