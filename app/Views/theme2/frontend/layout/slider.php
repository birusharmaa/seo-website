<div class="swiper bg-dark" data-swiper-slides="1" data-swiper-speed="1000" data-swiper-grabcursor="true" data-swiper-parallax="true" data-swiper-pagination="true">
    <div class="swiper-pagination text-white position-absolute mb-30 start-0 w-100 d-none d-lg-block">
    </div>
        <?php
            if(!empty($sliders)){
                foreach($sliders as $slider){
                    if ($slider['section_id'] == $myurl['section_id']) {
                    echo '<div class="swiper-container">
                    <div class="swiper-wrapper">';
                    unset($slider['section_id']);
                    foreach($slider as $sldr){
                    ?>
                        <div class="swiper-slide slider-height">
                            <div class="py-200 position-relative overflow-hidden h-100">
                                <div class="background">
                                    <div class="background-image">
                                        <img loading="lazy" src="<?= base_url(); ?>/public/uploads/slider_images/<?= $sldr['image']; ?>" data-swiper-parallax-x="20%" alt="" />
                                    </div>
                                    <div class="background-color" style="--background-color: #000; opacity: 0.25">
                                    </div>
                                    <div class="background-color" style="
                                        background-image: linear-gradient(
                                        180deg,
                                        rgba(0, 0, 0, 0.3) 0%,
                                        rgba(0, 0, 0, 0) 150px
                                        );
                                    ">
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5 offset-md-1">
                                            <div class='detail-box'>
                                                <h2 style="color:<?= $sldr['heading_color']; ?>; font-family:<?= $sldr['title_style'];?> !important;"><?= $sldr['title']; ?></h2>
                                                <p style="color:<?= $sldr['text_color']; ?>; font-family:<?= $sldr['desc_style'];?>;">
                                                    <?= $sldr['desc']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                    echo '</div>
                    </div>';
                }
            } ?>
        
    <div class="swiper-button-prev swiper-button-position-3 swiper-button-opacity shadow">
        <i class="fa-solid fa-arrow-left-long"></i>
    </div>
    <div class="swiper-button-next swiper-button-position-3 swiper-button-opacity shadow">
        <i class="fa-solid fa-arrow-right-long"></i>
    </div>
</div>