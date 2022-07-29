<!-- <div class="container">
    <div class="text-center my-5">
        <h2 class="pb-3 fw-bold text-color">Our Custom Section</h2>
    </div>
</div> -->
<?php
    if (!empty($custom_section)) {
        foreach ($custom_section as $custom) {
            $img = !empty($custom['upload_image']) ? base_url().'/public/uploads/custom_images/' . $custom['upload_image'] : base_url().'/public/assets/img/bg-empty.jpg';
        ?>
        <section>
            <div class="container-fluid px-0 mx-0">
                <div class="row mx-0 <?= $custom['position'] == "left" || $custom['position'] == "stretch-left" ? 'flex-row-reverse' : '';  ?> aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                    <div class="px-10 <?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-8 bg-white': 'col-md-6 bg-primary' ?>">
                        <div class="d-flex justify-content-center flex-column h-100 p-4">
                            <h2 class="pb-3 fw-bolder <?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?> " data-show="startbox"><?= $custom['heading']; ?></h2>
                            <div class="text-div text-alignment <?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?> " data-show="startbox">
                                <?= $custom['description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-4': 'col-md-6' ?> px-0">
                        <div class="side-img <?= $custom['position'] == "stretch-left" || $custom['position'] == "stretch-right" ? 'h-100' : ''; ?>">
                            <img src="<?= $img; ?>" alt="" width="100%" class="<?= $custom['position'] == "stretch-left" || $custom['position'] == "stretch-right" ? 'h-100' : ''; ?>">
                        </div>
                    </div>
                </div>
        </section>
    <?php
        }
    }
?>