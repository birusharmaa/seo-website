<?php

if (!empty($products)) { ?>
    <div class="pt-60 bg-gray-light callToActionPrev">
        <div class="container">
            <div class="row mb-50 mt-20 ">
                <div class="col-md-4 offset-md-4 mt-5 text-center">
                    <h2 class="m-0 text-color" data-show="startbox" data-show-delay="100">
                        Our products
                    </h2>
                </div>
            </div>
            <div class="row gy-30">
                <?php
                foreach ($products as $product) {
                    foreach ($product as $p) {

                        $img = !empty($p['main_image']) ? base_url() . "/public/uploads/product_images/" . $p['main_image'] : base_url() . "/public/assets/img/product1.jpg";
                ?>
                        <div class="col-12 col-md-4" data-show="startbox">
                            <div class="service-case lift rounded-4 bg-white shadow overflow-hidden">
                                <a class="service-case-image" href="#" data-img-height style="--img-height: 64%"><img loading="lazy" src="<?= $img; ?>" alt="" /></a>
                                <div class="service-case-body position-relative">
                                    <h4 class="service-case-title text-truncate mb-5"><?= $p['product_name']; ?></h4>
                                    <div class="service-case-text font-size-15 mb-5 two-line-truncate">
                                        <?= $p['short_description'] ?>
                                    </div>
                                    <a class="service-case-arrow stretched-link" href="<?= base_url() . '/' . 'products/' . $p['menu_link']; ?>">
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="text-center mb-80 py-80">
                <div data-show="startbox">
                    <a class="btn btn-light" href="<?= base_url(); ?>/products">
                        All Products
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }
?>