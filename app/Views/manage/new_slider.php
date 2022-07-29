<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
	<div>
		<h2 class="main-content-title tx-24 mg-b-5"><?= $title; ?></h2>
		<ol class="breadcrumb mt-4">
			<li class="breadcrumb-item"><a href="#">Content Management</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('/manage/all-slider') ?>">All Slider</a></li>
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
				<form class="py-4 px-2" id="AddNewSliders">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Slider Image <span class="text-danger">*</span></label>
								<input type="file" class="form-control" accept="image/png, image/jpeg" name="slider_image" id="slider_image">
								<input type="hidden" name="slider_image_temp" id="slider_image_temp">
							</div>
							<img src="" class="img-preview-img w-50" />
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Heading Color<span class="text-danger">*</span></label>
								<input type="color" class="form-control" name="heading_color" id="heading_color">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Text Color <span class="text-danger">*</span></label>
								<input type="color" class="form-control" name="text_color" id="text_color">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="name" id="name" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control" name="title" id="title">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Description</label>
								<input type="text" class="form-control" name="description" id="description">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Title Font Style</label>
								<select class="form-control" name="fontStyle" id="fontStyle">
									<option value="inherit">Default</option>
									<option value="cursive">Cursive</option>
									<option value="monospace">Monospace</option>
									<option value="sans-serif">Sans-Serif</option>
									<option value="serif">Serif</option>
									<option value="work_sans">Work Sans</option>
									<option value="tai_heritage">Tai Heritage</option>
									<option value="roboto_slab">Roboto Slab</option>
									<option value="raleway">Raleway</option>
									<option value="oswald">Oswald</option>
									<option value="lora">Lora</option>
									<option value="joan">Joan</option>
									<option value="fascinate">Fascinate</option>
									<option value="rototo-bold">Rototo Bold</option>
									<option value="rototo-italic">Rototo Italic</option>
									<option value="rototo-bold-italic">Rototo Bold Italic</option>
									<option value="rototo-regular">Roboto Regular</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Description Font Style</label>
								<select class="form-control" name="descFontStyle" id="descFontStyle">
									<option value="cursive">Default</option>
									<option value="inherit">inherit</option>
									<option value="monospace">Monospace</option>
									<option value="sans-serif">Sans-Serif</option>
									<option value="serif">Serif</option>
									<option value="work_sans">Work Sans</option>
									<option value="tai_heritage">Tai Heritage</option>
									<option value="roboto_slab">Roboto Slab</option>
									<option value="raleway">Raleway</option>
									<option value="oswald">Oswald</option>
									<option value="lora">Lora</option>
									<option value="joan">Joan</option>
									<option value="fascinate">Fascinate</option>
									<option value="rototo-bold">Rototo Bold</option>
									<option value="rototo-italic">Rototo Italic</option>
									<option value="rototo-bold-italic">Rototo Bold Italic</option>
									<option value="rototo-regular">Roboto Regular</option>
								</select>
							</div>
						</div>
					</div>
					<div>
						<button class="btn btn-primary btn-sm">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Row end -->
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
	$(document).ready(function() {
		$('.pages').select2();
		$('.slider_name').select2();
	});
</script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>

<?= $this->endSection(); ?>