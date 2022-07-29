<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5"><?= $title; ?></h2>
        <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('manage/testimonials') ?>">All Testimonials</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $title; ?>
            </li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!--Row-->
<div class="row row-sm mx-auto">
    <div class="col-md-12 ">
        <div class="row">
            <div class="col-md-12 box-shadow border">
                <div class="mt-2 mb-2">
                    <input type="hidden" name="testimonials_id" id="testimonials_id" value="<?= $data->id; ?>" class="form-control">
                    <form id="UpdateTestimonials">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="<?= $data->name; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="testimonials_image" id="testimonials_image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control" required><?= $data->description; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php $img = !empty($data->image)?base_url().'/public/uploads/testimonial_images/'.$data->image:base_url().'/public/assets/img/empty.png'; ?>
                                <img src="<?= $img;?>" class="img-fluid testimonials-img w-50" />
                            </div>
                        </div>
                        
                        <button class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<?= $this->endSection(); ?>