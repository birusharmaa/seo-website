            <?php
            if (count($posts) > 0) { ?>
                <section class="mb-4">
                    <div class="services2 section-padding container">
                        <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                            <h2><span class="text-color text-uppercase fw-bold">Our Updates</span></h2>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <div class="update">
                                    <?php foreach ($posts as $p) {
                                        foreach ($p as $post) {
                                            $img = empty($post['image']) ? base_url() . '/public/assets/img/services3-img.png' : base_url() . '/public/uploads/post_updates_images/' . $post['image'];
                                    ?>
                                            <div>
                                                <div class="card border-0 position-relative mx-20" style="background-image: url(<?= $img; ?>">
                                                    <div class="card-body py-3 d-flex align-items-center justify-content-center flex-column" style="min-height:200px;">
                                                        <h6 class="card-title fw-bold text-center"><?= date('d-M-Y', strtotime($post['created_at'])); ?></h6>
                                                        <p class="text-center text-uppercase fw-bold"><?= $post['title']; ?></p>
                                                        <div class="text-center mb-3">
                                                            <a href="<?= base_url() . '/' . 'updates/' . $post['slug']; ?>">
                                                                <button class="btn btn-color text-white rounded-pill  ">
                                                                    Read More
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            <?php }
            ?>