            <?php
            if (!empty($products)) { ?>
                <section>
    <div class="products section-padding" data-aos="fade-up">
        <div class="text-center mb-5">
            <h2><span class="text-color text-uppercase fw-bold">Our Products</span></h2>
        </div>
        <div class="row mx-auto">
                <?php foreach ($products as $product) {
                    foreach ($product as $p) {
                        
                        $img = !empty($p['main_image']) ? base_url() . "/public/uploads/product_images/" . $p['main_image'] : base_url() . "/public/assets/img/product1.jpg";
                ?>
                        <div class="col-md-3 col-sm-6 content-card" data-aos="fade-right" data-aos-duration="1000">
                            <div class="card-big-shadow position-relative mb-5">
                                <div class="card product-card card-just-text text-dark position-relative mb-3" data-background="color" data-color="blue" data-radius="none">
                                    <div class="content pb-4 text-center">
                                        <a href="<?= base_url();?>/products/<?= $p['menu_link'];?>"> <img src="<?= $img; ?>" width="100%" height="220px" alt=""></a>
                                        <h6 class="category text-truncate fw-bold pt-3 text-hover"><?= $p['product_name']; ?></h6>
                                        <button class="btn search-btn rounded-pill ms-2 responsive-btn" data-bs-target="#inquiryModal" data-bs-toggle="modal" type="submit">
                                            Enquiry Now
                                        </button>
                                    </div>
                                </div> <!-- end card -->
                            </div>
                        </div>
            <?php
                    }
                } ?>
                </div>
                </div>
                </section>
            <?php }
            ?>
        