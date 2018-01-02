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
				for(var i=0; i<ca.length; i++) {
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
						"url": ""+ base_url +"groups/getDataGroup",
						"dataType": "json",
						"type": "POST",
						"data": function ( data ) {
							data.group_name = $("#group_name").val();
							data.'.$this->security->get_csrf_token_name().' = csrf;
						}
					},
					"columns": [
						{ "data": "id", orderable: false },
						{ "data": "nama" },
						{ "data": "deskripsi" },
						{ "data": "id", orderable: false }
					],
					"createdRow": function ( row, data, index ) {
						var info = $("#example").DataTable().page.info();
						var info_page = info.page+1;
						
						if(info_page > 1) {
							var index_inc = index+1;
							var pages = ""+info_page+""+index_inc+"";
						} else {
							var pages = index+1;
						}
						
						$("td", row).eq(0).html(pages);		
						$("td", row).eq(3).html(
							\'<a class="btn btn-primary btn-sm" onclick="btn_update(\'+ data.id + \')"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger btn-sm" onclick="btn_delete(\'+ data.id + \')"><i class="fa fa-remove"></i> Delete</button>\'
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

			function add_data() {
				
				save_method = "add";
				$("#formUpdate")[0].reset();				
				$("#modal-default").modal("show");				
				$(".modal-title").text("Add Group");
			}
				
			function btn_update(id) {
				
				save_method = "update";
				$("#formUpdate")[0].reset();
				$("#modal-default").modal("show");
				$(".modal-title").text("Edit Group");
				
				$.ajax({
					"url": base_url + "groupAjaxUpdate/" + id,
					"type": "POST",
					"dataType": "json",
					"contentType": false,
					"processData": false,
					"success": function(data) {
						$("#groupid").val(data.id);
						$("#groupname").val(data.nama);
						$("#description").val(data.deskripsi);
					}
				});
			}
			
			function save_data(event) {

				$("#btnSave").text("saving...");
				$("#btnSave").attr("disabled", true);
				
				var url = "'.site_url("addGroup").'";

				if(save_method == "update") {
					url = "'.site_url("groupUser").'";
				}
				
				/* var formData = new FormData($("#formUpdate").serialize()); */
				var formData = new FormData($("#formUpdate")[0]);
				
				$.ajax({
					"url": url,
					"type": "POST",
					"data": formData,
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
				
			function btn_delete(id) {

				$.ajax({
					"url": base_url + "deleteGroup/" + id,
					"type": "POST",
					"dataType": "json",
					"contentType": false,
					"processData": false,
					"success": function(data) {
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
					echo form_label('Name', 'group_name', $attributes);
					
					$data = array(
					  'name'        => 'name',
					  'id'          => 'group_name',
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
			<h3 class="box-title">All Group</h3>

			<div class="box-tools pull-right">
				<button class="btn btn-primary" onclick="add_data()">Add Group</button>
			</div>
		</div>
		<div class="box-body">
		
			<table id="example" class="table table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
			
		</div>
	</div>
	<!-- /.box -->
	
</div>

<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
					
						<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'formUpdate');
							
							echo form_open('#', $attributes);
							
								echo form_hidden('id', '', '', 'groupid');
							
								/*-- name --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Group Name', 'group_name', $attributes);
								
								$data = array(
									'name' => 'group_name',
									'id' => 'groupname',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-9">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- description --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Description', 'description', $attributes);
								
								$data = array(
									'name' => 'group_description',
									'id' => 'description',
									'class' => 'form-control'
								);
								echo '<div class="col-sm-9">'.form_input($data).'</div>';
								echo '</div>';
									
							echo form_close();
						?>
						
					</div>
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