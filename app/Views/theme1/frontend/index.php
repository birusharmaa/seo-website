<?= $this->extend("theme1/frontend/layout/master") ?>
<?= $this->section("customCss") ?>
<style>
    a {
        text-decoration: none !important;
    }

    #appo-button {
        position: fixed;
        bottom: 50%;
        right: -500%;
        transform: translateY(50%);
        z-index: 9999;
        transition: right .5s;
    }

    #appo-button.button-open {
        right: 10px !important;
    }

    #appointment-booking {
        position: fixed;
        bottom: 50%;
        right: -500%;
        z-index: 9999;
        transform: translateY(50%) scale(0);
        transition: right .5s, transform 1s;
    }

    #appointment-booking.booking-open {
        right: 0 !important;
        transform: translateY(50%) scale(1) !important;
    }

    #appo-button-close {
        position: absolute;
        bottom: 15px;
        right: 10px;
    }
    .error-text-font{
        font-size: 11px !important;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section("contentTheme1");
$cls = "";
if ($user_details['appointment_booking'] == "Hide") {
    $cls = "d-none";
}
?>
<div class="home-page overflow-hidden">

    <div class="container-fluid booking-open <?= $cls; ?>" id="appointment-booking">
        <div class="row d-none">
            <div class="col-md-5 offset-md-7">
                <?php
                $validation = \Config\Services::validation();
                $session = \Config\Services::session();

                ?>


                <form class="contact-form m-3 p-3 card " method="post" action="<?= base_url(); ?>/submit-query">
                    <?php if ($session->getFlashdata('message') !== NULL) : ?>
                        <div class="alert alert-success alert-dismissible fade show error-text-font" role="alert">
                            <?php echo session()->getFlashdata('message'); ?>
                            <button type="button" class="close px-1 rounded" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"> &times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if ($session->getFlashdata('error') !== NULL) : ?>
                        <div class="alert alert-danger alert-dismissible fade show error-text-font" role="alert">
                            <?php echo session()->getFlashdata('error'); ?>
                            <button type="button" class="close px-1 rounded" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"> &times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="bookingName">Name</label>
                            <input value="<?= old('bookingName') ?>" type="text" id="bookingName" name="bookingName" class="form-control" placeholder="Your Name">
                            <span class="text-danger error-text-font"><?= $validation->getError('bookingName') ?></span>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="bookingEmail">Email</label>
                            <input value="<?= old('bookingEmail') ?>" type="text" class="form-control" id="bookingEmail" name="bookingEmail" placeholder="Your Email">
                            <span class="text-danger error-text-font"><?= $validation->getError('bookingEmail') ?></span>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="bookingPhone">Phone</label>
                            <input value="<?= old('bookingPhone') ?>" type="text" class="form-control" id="bookingPhone" name="bookingPhone" maxlength="10" placeholder="Mobile number">
                            <span class="text-danger error-text-font"><?= $validation->getError('bookingPhone') ?></span>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label for="bookingDate">Booking Date</label>
                            <input value="<?= old('bookingDate') ?>" type="date" class="form-control" id="bookingDate" name="bookingDate" placeholder="">
                            <span class="text-danger error-text-font"><?= $validation->getError('bookingDate') ?></span>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="bookingTime">Booking Time</label>
                            <select name="bookingTime" id="bookingTime" class="form-control" value="<?= old('bookingTime') ?>">
                                <option value="">Select Time</option>
                                <?php for ($i = 0; $i < 24; $i++) : ?>
                                    <?php if ($i % 12) : ?>
                                        <option value="<?= $i; ?>" <?= old('bookingTime') == $i? "selected":'' ?> ><?= $i % 12 ?>:00 <?= $i >= 12 ?    'pm' : 'am' ?></option>
                                        <option value="<?= $i; ?>:30" <?= old('bookingTime') == $i.":30"? "selected":'' ?>><?= $i % 12 ?>:30 <?= $i >= 12 ?    'pm' : 'am' ?></option>
                                    <?php else : ?>
                                        <option value="<?= $i;?>" <?= old('bookingTime') == $i? "selected":'' ?> ><?= 12 ?>:00 <?= $i >= 12 ?    'pm' : 'am' ?></option>
                                        <option value="<?= $i; ?>:30" <?= old('bookingTime') == $i.":30"? "selected":'' ?> ><?= 12 ?>:30 <?= $i >= 12 ?    'pm' : 'am' ?></option>
                                    <?php endif; ?>
                                <?php endfor ?>
                            </select>
                            <span class="text-danger error-text-font"><?= $validation->getError('bookingTime') ?></span>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="bookingQuery">Query</label>
                        <textarea class="form-control" name="bookingQuery" id="bookingQuery" rows="3"><?= old('bookingQuery') ?></textarea>
                        <span class="text-danger error-text-font"><?= $validation->getError('bookingQuery') ?></span>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" id="bookingQuerySmt" class="btn btn-color text-white rounded-pill ">
                            Submit Query
                        </button>
                    </div>
                    <button type="button" id="appo-button-close" class="btn btn-danger text-white rounded ">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="appo-button" class="btn search-btn rounded-pill">
        Book an Appointment
    </div>
    <?php
    foreach($sort_order as $myurl)
    {
        if($myurl['url_val'] != "contact")
        {
          include('layout/'.$myurl['url_val'].'.php');
        }
        else
        { ?>
            <!-- --------Contact Us---------- -->
            <section class="mb-4">
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
            </section>
        <?php }    
    }
    ?>

    


    
</div>

<?= $this->endSection() ?>
<?= $this->section("customScripts") ?>


<script>
    $(function() {
        AOS.init();

        //open close appointment form
        $('#appo-button-close').on('click', function() {
            $('#appointment-booking').removeClass('booking-open');
            $('#appo-button').addClass('button-open');
        })
        $('#appo-button').on('click', function() {
            $('#appointment-booking').addClass('booking-open');
            $('#appo-button').removeClass('button-open');
        })

    });
</script>
<?= $this->endSection() ?>