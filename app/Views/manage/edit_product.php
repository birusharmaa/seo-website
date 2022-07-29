<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>
<style>
    .cancel-icon{
        position: absolute;
        margin-left: 4px;
        display: inline-block;
        background: white;
        padding: 0 5px;
        margin-top: 3px;
        border-radius: 7px;
        color: black;
    }
    .preview-images img{
        width: 100%;
        height: 250px;
    }
</style>
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
                <form id="EditProducts" class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger"> *</span></label>
                                <input type="hidden" name="product_id" id="product_id" value="<?= $data->id; ?>">
                                <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $data->product_name; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>MRP <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="mrp" id="mrp" value="<?= $data->mrp; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Discount(in %) <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="discount" id="discount" value="<?= $data->discount; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Inventry <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="total_inventry" id="total_inventry" value="<?= $data->total_inventry; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Images <span class="text-danger"> *</span>( <b>Note: </b>You can select single or multiple images)</label>
                                <input type="file" class="form-control" accept="image/png, image/jpg, image/jpeg" name="product_main_image[]" id="product_main_image" onchange="preview_image()" multiple />
                            </div>                            
                        </div>
                        <div class="col-12 preview-images" id="previewImages">
                        </div>
                        <div class="col-12 preview-images">
                            <div class="row">
                                <?php
                                    foreach($product_images as $image){
                                        $cls = "";
                                        if($image['product_image']==$data->main_image){
                                            $cls = "d-none";
                                        }
                                        echo '<div class="col-md-3 col-6" id="removeDiv'.$image['id'].'">
                                                <div class="card m-2 p-2">
                                                    <a class="text-right cancel-icon '.$cls.'" 
                                                        href="javascript:void(0)" 
                                                        onclick=removeImg('.$image['id'].')>
                                                        <i class="fa fa-times " 
                                                        aria-hidden="true"></i>
                                                    </a>
                                                    <img src="'.base_url()."/public/uploads/product_images/".$image['product_image'].'" class="" />
                                                </div>
                                            </div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Related Products</label>
                        <?php $selected = '';
                        $rsData = !empty(json_decode($data->related_product)) ? json_decode($data->related_product) : []; ?>

                        <select class="form-control products" id="r_product" name="related_product[]" multiple>
                            <?php if ($products) : foreach ($products as $value) : if (!empty($rsData)) :
                                        $selected =  in_array($value->id, $rsData) ? 'selected' : "";
                                    endif ?>
                                    <option value="<?= $value->id; ?>" <?= $selected  ?>><?= $value->product_name; ?></option>
                            <?php endforeach;
                            endif; ?>
                            <select>
                    </div>
                    <div class="form-group">
                        <label>Short Description <span class="text-danger"> *</span></label>
                        <textarea class="form-control" name="short_description" id="short_description"><?= $data->short_description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea class="form-control" name="long_description" id="long_description"><?= $data->long_description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Specification</label>
                        <textarea class="form-control" name="specification" id="specification"><?= $data->specification; ?></textarea>
                    </div>
                    <div class="mt-2 mb-3">
                        <button class="btn btn-primary btn-sm">Update</button>
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
            responsive: true,
        });
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        CKEDITOR.replace('specification');
        $('.products').select2();
    })
</script>
<script src="<?php echo base_url('public/assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<script>
const removeImg = (id)  => {
    if(id){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(data) {
            console.log();
            if (this.readyState == 4 && this.status == 200) {
                const element = document.getElementById("removeDiv"+id);
                console.log(this.responseText);
                if(this.responseText=="Yes"){
                    element.remove();
                }
            }
        };
        xhttp.open("POST", "remove-img/"+id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
}

function preview_image(){
    var total_file=document.getElementById("product_main_image").files.length;
    var html = "<div class='row'>";
    for(var i=0;i<total_file;i++){
        //html += "<div class='col-md-3' id='imgPreviewDiv"+i+"'><div class='m-2 p-2 card'><a class='text-right' href='javascript:void(0)' onclick=removeImg("+i+")><i class='fa fa-times' aria-hidden='true'></i></a><img src='"+URL.createObjectURL(event.target.files[i])+"'/></div></div>";
        html += "<div class='col-md-3 p-0'><div class='m-2 p-2 card'><img src='"+URL.createObjectURL(event.target.files[i])+"'/></div></div>";
    }
    html += '</div>';
    $('#previewImages').empty();
    $('#previewImages').append(html);
}
</script>
<?= $this->endSection(); ?>