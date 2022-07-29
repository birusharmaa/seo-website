
            <?php
            if (!empty($services)) { ?>
            <section>
    <div class="services section-padding">
        <div class="text-center mb-5">
            <h2><span class="text-color text-uppercase fw-bold">Our Services</span></h2>
        </div>
        <div class="row ms-auto">
            <?php

                foreach ($services as $service) {
                    foreach ($service as $s) {
                        if (!empty($s['image'])) {
                            $img = base_url() . "/public/uploads/service_images/" . $s['image'];
                        } else {
                            $img = base_url() . "/public/assets/img/services-img.jpg";
                        }

            ?>
            <div class="col-md-3" data-aos="fade-left" data-aos-duration="1000">
                <div class="image-flip mt-4">
                    <div class="mainflip flip-0 ">
                        <div class="frontside shadow">
                            <img class="img-transparent rounded" src="<?= $img; ?>" width="100%" height="250px" alt="card image">
                            <div class="transparent-text position-absolute w-100 p-4 rounded-bottom">
                                <h4 class="text-color fw-bold text-center">
                                    <?= $s['service']; ?>
                                </h4>
                            </div>
                        </div>
                        <div class="backside position-absolute w-100">
                            <div class="card bg-dark">
                                <div class="card-body text-center mt-4">
                                    <div class="div-width">
                                        <a href="<?= base_url() . '/' . 'services/' . $s['menu_link']; ?>">
                                            <button class="btn btn-color fs-5 py-3 px-4 rounded-pill align-center">
                                                Know More
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                    }
                }
                ?>
                        </div>
    </div>
<section> <?php
            }
            ?>
