<?php
if (!empty($sliders)) {
    foreach ($sliders as $slider) {
        if ($slider['section_id'] == $myurl['section_id']) {
    ?>
        <div class="hero_area">
            <section class="slider_section">
                <div class="swiper slider-height">
                    <div class="swiper-wrapper">
                        <?php
                        unset($slider['section_id']);
                        foreach ($slider as $sldr) {
                        ?>
                            <div class="swiper-slide">
                                <div class='container-fluid sliders-img slider-height' style="background-image:url(<?= base_url() ?>/public/uploads/slider_images/<?= $sldr['image'] ?>)">
                                    <div class='row h-100'>
                                        <div class='col-md-5 offset-md-1'>
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
                        <?php
                        }
                        
                    echo '</div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </section>
        </div>';

    
    }
}
    ?>
<?php
}
?>

<!--                         
                
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
</div> -->