<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>
<style>
	ul {
		list-style-type: none;
	}

	.box_custom {
		padding-top: 3px;
		padding-bottom: 6px;
		border: 1px solid #a8afc7;
		border-top: 0px;
		border-left: 0px;
		border-right: 0px;
		margin: 9px;
	}

	/* .row.abc {
				box-shadow: 1px 1px 1px 2px;
			} */
</style>

<!-- Page Header -->
<div class="page-header">
	<div>
		<h2 class="main-content-title tx-24 mg-b-5">Update <?= $title; ?></h2>
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

				<?php if ($menus) : foreach ($menus as $value) : ?>
						<div class="box_custom">
							<div class="row">
								<div class="col-md-4">
									<?= $value->menu_name; ?>
								</div>
								<div class="col-md-6" id="<?= $value->id; ?>" data-isEmpty="true">
									<a href="javascript:void(0)" onclick="showSubMenu(<?= $value->id; ?>, '<?= $value->menu_name; ?>')">
										<i class="fa fa-plus-circle"></i>
									</a>
								</div>
							</div>
						</div>
				<?php endforeach;
				endif; ?>


				<form class="py-4 px-2 border shadow-lg p-3 mb-5 mt-5s bg-white rounded" id="SetSubMenu">
					<div class="form-group row">
						<div class="mb-3 col-4">
							<select class="form-control" name="parent_menu_name" id="parent_menu_name">
								<option value=""> Select Menu</option>
								<?php if ($menus) : foreach ($menus as $value) : ?>
										<option value="<?= $value->id ?>"><?= $value->menu_name ?></option>
								<?php endforeach;
								endif; ?>
							</select>
						</div>

					</div>

					<div class="form-group row">
						<div class="mb-3 col-4">
							<input type="text" class="form-control" name="sub_menu" id="sub_menu" placeholder="Enter Sub Menu Name">
						</div>
					</div>
					<div>
						<button class="btn btn-primary">Create</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- Row end -->
</div>

<div class="modal fade" id="subMenuContentModal" tabindex="-1" role="dialog" aria-labelledby="subMenuContentModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Page Content</h5>
				<button type="button" class="close cancel" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="customPageData">
							<input type="hidden" id="subId" value="" />
							<input type="hidden" id="pageId" value="" />
							<div class="form-group">
								<label for="heading">Heading</label>
								<input type="text" id="heading" name="heading" class="form-control" placeholder="Heading name" />
							</div>
							<div class="form-group">
								<label for="heading">Image</label>
								<input type="file" id="file" name="file" class="form-control" placeholder="" />
								<img src="" class="img-fluid w-50 content-img" />
							</div>
							<div class="form-group">
								<label for="content">Content</label>
								<input type="text" id="content" name="heading" class="form-control" placeholder="Heading name" />
								<span class="text-danger d-none" id="contentErr">Please enter content</span>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="contentBtn">Save Content</button>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?php echo base_url('public/assets/ckeditor/ckeditor.js') ?>"></script>

<script>
	$(document).ready(function() {
		$('#inventory-table').DataTable();
		CKEDITOR.replace('content');
	});
</script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js') ?>"></script>
<script>
	function showSubMenu(id, name = null) {
		var BASEURL = $("#url").val();
		if (id) {
			let url = BASEURL + "/manage/getSubMenu/" + id + '/' + name;
			$.ajax({
				url: url,
				type: "POST",
				data: '',
				success: function(response) {
					response = JSON.parse(response);
					if (response.length > 0) {
						var appendData = $("#" + id).attr('data-isEmpty');
						let html = "<div class='row'> ";
						response.forEach(function(value, index) {
							var action = '';
							if (value.id) {
								action = "<span class='float-right'><button type='button' class='btn btn-info addContent' onclick='addContent(" + value.id + ")'><i class='fa fa-plus'></i> Content</button> <button type='button' onclick='trashSubmenu(" + value.id + ")' class='btn btn-danger trashSubmenu'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button></span>";
							}
							html += '<div class="col-12 border-bottom"><span class="float-left">' + value.menu_name + "</span>" + action + "</div>";
						});
						html += '</div>';
						if (appendData === "true") {
							$("#" + id).find('.row').remove();
							$("#" + id).append(html);
							$("#" + id).find("i").toggleClass('fa-plus-circle fa-minus-circle');
							$("#" + id).attr('data-isEmpty', 'false');
							$("#" + id).parent().find('.row').addClass("card");
						}
						if (appendData === "false") {
							$("#" + id).find("i").toggleClass('fa-plus-circle fa-minus-circle');
							$("#" + id).find('.row').remove();
							$("#" + id).attr('data-isEmpty', 'true')
							$("#" + id).parent().find('.row').removeClass("card");
						}
						$(".addContent").find("i").removeClass('fa-plus-circle fa-minus-circle');
						$(".editContent").find("i").removeClass('fa-plus-circle fa-minus-circle');
						$(".trashSubmenu").find("i").removeClass('fa-plus-circle fa-minus-circle');
					} else {
						Swal.fire({
							icon: 'warning',
							text: 'No submenu found.'
						});
					}
				},
				error: function() {}
			});
		}
	}
