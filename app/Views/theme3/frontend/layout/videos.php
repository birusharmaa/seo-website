<?php
if (count($videoes) > 0) {
?>
    <section class="my-5 bg-gray-light">
        <div class="videos section-padding container pt-5" data-aos="fade-up">
            <div class="text-center">
                <h2 class="mb-0 fw-bold text-color">Our Videos</h2>
            </div>
            <div class="row pb-4 mt-4">
                <?php
                //bb_print_r($videoes);
                foreach ($videoes as $video) {
                    $img = !empty($video['thumbnail_images']) ? base_url() . '/public/uploads/thumbnail_images/' . $video['thumbnail_images'] : base_url() . '/public/assets/img/video-thumb.jpg';
                ?>
                    <div class="col-md-4 " data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                        <div class="inner-column card mb-2">
                            <div class="position-relative w-100" style="margin-top: 30px;">
                                <!-- <iframe  src="" frameborder="0" 
                                    allow="accelerometer; autoplay; encrypted-media; 
                                    gyroscope; picture-in-picture" allowfullscreen>
                                </iframe> -->
                                <a class="popup-youtube" href="<?= $video['url'] ?>">
                                    <img class="card-img-top img-fluid" title="<?= $video['title']; ?>" src="<?= $img; ?>" style="height:220px;" />
                                    <br />
                                    <h4 class="text-center text-truncate"><?= $video['title']; ?></h4>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </section>
<?php
}
?>