<?php
	/* set external css */
	$external_css = array(
		'<link rel="stylesheet" href="'.base_url('assets/plugins/datatables/jquery.dataTables.min.css').'">'
	);	
	$this->session->set_tempdata('external_css', $external_css);
	
	/* set external js */
	$external_js = array(
		'<script src="'.base_url('assets/plugins/datatables/jquery.dataTables.min.js').'"></script>',
		'<script>
			function getCookie(cname) {
				var name = cname + "=";
				var ca = document.cookie.split(";");
				for(var i=0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0)==" ") c = c.substring(1);
					if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
				}
				return "";
			}
		
			var csrf = getCookie("csrf_cookie_name");
		
			$(document).ready(function() {
				
				table = $("#example").DataTable({
					"processing": true,
					"serverSide": true,
					"destroy": true,
					"ajax": {
						"url": ""+ base_url +"users/getDataUser",
						"dataType": "json",
						"type": "POST",
						"data": function ( data ) {
							data.username = $("#username").val();
							data.email = $("#email").val();
							data.'.$this->security->get_csrf_token_name().' = csrf;
						}
					},
					"columns": [
						{ "data": "id", orderable: false },
						{ "data": "username" },
						{ "data": "email" },
						{ "data": "dibuat_tgl" },
						{ "data": "terakhir_login" },
						{ "data": "aktif", orderable: false },
						{ "data": "username", orderable: false }
					],
					"createdRow": function ( row, data, index ) {						
						if(data.aktif == 1){ var btnName = "Deactivate" } else { var btnName = "Activate" };
						if(data.aktif == 1){ var urlAction = "\'deactivateUser\'" } else { var urlAction = "\'activateUser\'" };
						if(data.aktif == 1){ var iClass = "eye-slash" } else { var iClass = "eye" };
						if(data.aktif == 1){ var iColour = "success" } else { var iColour = "danger" };
						
						var dibuat_tgl = moment.unix(data.dibuat_tgl).utc().format("YYYYMMDD");
						var terakhir_login = moment.unix(data.terakhir_login).utc().format("YYYYMMDD");
						
						var info = $("#example").DataTable().page.info();
						var info_page = info.page+1;
						
						if(info_page > 1) {
							var index_inc = index+1;
							var pages = ""+info_page+""+index_inc+"";
						} else {
							var pages = index+1;
						}
						
						$("td", row).eq(0).html(pages);
						$("td", row).eq(1).html(titleCase(data.username));
						$("td", row).eq(3).html(moment(dibuat_tgl, "YYYYMMDD").fromNow());
						$("td", row).eq(4).html(moment(terakhir_login, "YYYYMMDD").fromNow());						
						$("td", row).eq(5).html(
							\'<button class="btn btn-\'+ iColour +\' btn-sm" onclick="btn_active(\'+ data.id + \', \'+ urlAction + \')"><i class="fa fa-\'+ iClass +\'"></i> \'+ btnName +\'</button>\'
						);						
						$("td", row).eq(6).html(
							\'<a class="btn btn-primary btn-sm" onclick="btn_update(\'+ data.id + \')"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger btn-sm" onclick="btn_active(\'+ data.id + \')"><i class="fa fa-remove"></i> Delete</button>\'
						);
					}
				});
				
				$("#btn-filter").click(function(event){
					event.preventDefault();
					table.columns.adjust().draw();
				});
				
				$("#btn-reset").click(function(){
					$("#form-filter")[0].reset();
					table.columns.adjust().draw();
					/* else table.ajax.reload(null, false) / table.fnDraw() */
				});
				
			});
				
			function btn_active(id, action="") {
				
				if(action == "")
					action="deactivateUser";
			
				$.ajax({
					"url": base_url + action + "/" + id,
					"type": "POST",
					"contentType": false,
					"processData": false,
					"success": function(data) {
						location.reload();
					}
				});
			}

			function add_data() {
				
				save_method = "add";
				$("#formUpdate")[0].reset();
				$("#preview").attr("src", "'.base_url('assets/img/no-image.png').'");				
				$("#modal-default").modal("show");				
				$(".modal-title").text("Add User");
			}
				
			function btn_update(id) {
				
				save_method = "update";
				$("#formUpdate")[0].reset();
				$("#modal-default").modal("show");
				$(".modal-title").text("Edit User");
				
				$.ajax({
					"url": base_url + "userAjaxUpdate/" + id,
					"type": "POST",
					"dataType": "json",
					"contentType": false,
					"processData": false,
					"success": function(data) {
						$("#userid").val(data.id);
						$("#nama_pertama").val(data.nama_pertama);
						$("#nama_terakhir").val(data.nama_terakhir);
						$("#email_user").val(data.email);
						$("#alamat").val(data.alamat);
						$("#telpon").val(data.telpon);
						$("#grup_id").val(data.grup_id);
						$("#preview").attr("src", data.images);
					}
				});
			}

			// Variable to store your files
			var files;
			// Add events
			$("input[type=file]").on("change", prepareUpload);
			// Grab the files and set them to our variable
			function prepareUpload(event) {
				files = event.target.files;
			}
			
			function save_data(event) {

				$("#btnSave").text("saving...");
				$("#btnSave").attr("disabled", true);
				
				var url = "'.site_url("addUser").'";

				if(save_method == "update") {
					url = "'.site_url("editUser").'";
				}
				
				/* var formData = new FormData($("#formUpdate").serialize()); */
				var formData = new FormData($("#formUpdate")[0]);

				$.each(files, function(key, value) {
					formData.append(key, value);
				});
				
				$.ajax({
					"url": url,
					"type": "POST",
					"data": formData,
					"cache": false,
					"contentType": false,
					"processData": false,
					"dataType": "json",
					"success": function(data) {
						$("#modal-default").modal("hide");
						$("#btnSave").text("save");
						$("#btnSave").attr("disabled", false);
						location.reload();
					}
				});
			}
		</script>'
	);	
	$this->session->set_tempdata('external_js', $external_js);
