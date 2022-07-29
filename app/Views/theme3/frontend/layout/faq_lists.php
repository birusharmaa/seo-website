<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="accordion" id="accordionExample">
                    <?php
                    if (!empty($fq_lists)) {
                        echo '<h2 class="text-center fw-bold mb-2 text-color">Our FAQ </h2>';
                        //bb_print_r($fq_lists);
                        foreach ($fq_lists as $fq_list) {
                            foreach ($fq_list as $faq) {
                                // bb_print_r($faq)
                    ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $faq['id']; ?>" aria-expanded="true" aria-controls="collapse<?= $faq['id']; ?>">
                                            <?= $faq['title']; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $faq['id']; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <?= $faq['content']; ?>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