</script>
<script>
	function addContent(id) {
		let url = $("#url").val();
		if (id) {
			$.ajax({
				url: url + "/get-custom-page-data/" + id,
				type: "get",
				data: {},
				caches: false,
				processData: false,
				contentType: false,
				success: function(response) {
					response = JSON.parse(response);
					if (response.status) {
						CKEDITOR.instances['content'].setData(response.data.content);
						$("#heading").val(response.data.heading);
						if (response.data.image) {
							$(".content-img").attr('src', url + '/public/uploads/custom_pages_image/' + response.data.image);
						}
						$("#subId").val('');
						$("#pageId").val(response.data.id);
						$("#contentBtn").text('Update Content');
						$("#subMenuContentModal").modal("show");

					} else {
						CKEDITOR.instances['content'].setData("");
						$("#heading").val("");
						$(".content-img").attr('src', "");
						$("#subId").val(id);
						$("#pageId").val("");
						$("#contentBtn").text('Save Content');
						$("#subMenuContentModal").modal("show");
					}
				}
			});
		}
	}

	$('#file').on('change', function() {
		displayImage(this, 'content-img');
	});

	$("#contentBtn").click(function() {
		$('.validation').remove();
		$("#contentErr").addClass("d-none");
		let flag = true;

		let subId = $("#subId").val();
		let pageId = $("#pageId").val();

		let heading = $.trim($("#heading").val());
		let content = CKEDITOR.instances['content'].getData();
		let image = document.getElementById("file").files[0];
		if (heading == "") {
			$("#heading").parent().append("<span class='text-danger'>Please enter heading name.</span>");
			flag = false;
		}
		// if(image){
		// 	$("#file").append("<span class='text-danger'>Please select image heading name.</span>");
		// 	flag = false;
		// }
		if (content == "") {
			$("#contentErr").removeClass("d-none");
			flag = false;
		}

		let formData = new FormData();
		formData.append('sub_id', subId);
		formData.append('page_id', pageId);
		formData.append('heading', heading);
		formData.append('image', image);
		formData.append('content', content);

		let url = $("#url").val();

		// let data = document.getElementById('customPageData');
		// let formData = new FormData(data);
		if (flag) {
			$.ajax({
				url: url + "/custom-page-data",
				type: "POST",
				data: formData,
				caches: false,
				processData: false,
				contentType: false,
				success: function(response) {
					response = JSON.parse(response);
					if (response.status) {
						$("#heading").val("");
						$("#file").val("");
						CKEDITOR.instances['content'].setData('');
						$(".content-img").attr('src', "");
						$("#subMenuContentModal").modal("hide");
						Swal.fire({
							icon: 'success',
							text: response.message
						});
					} else {
						Swal.fire({
							icon: 'warning',
							text: response.message
						});
					}
				},
			});
		}
	});

	function trashSubmenu(value) {
		Swal.fire({
			title: 'Are you sure you want to delete this sub menu?',
			icon: 'info',
			showDenyButton: true,
			confirmButtonText: 'Yes',
		}).then((result) => {
			if (result.isConfirmed) {
				var BASEURL = $("#url").val();
				$.ajax({
					url: BASEURL + "/delete-submenu/"+value,
					type: "POST",
					success: function(data) {
						response = JSON.parse(data);
						if (response.status) {
							Swal.fire({
								icon: 'success',
								timer: 1000,
								text: response.message
							}).then((result) => {
								location.reload();
							});
						} else {
							Swal.fire({
								icon: 'error',
								text: response.message
							});
						}
					},
				});
			}
		})
	}

	$(".cancel").click(function() {
		$("#subMenuContentModal").modal("hide");
	})
</script>
<?= $this->endSection(); ?>