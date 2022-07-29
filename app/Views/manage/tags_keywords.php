<?= $this->extend('template/main'); ?>
<?= $this->section('content');?>
<style>
    .tag {
        color: #ffffff;
        background-color: #7965c9;
        border-radius: 3px;
    }
    .bootstrap-tagsinput, .bootstrap-tagsinput input{
        width: 100%!important;
        margin-top: 10px;
    }
    .bootstrap-tagsinput .tag{
        margin-bottom: 5px;
    }
    .bootstrap-tagsinput {
        min-height: 55px;
    }
</style>

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
        <div class="row">
            <div class="col-md-12 box-shadow border">
                <div class="mt-2 mb-4">
                    <input type="hidden" name="keyword_id" id="keyword_id">
                    <form id="TagsKeywords">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-2">
                                    <label>Keywords(Meta) <span class="text-danger"> *</span></label>
                                    <input type="text" name="keyword" id="keyword" class="form-control w-100" placeholder="Type Keyword And Hit Enter" />
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-2">
                                    <label>Pages <span class="text-danger"> *</span></label>
                                    <select class="form-control pages_ids" id="pagesIds" name="pages[]" multiple required>
                                        <?php if ($pages) : ksort($pages);
                                            foreach ($pages as $value) :
                                        ?>
                                        <option value="<?= $value['menu_link']; ?>"><?= $value['menu_name']; ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary my-2">Add Keyword</button>
                    </form>
                </div>
                <div class="table-responsive mb-4">
                    <table class="table" id="tagKeyword_table">
                        <thead>
                            <th><input type="checkbox" id="check" name="check" value="1" onclick="dataRowSelect()"> S.NO</th>
                            <th>Keyword</th>
                            <th class="custom_wdth">Page</th>
                            <th class="custom_wdth">Page Url</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $num = 1;
                            if ($data) :
                                foreach ($data as $value) :
                            ?>
                                    <tr>
                                        <td><input onclick="rowSelect()" value="<?= $value['id'] ?>" type="checkbox" class="check" name="check" value="" /> <?= $num; ?></td>
                                        <td><?= $value['keyword']; ?></td>
                                        <td class="custom_wdth">
                                            <?= !empty($value['pages']) ? ucwords($value['pages']) : 'Home'; ?>
                                        </td>
                                        <td class="custom_wdth">
                                            <?= $value['page_url']; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="delete_keyword(<?= $value['id'] ?>)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                            <?php $num++;
                                endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                    <button class="btn btn-primary d-none" id="deleteRow" type="button"> Delete Select Row</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    function updateTheme(value) {
        const BASEURL = $('#url').val();
        $.ajax({
            url: BASEURL + '/update-theme/' + value,
            type: 'POST',
            success: function(data) {}
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#tagKeyword_table').DataTable({
            "responsive": false,
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }],
        });
        $('.pages_ids').select2();
    });

    /**
     * Select all row show on datatable 
     */
    const dataRowSelect = () => {
        
        let i = 0;
        //Checked all row 
        if ($('#check').is(":checked")) {
            $('table tr .check').each(function(index, tr) {
                $(this).prop('checked', true);
            });
        } else {//Checked all row 
            $('table tr .check').each(function(index, tr) {
                $(this).prop('checked', false);
            });
        }

        //Check all multiple delete button is show or not
        $('table tr .check').each(function(index, tr) {
            if ($(this).is(":checked")) {
                i++;
            }
        });

        /**
         * If selected row is greater than 2 or equal 2 than show multple delete botton
         */
        if (i >= 2) {
            $("#deleteRow").removeClass("d-none");
        } else {
            $("#deleteRow").addClass("d-none");
        }
    }

    /**
     * Select single checkbox and 
     */
    const rowSelect = () => {
        let i = 0;
        $('table tr .check').each(function(index, tr) {
            if ($(this).is(":checked")) {
                i++;
            }
        });

        if (i >= 2) {
            $("#deleteRow").removeClass("d-none");
        } else {
            $("#deleteRow").addClass("d-none");
        }
    }

    /**
     * Delete multiple selected row
     */
    $("#deleteRow").click(function() {
        var id = [];
        $('table tr .check').each(function(index, tr) {
            if ($(this).is(":checked")) {
                id.push($(this).val());
            }
        });
        if (id.length > 0) {
            $.ajax({
                url: $("#url").val()+"/manage/delete-keywords",
                type: "POST",
                data: {"id":id},
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            timer: 1500
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        if (response.validation) {
                            Swal.fire({
                                icon: 'warning',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.message
                            });
                        }
                    }
                },
            });
        }
    });
</script>
<script src="<?php echo base_url('public/assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<script src="<?= base_url('public/assets/js/bootstrap-tagsinput.min.js');?>"></script>
<script>
$(document).ready(function() {
    $("#keyword").tagsinput();
});
</script>
<?= $this->endSection(); ?>