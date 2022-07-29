<section>
    <?php
    if (!empty($sliders)) {
        foreach ($sliders as $slider) {
            echo '<div class="one-time">';
            foreach ($slider as $key => $sldr) {
    ?>
                <div>
                    <div class="slider-height" style="background-image:url(<?= base_url(); ?>/public/uploads/slider_images/<?= $sldr['image']; ?>)">
                        <div class="row align-items-start flex-column justify-content-center h-100">
                            <div class="col-md-5 offset-md-1">
                                <div class='detail-box'>
                                    <h2 style="color:<?= $sldr['heading_color']; ?>; font-family:<?= $sldr['title_style']; ?> !important;"><?= $sldr['title']; ?></h2>
                                    <p style="color:<?= $sldr['text_color']; ?>; font-family:<?= $sldr['desc_style']; ?>;">
                                        <?= $sldr['desc']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
            echo '</div>';
        }
    }
    ?>
</section>