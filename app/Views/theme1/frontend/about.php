<?= $this->extend("theme1/frontend/layout/master") ?>
<?= $this->section("customCss") ?>
<?= $this->endSection() ?>
<?= $this->section("contentTheme1") ?>
<div class="about-us-page">
<?php

    foreach($sort_order as $myurl){
        if($myurl['url_val'] != "contact"){
            include('layout/'.$myurl['url_val'].'.php');
        }
        else
        { 
        ?>
            <!-- --------Contact Us---------- -->
            <!-- <section class="mb-4">
                <div class="contact section-padding">
                    <div class="text-center mb-5">
                        <h1>Contact us the <span class="text-color text-uppercase fw-bold">Get Started</span></h1>
                    </div>
                    <div class="row py-4 gx-5">
                        <div class="col-md-6 d-flex">
                            <div class="w-100 top-border">
                                <iframe class="location-height" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%;border-radius:16px; height:320px;"></iframe>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="top-border responsive-form">
                                <?= $this->include('theme1/frontend/layout/message'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
        <?php 
        }    
    }
    ?>
</div>

<?= $this->endSection() ?>
<?= $this->section("customScripts") ?>
<script>
    $(function() {
        AOS.init();
    });
    
</script>
<?= $this->endSection() ?>