<!-- <div class="container">
    <div class="row mt-30">
        <h2 class="text-center text-color">Our Custom Section</h2>
    </div>
</div> -->

<?php
    if (!empty($custom_section)) {
        foreach ($custom_section as $custom) {
            $img = !empty($custom['upload_image']) ? base_url().'/public/uploads/custom_images/' . $custom['upload_image'] : base_url().'/public/assets/img/bg-empty.jpg';
        ?>
        <section>
            <div class="container-fluid px-0 mx-0">
                <div class="row bg-danger gy-90 <?= $custom['position'] == "left" || $custom['position'] == "stretch-left" ? 'flex-row-reverse' : '';  ?>">
                    <div class="px-10 <?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-8 bg-white': 'col-md-6 bg-primary' ?>">
                        <div class="p-20 d-flex justify-content-center flex-column h-100"> 
                            <h3 class="mb-0 <?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?>"><?= $custom['heading']; ?></h3>
                            <div class="<?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?>" data-show="startbox" data-show-delay="200" style="text-align:justify; padding-right:10px;">
                                <?= $custom['description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="px-0 <?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-4': 'col-md-6' ?>">
                        <img class="w-100 <?= $custom['position'] == "stretch-left" || $custom['position'] == "stretch-right" ? 'h-100' : ''; ?>" loading="lazy" src="<?= $img ?>" />
                    </div>
                </div>
            </div>
        </section>
    <?php
        }
    }
?>