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
                            if ($topbar === "Hide") {
                                echo '<span class="badge badge-warning">Hide</span>';
                                $check = '';
                            } else {
                                echo '<span class="badge badge-success">Show</span>';
                                $check = 'checked';
                            }
                            ?>
                            <label class="switch mb-0">
                                <input id="switchCheckBox" type="checkbox" <?= $check; ?> />
                                <span class="slider round" onclick="tobbarActionFunction()"></span>
                            </label>
                            <span>Appointment form hide and show button</span>
                            <p class="fw-bold">Note: Appointment form show only on Healthcare theme.</p>


                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="mt-1">
                                    <table class="table table-hover nowrap" style="width:100%" id="appoinmentHistory">
                                        <thead style="border-top:1px solid #dee2e6">
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Date Time</th>
                                                <th>Query</th>
                                                <th class='none'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<script>
    const tobbarActionFunction = () => {
        if ($("#switchCheckBox").is(':checked')) {
            var val = 'Hide';
        } else {
            var val = 'Show';
        }
        let URL = $('#url').val() + '/manage/topbar-status';
        $.ajax({
            url: URL,
            type: "POST",
            data: {
                "status": val
            },
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
                    Swal.fire({
                        icon: 'error',
                        text: response.message
                    })
                }
            }
        });
    }


    $(document).ready(function() {
        // getAllAppoinments();
        $('#appoinmentHistory').DataTable({
            "ajax": {
                "url": $('#url').val() + '/manage/get-appoinments',
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "date_time"
                },
                {
                    "data": "query"
                },
                {
                    "data": function(data) {
                        return `<button type="button" onclick="deleteAppointment(${data.id})" class="btn btn-danger"><i class="fa fa-trash"></i></button>`
                    }
                }
            ]
        })
    });

    // function getAllAppoinments() {
    //     $(".loader-wrapper").show();
    //     let URL = $('#url').val() + '/manage/get-appoinments';

    //     $.ajax({
    //         url: URL,
    //         type: 'get',
    //         dataType: 'json',
    //         success: function(result) {
    //             // loadClientsData(result);
    //             $('#appoinmentHistory').DataTable({
    //                 "dataSrc": result.data,
    //                 "columns": [{
    //                         "data": "id"
    //                     },
    //                     {
    //                         "data": "name"
    //                     },
    //                     {
    //                         "data": "email"
    //                     },
    //                     {
    //                         "data": "phone"
    //                     },
    //                     {
    //                         "data": "date_time"
    //                     },
    //                     {
    //                         "data": "query"
    //                     },
    //                     {
    //                         "data": function(){
    //                             return 'asdfasdf'
    //                         }
    //                     }
    //                 ]
    //             })
    //         },
    //         error: function(error, data) {
    //             $(".loader-wrapper").hide();
    //         }
    //     })
    // }


    // function loadClientsData(result) {

    //     let table = $("#appoinmentHistory").DataTable();
    //     let dataSet = [];
    //     let num = 1;
    //     if (result.status) {
    //         result = result.data;
    //         if (result.length > 0) {
    //             result.forEach((e) => {
    //                 let action = `<a href="javascript:void(0)" class="text-danger" onclick="deleteHistory(${e.id}, '${e.user_email}')"><i class="fa fa-trash"></i> Delete</a>`;
    //                 let row = [
    //                     num++,
    //                     e.name,
    //                     e.email,
    //                     e.phone,
    //                     e.date_time,
    //                     e.query,
    //                     action
    //                 ];
    //                 dataSet.push(row);
    //             })
    //         }
    //     }
    //     table.destroy();
    //     $("#appoinmentHistory").DataTable({
    //         data: dataSet,
    //         pageLength: 10,
    //         dom: 'lBfrtip',
    //         responsive:false
    //     });
    //     $(".loader-wrapper").hide();
    // }

    // function deleteHistory(id = null, user_email = null) {
    //     if (id && user_email) {
    //         Swal.fire({
    //             title: 'Are you sure?',
    //             text: "Do you really want to delete " + user_email + " clients.",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'Yes, delete it!'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 $(".loader-wrapper").hide();
    //                 let url = BaseUrl + "/curl/delete-client/" + id;
    //                 $.ajax({
    //                     url: url,
    //                     type: "delete",
    //                     dataType: 'json',
    //                     success: function(data) {
    //                         if (data.status) {
    //                             $(".loader-wrapper").hide();
    //                             Swal.fire("Success!", data.message, "success");
    //                             getClientLists();
    //                         } else {
    //                             Swal.fire("Error!", data.message, "error");
    //                             $(".loader-wrapper").hide();
    //                         }
    //                     },
    //                     error: function() {
    //                         $(".loader-wrapper").hide();
    //                     }
    //                 });
    //             }
    //         })
    //     }
    // }
</script>

<?= $this->endSection(); ?>