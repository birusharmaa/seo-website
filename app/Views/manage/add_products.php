<?= $this->extend('template/main'); ?>
<!-- <style>
    display: inline-block;
    position: absolute;
    top: 10px;
    right: 10px;
    background: white;
    padding: 0 8px;
    border-radius: 5px;
    color: black;
</style> -->
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5"><?= $title; ?></h2>
        <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('manage/products') ?>">Products</a></li>
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
                <form id="AddProducts" class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="product_name" id="product_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Inventry <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="total_inventry" id="total_inventry">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>MRP <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="mrp" id="mrp">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Discount(in %) <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="discount" id="discount">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Images <span class="text-danger"> *</span>( <b>Note: </b>You can select single or multiple images)</label>
                                <input type="file" class="form-control" name="product_main_image[]" id="imageProductImg" onchange="preview_image()" multiple required />
                            </div>
                        </div>
                    </div>
                    <div class="row product-gallery" id="image_preview">
                    </div>
                    <div class="form-group">
                        <label>Select Related Products</label>
                        <select class="form-control products" id="r_product" name="related_product[]" multiple>
                            <?php if ($products) : foreach ($products as $value) : ?>
                                    <option value="<?= $value->id; ?>"><?= $value->product_name; ?></option>
                            <?php endforeach;
                            endif; ?>
                        <select>
                    </div>
                    <div class="form-group">
                        <label>Short Description <span class="text-danger"> *</span></label>
                        <textarea class="form-control" name="short_description" id="short_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea class="form-control" name="long_description" id="long_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Specification</label>
                        <textarea class="form-control" name="specification" id="specification"></textarea>
                    </div>
                    <div class="mt-2 mb-3">
                        <button class="btn btn-primary btn-sm">Add Section</button>
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
        $('#services_section_table').DataTable({
            responsive: false,
        });
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        CKEDITOR.replace('specification');
        $('.products').select2();
    });


    function preview_image(){
        $('#image_preview').append('<p>Please wait...</p>');
        var total_file=document.getElementById("imageProductImg").files.length;
        var html = "";
        for(var i=0;i<total_file;i++){
            //html += "<div class='col-md-3' id='imgPreviewDiv"+i+"'><div class='m-2 p-2 card'><a class='text-right' href='javascript:void(0)' onclick=removeImg("+i+")><i class='fa fa-times' aria-hidden='true'></i></a><img src='"+URL.createObjectURL(event.target.files[i])+"'/></div></div>";
            html += "<div class='col-md-3 p-0'><div class='m-2 p-2 card'><img src='"+URL.createObjectURL(event.target.files[i])+"'/></div></div>";
        }
        $('#image_preview').empty();
        $('#image_preview').append(html);
    }

    function removeImg(id){
        var fullId = "#imgPreviewDiv"+id;
        $(fullId).remove();

        // Swal.fire({
        //     title: 'Do you want to save the changes?',
        //     showDenyButton: true,
        //     showCancelButton: true,
        //     confirmButtonText: 'Save',
        //     denyButtonText: `Don't save`,
        //     }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         Swal.fire('Saved!', '', 'success')
        //     } else if (result.isDenied) {
        //         Swal.fire('Changes are not saved', '', 'info')
        //     }
        // })
    }
</script>
<script src="<?php echo base_url('public/assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>

<?= $this->endSection(); ?>