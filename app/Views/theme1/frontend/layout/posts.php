                            <?php
                            if (count($posts) > 0) { ?>
                                <section class="mb-4">
                                <div class="services2 section-padding">
                                    <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                                        <h2><span class="text-color text-uppercase fw-bold">Our Updates</span></h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row m-auto">
                                                <div class="col-md-12 pb-3" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                                                    <div class="update">
                                <?php foreach ($posts as $p) {
                                    foreach ($p as $post) {
                                        $img = empty($post['image']) ? base_url() . '/public/assets/img/services3-img.png' : base_url() . '/public/uploads/post_updates_images/' . $post['image'];
                                    ?>
                                    <div>
                                        <div class="card me-3 mb-2 card-custom bg-white border-white border-0">
                                            <div class="card-custom-img">
                                                <img src="<?= $img ?>" width="100%" height="200px" alt="Avatar" />
                                            </div>
                                            <div class="card-body my-3">
                                                <h6 class="card-title text-color fw-bold"><?= date('d-M-Y', strtotime($post['created_at'])); ?></h6>
                                                <p class="card-text text-uppercase fw-bold h6 py-2"><?= $post['title']; ?></p>
                                                <a href="<?= base_url() . '/' . 'updates/' . $post['slug']; ?>">
                                                    <button class="btn btn-color rounded-pill ">
                                                        Read More
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                                } ?>
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 pb-3" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                        <div class="card card-custom bg-white border-white border-0">
                            <div class="card-body text-alignment border border-1 p-0 fw-bold">
                                <?php
                                if (count($posts) > 0) {
                                    foreach ($posts as $p) {
                                        foreach ($p as $post) {
                                ?>
                                        <div class="p-3 hover-bg">
                                            <a href="<?= base_url() . '/' . 'updates/' . $post['slug']; ?>">
                                                <p class="mb-0"><?= $post['title']; ?></p>
                                                <p class="mb-0"><?= date("d-M-Y", strtotime($post['created_at'])); ?></p>
                                            </a>
                                        </div>
                                        <hr class="w-100 m-0">
                                <?php
                                    }
                                }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                            <?php } 
                            ?>
                        