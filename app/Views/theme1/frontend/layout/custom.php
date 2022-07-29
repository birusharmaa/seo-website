<!-- <div class="container">
    <div class="row mt-30 text-center my-4">
        <h2><span class="text-color text-uppercase fw-bold">Our Custom Section</span></h2>
    </div>
</div> -->
<?php
    if (!empty($custom_section)) {
        foreach ($custom_section as $custom) {
            if($custom['id'] == $myurl['section_id']){
            $img = !empty($custom['upload_image']) ? base_url().'/public/uploads/custom_images/' . $custom['upload_image'] : base_url().'/public/assets/img/bg-empty.jpg';
        ?>
        <section style="margin-block:<?= $custom['position'] == "left" || $custom['position'] == "right" ? '30px': '0' ?>">
            <div class="container-fluid px-0 mx-0">
                <div class="row mx-0 <?= $custom['position'] == "left" || $custom['position'] == "stretch-left" ? 'flex-row-reverse' : '';  ?> aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                    <div class=" d-flex justify-content-center flex-column <?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-8 bg-white': 'col-md-6 bg-primary' ?>">
                        <div class="inside-div p-4">
                            <h2 class="pb-3 fw-bolder <?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?>"><?= $custom['heading']; ?></h2>
                            <div class="text-div text-alignment <?= $custom['position'] == "left" || $custom['position'] == "right" ? '': 'custom-text-color'?> ">
                                <?= $custom['description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $custom['position'] == "left" || $custom['position'] == "right" ? 'col-md-4': 'col-md-6' ?> px-0">
                        <div class="side-img <?= $custom['position'] == "stretch-left" || $custom['position'] == "stretch-right" ? 'h-100' : ''; ?>">
                            <img src="<?= $img; ?>" class="<?= $custom['position'] == "stretch-left" || $custom['position'] == "stretch-right" ? 'h-100' : ''; ?>" alt="" width="100%">
                        </div>
                    </div>
                </div>
        </section>
    <?php
        } 
    }
}
    
?>