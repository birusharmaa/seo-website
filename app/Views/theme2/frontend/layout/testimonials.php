<?php
if(isset($testimonials) && count($testimonials)>0){
?>
<section id="testimonial-section" class="bg-primary pt-20 pb-40">
    <div class="container bg-primary pb-5" id="main-container">
        <div class="text-center m-auto pt-4" style="width: 500px !important">
            <h2 class="pb-3 fw-bold custom-text-color">Testimonials</h2>
            <hr class="m-auto bg-success" style="width: 80px; height: 5px">
            <p class="pt-2">
            </p>
        </div>

        <div class="row gy-6 mt-5 my-class m-auto position-relative" style="width: 660px">
            <?php

            foreach ($testimonials as $testimonial) {
                $img = !empty($testimonial['business_logo']) ?
                    base_url() . '/public/uploads/img/business_logo/' . $testimonial['business_logo'] :
                    base_url() . '/public/assets/img/empty.png';
            ?>
                <div class="col-md-3 me-4 card bg-white px-3 py-2" style="width: 16rem; border-radius: 10px">
                    <div class="card-body">
                        <span><i class="fa-solid fa-quote-left fs-1 pb-3 text-success"></i></span>
                        <p class="card-text pb-3">
                            <?= $testimonial['description']; ?>
                        </p>
                        <a class="moreless-button " href="javascript:void(0)" onclick="testimonialModal('<?php echo base64_encode($testimonial['description']); ?>')" style="font-size: 12px">Read more</a>
                        <div class="row">
                            <div class="col-md-3">
                                <img class="rounded-circle" src="<?= $img; ?>" width="50px" />
                            </div>
                            <div class="col-md-9">
                                <div class="ps-2">
                                    <h5 class="fw-bold mb-0"><?= $testimonial['user_name']; ?></h5>
                                    <span class="text-secondary" style="font-size: 12px"><?= date('d-M-Y h-i A', strtotime($testimonial['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
}
?>