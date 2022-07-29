<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php $session = \Config\Services::session();
?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5"><?= $title; ?></h2>
        <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
        <div class="row ">
            <div class="col-md-12 box-shadow border rounded mb-5">
                <div class="row mt-2">
                    <div class="col-6 offset-3 text-center mt-2">
                        <div class="shadow-lg p-3 bg-white rounded">
                            <?php
                                if($topbar==="Hide"){
                                    echo '<span class="badge badge-warning">Hide</span>'; 
                                    $check = '';
                                }else{
                                    echo '<span class="badge badge-success">Show</span>'; 
                                    $check = 'checked';
                                }
                            ?>
                            <label class="switch mb-0">
                                <input id="switchCheckBox" type="checkbox" <?= $check;?> />
                                <span class="slider round" onclick="tobbarActionFunction()"></span>
                            </label>
                            <span>Topbar hide and show button</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="header_id" id="header_id" value="<?= $info->id; ?>">
                <form class="py-12 px-2" id="headerFooterUpdate">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Header Background color *</label>
                                    <input type="color" class="form-control" name="header_background" id="header_background" value="<?php isset($info->header_background);
                                                                                                                                    echo $info->header_background;
                                                                                                                                    "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Header Text Color *</label>
                                    <input type="color" class="form-control" name="header_text" id="header_text" value="<?php isset($info->header_text);
                                                                                                                        echo $info->header_text;
                                                                                                                        "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Navbar Background Color *</label>
                                    <input type="color" class="form-control" name="navbar_background" id="navbar_background" value="<?php isset($info->navbar_background);
                                                                                                                                    echo $info->navbar_background;
                                                                                      "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Navbar Text Color *</label>
                                    <input type="color" class="form-control" name="navbar_text" id="navbar_text" value="<?php isset($info->navbar_text);
                                                                                                                        echo $info->navbar_text;
                                                                                                                        "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Searchbar Color *</label>
                                    <input type="color" class="form-control" name="searchbar_color" id="searchbar_color" value="<?php isset($info->searchbar_color);
                                                                                                                                echo $info->searchbar_color;
                                                                                                                                "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Footer Background Color *</label>
                                    <input type="color" class="form-control" name="footer_background" id="footer_background" value="<?php isset($info->footer_background);
                                                                                                                                    echo $info->footer_background;
                                                                                                                                    "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Footer Text Color *</label>
                                    <input type="color" class="form-control" name="footer_text_color" id="footer_text_color" value="<?php isset($info->footer_text_color);
                                                                                                                                    echo $info->footer_text_color;
                                                                                                                                    "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Footer Text *</label>
                                    <textarea class="form-control" name="footer_text"><?php isset($info->footer_text);
                                                                                        echo $info->footer_text;
                                                                                        ""; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Copyright Background Color *</label>
                                    <input type="color" class="form-control" name="copyright_background" value="<?php isset($info->copyright_background);
                                                                                                                echo $info->copyright_background;
                                                                                                                "#000000"; ?>" id="copyright_background">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Copyright Text Color *</label>
                                    <input type="color" class="form-control" name="copyright_text_color" value="<?php isset($info->copyright_text_color);
                                                                                                                echo $info->copyright_text_color;
                                                                                                                "#000000"; ?>" id="copyright_text_color">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Copyright Text *</label>
                                    <input type="text" class="form-control" name="copyright_text" value="<?php isset($info->copyright_text);
                                                                                                            echo $info->copyright_text;
                                                                                                            "#000000"; ?>" id="copyright_text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <div class="mb-3">
                                    <label class="form-label fs-15">Sitemap URL *</label>
                                    <input type="text" class="form-control" name="sitemap" value="<?php isset($info->sitemap);
                                                                                                    echo $info->sitemap;
                                                                                                    "#000000"; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<script>
    const tobbarActionFunction = () =>{
        if($("#switchCheckBox").is(':checked')){
            var val = 'Hide';
        }else{
            var val = 'Show';
        }
        let URL = $('#url').val() + '/manage/topbar-status';
        $.ajax({
            url: URL,
            type: "POST",
            data: {"status":val},
            success: function (response) {
                response = JSON.parse(response);
                if (response.status) {
                    Swal.fire({ icon: 'success', text: response.message, timer:1500}).then( (result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', text: response.message })
                }
            }
        });
    }
</script>
    
<?= $this->endSection(); ?>