?>

<div class="col-md-12 col-xs-12">
	
	<!-- box -->
	<div class="box box-primary collapsed-box">
		<div class="box-header with-border">
			<h3 class="box-title">Custom Filter</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'form-filter');
				echo form_open('#', $attributes);
				
					/*-- Username --*/
					echo '<div class="form-group">';
					$attributes = array('class' => 'col-sm-2 control-label');
					echo form_label('Username', 'username', $attributes);
					
					$data = array(
					  'name'        => 'username',
					  'id'          => 'username',
					  'class'       => 'form-control'
					);
					echo '<div class="col-sm-9">'.form_input($data).'</div>';
					echo '</div>';
					
					/*-- Email --*/
					echo '<div class="form-group">';
					$attributes = array('class' => 'col-sm-2 control-label');
					echo form_label('E-mail', 'username', $attributes);
					
					$data = array(
					  'name'        => 'email',
					  'id'          => 'email',
					  'class'       => 'form-control'
					);
					echo '<div class="col-sm-9">'.form_input($data).'</div>';
					echo '</div>';
				
				echo form_close();
			?>
		</div>
		<div class="box-footer text-center">
			<button type="submit" id="btn-filter" class="btn btn-primary">Search</button>
			<button type="button" id="btn-reset" class="btn btn-warning">Reset</button>
		</div>
	</div>
	<!-- /.box -->
	
</div>

<div class="col-md-12 col-xs-12">
	
	<!-- box -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('index_subheading');?></h3>

			<div class="box-tools pull-right">
				<button class="btn btn-primary" onclick="add_data()">Add User</button>
			</div>
		</div>
		<div class="box-body">
		
			<table id="example" class="table table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Username</th>
						<th>Email</th>
						<th>Created On</th>
						<th>Last Login</th>
						<th>Active</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
			
		</div>
	</div>
	<!-- /.box -->
	
</div>

<div class="modal fade" id="modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
			
				<div class="container-fluid">			
					<?php
						$attributes = array('class' => 'form-horizontal', 'id' => 'formUpdate');
						
						echo form_open_multipart('#', $attributes);
					?>
					
					<div class="row">
						<div class="col-md-8">
							<?php
								echo form_hidden('id', '', '', 'userid');
							
								/*-- nama_pertama --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Nama Depan', 'nama_pertama', $attributes);
								
								$data = array(
									'name' => 'nama_pertama',
									'id' => 'nama_pertama',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- nama_terakhir --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Nama Belakang', 'nama_terakhir', $attributes);
								
								$data = array(
									'name' => 'nama_terakhir',
									'id' => 'nama_terakhir',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- email --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Email', 'email', $attributes);
								
								$data = array(
									'type' => 'email',
									'name' => 'email',
									'id' => 'email_user',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- alamat --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Alamat', 'alamat', $attributes);
								
								$data = array(
									'name' => 'alamat',
									'id' => 'alamat',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- telpon --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Telpon', 'telpon', $attributes);
								
								$data = array(
									'name' => 'telpon',
									'id' => 'telpon',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- password --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Password', 'password', $attributes);
								
								$data = array(
									'type' => 'password',
									'name' => 'password',
									'id' => 'password',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- password_confirm --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Password Confirm', 'password_confirm', $attributes);
								
								$data = array(
									'type' => 'password',
									'name' => 'password_confirm',
									'id' => 'password_confirm',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_input($data).'</div>';
								echo '</div>';
			
								/*-- User Level --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Level User', 'grup_id', $attributes);
								
								$data = array(
									'name' => 'grup_id',
									'id' => 'grup_id',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-6 col-md-6 col-xs-6">'.form_dropdown('grup_id', $dataGrup, '', $data).'</div>';
								echo '</div>';
								
								/*-- img_user --*/
								/* echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 col-md-3 col-xs-3 col-md-offset-3 control-label');
								echo form_label('Upload Photo', 'img_user', $attributes);
								
								$data = array(
									'name' => 'images',
									'id' => 'img_user'
								);
								echo '<div class="col-sm-9">'.form_upload($data).'</div>';
								echo '</div>'; */
							?>
						</div>
						<!--<div class="col-md-4 col-md-4 col-xs-4 text-center">
							<?php //echo form_label('Preview Photo', 'preview'); ?>
							<img src="" id="preview" style="width:80%; height: auto;" />
						</div>-->			
					</div>
					<!--<div class="row">							
						<div class="col-md-12 text-center">
							<button type="submit" id="btnSave" onclick="save_data()" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>-->
							
					<?php
						echo form_close();
					?>
				</div>
				
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<button type="submit" id="btnSave" onclick="save_data()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>