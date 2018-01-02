<?php
	/* set external css */
	$external_css = array(
		'<link rel="stylesheet" href="'.base_url('assets/plugins/datatables/css/jquery.dataTables.min.css').'">'
	);	
	$this->session->set_tempdata('external_css', $external_css);
	
	/* set external js */
	$external_js = array(
		'<script src="'.base_url('assets/plugins/datatables/js/jquery.dataTables.min.js').'"></script>',
		'<script>
			function addData() {
				
				save_method = "add";
				
				$("#formUpdate")[0].reset();
				$(".form-group").removeClass("has-error");
				$(".help-block").empty();
				$("#modal-default").modal("show");
				$(".modal-title").text("Add Menu");
			}
			
			function editData(id) {
				
				save_method = "update";
				
				$("#formUpdate")[0].reset();
				$(".form-group").removeClass("has-error");
				$(".help-block").empty();
			
				$.ajax({
					url : currentUrl + "editData/" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
						
						$("#val_menu_id").val(data.menu_id);
						$("#val_name").val(data.name);
						$("#val_controller").val(data.controller);
						$("#val_action").val(data.action);
						$("#val_plugin").val(data.plugin);
						$("#val_icon").val(data.icon);
						$("#val_parent_id").val(data.parent_id);
						$("#val_orders").val(data.orders);
						
						$("#modal-default").modal("show");
						$(".modal-title").text("Edit Menu");						
					}
				});
			}
			
			function saveData() {
				
				$("#btnSave").text("saving...");
				$("#btnSave").attr("disabled", true);
				var url;
			
				if(save_method == "add") {
					url = currentUrl + "addData";
				} else {
					url = currentUrl + "updateData";
				}
			
				var formData = new FormData($("#formUpdate")[0]);
				$.ajax({
					url : url,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					dataType: "JSON",
					success: function(data) {
						if(data.status)
						{
							$("#modal-default").modal("hide");
							location.reload();
						} else {								
							$(".modal-alert").css("display", "block");
							$(".display-alert").html(data);
						}
						
						$("#btnSave").text("Save");
						$("#btnSave").attr("disabled", false);
					}, error: function (jqXHR, textStatus, errorThrown) {								
						$(".modal-alert").css("display", "block");
						$(".display-alert").html(errorThrown);
						
						$("#btnSave").text("Save");
						$("#btnSave").attr("disabled", false);				
					}
				});
			}
			
			function deleteData(id) {
				
				if(confirm("Are you sure delete this data?")) {
					
					$.ajax({
						url : currentUrl + "deleteData/" + id,
						type: "POST",
						dataType: "JSON",
						success: function(data) {
							$("#modal-default").modal("hide");
							location.reload();
						}, error: function (jqXHR, textStatus, errorThrown) {
							alert(error_delete_ajax);
						}
					});
			
				}
			}
			
			function bulkDelete(id) {
				
				if(confirm("Are you sure delete this data?")) {
					$.ajax({
						url : currentUrl + "bulkDelete/" + id,
						type: "POST",
						dataType: "JSON",
						success: function(data) {
							$("#modal-default").modal("hide");
							location.reload();
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert(error_delete_ajax);
						}
					});
			
				}
			}
		</script>'
	);	
	$this->session->set_tempdata('external_js', $external_js);
?>

<div class="row">
	<section class="content">
			
		<div class="col-md-12">
	      	<div class="box box-solid">
	        	<div class="box-header with-border">
	          		<h3 class="box-title">
						<button class="btn btn-success" onclick="addData()">
							<i class="glyphicon glyphicon-plus"></i> <?php echo $this->lang->line('add_menu'); ?>
						</button>
					</h3>
	        	</div>
	        	<div class="box-body">
	            
	        		<?php
		        		if(!empty($get_menus)) {
		        			foreach($get_menus->result() as $key=>$dt) {
					?>
		            	<div class="panel box box-primary">
						
		              		<div class="box-header with-border">
			                    <h4 class="box-title">
			                    	<?php                
										if( count($this->General_Model->get_parent($dt->menu_id)) > 0 ) {
									?>
				                      	<a data-toggle="collapse" data-parent="#accordion" href="#menu_<?php echo $dt->menu_id; ?>" class="collapsed" aria-expanded="false">
				                        	<?php echo $dt->orders; ?>. <?php echo ucwords($dt->name); ?>
				                      	</a>
			                      	<?php                
										} else {
									?>
				                      	<?php echo $dt->orders; ?>. <?php echo ucwords($dt->name); ?>
			                      	<?php                
										}
									?>
			                    </h4>
			                    <div class="pull-right">
									<a class="btn btn-xs btn-flat btn-primary" href="javascript:void(0)" title="Edit" onclick="editData('<?php echo $dt->menu_id; ?>')">
										<i class="glyphicon glyphicon-pencil"></i>
									</a>
									<a class="btn btn-xs btn-flat btn-danger" href="javascript:void(0)" title="Bulk Delete" onclick="bulkDelete('<?php echo $dt->menu_id; ?>')">
										<i class="glyphicon glyphicon-trash"></i>
									</a>
								</div>
							</div>
							
		                  	<div id="menu_<?php echo $dt->menu_id; ?>" class="panel-collapse collapse" aria-expanded="false">
		                    	<div class="box-body">
								
									<?php                
										if( count($this->General_Model->get_parent($dt->menu_id)) > 0 ) {
									?>
	
										<table class="table table-bordered">
											<thead>
												<tr>
													<th><?php echo $this->lang->line('name'); ?></th>
													<th><?php echo $this->lang->line('controller'); ?></th>
													<th><?php echo $this->lang->line('action'); ?></th>
													<th><?php echo $this->lang->line('plugin'); ?></th>
													<th><?php echo $this->lang->line('icon'); ?></th>
													<th><?php echo $this->lang->line('orders'); ?></th>
													<th><?php echo $this->lang->line('action_tables'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($this->General_Model->get_parent($dt->menu_id) as $key2=>$dt2) {
												?>
													<tr>
														<td><?php echo $dt2->name; ?></td>
														<td><?php echo $dt2->controller; ?></td>
														<td><?php echo $dt2->action; ?></td>
														<td><?php echo $dt2->plugin; ?></td>
														<td><i class="fa fa-<?php echo $dt2->icon; ?>"></i></td>
														<td><?php echo $dt2->orders; ?></td>
														<td>
															<a class="btn btn-xs btn-flat btn-primary" href="javascript:void(0)" title="Edit" onclick="editData('<?php echo $dt2->menu_id; ?>')">
																<i class="glyphicon glyphicon-pencil"></i>
															</a>
															<a class="btn btn-xs btn-flat btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData('<?php echo $dt2->menu_id; ?>')">
																<i class="glyphicon glyphicon-trash"></i>
															</a>
														</td>
													</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									
									<?php
										}
									?>
		                      
		                    	</div>
		                  	</div>
							
		                </div>
		            	
		        	<?php
		            		} 
						}
					?>
	            
	        	</div>
	      	</div>
	    </div>
	    
	    
	    <div class="modal fade" id="modal-default" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title"></h3>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
						
								<div class="modal-alert" style="display: none">
									<div class="alert alert-danger">
										<div class="display-alert"></div>
									</div>
								</div>
							
								<?php
									$attributes = array('class' => 'form-horizontal', 'id' => 'formUpdate');
									
									echo form_open('#', $attributes);
									
										echo form_hidden('menu_id', '', '', 'val_menu_id');
										/* echo form_hidden(
											$this->security->get_csrf_token_name(), 
											$this->security->get_csrf_hash()
										); */
									
										/*-- name --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Name', 'name', $attributes);
										
										$data = array(
											'name' => 'name',
											'id' => 'val_name',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
									
										/*-- controller --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Controller', 'controller', $attributes);
										
										$data = array(
											'name' => 'controller',
											'id' => 'val_controller',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
									
										/*-- action --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Action', 'action', $attributes);
										
										$data = array(
											'name' => 'action',
											'id' => 'val_action',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
									
										/*-- plugin --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Plugin', 'plugin', $attributes);
										
										$data = array(
											'name' => 'plugin',
											'id' => 'val_plugin',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
									
										/*-- icon --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Icon', 'icon', $attributes);
										
										$data = array(
											'name' => 'icon',
											'id' => 'val_icon',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
									
										/*-- parent_id --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Parent Menu', 'parent_id', $attributes);
										
										$data = array(
											'id' => 'val_parent_id',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_dropdown('parent_id', $temp_parent_id, '', $data).'</div>';
										echo '</div>';
									
										/*-- orders --*/
										echo '<div class="form-group">';
										$attributes = array('class' => 'col-sm-3 control-label');
										echo form_label('Order', 'orders', $attributes);
										
										$data = array(
											'name' => 'orders',
											'type' => 'number',
											'id' => 'val_orders',
											'class' => 'form-control'
										);
										echo '<div class="col-sm-9">'.form_input($data).'</div>';
										echo '</div>';
											
									echo form_close();
								?>
						
						<!--<form action="#" id="form" class="form-horizontal">-->
							
							<?php
								/* echo form_hidden('id', '', '', 'menu_id');
							
								echo '<div class="form-group">';
								echo form_label('Name', 'name');
								
								$data = array(
									'name' => 'name',
									'id' => 'val_name',
									'placeholder' => 'Name',
									'class' => 'form-control'
								);
								echo form_input($data);
								echo '</div>'; */
							
								/* Build form */
								/* echo $this->form_builder->build_form_horizontal(
									array(
										array(
											'id' => $this->security->get_csrf_token_name(),
											'type' => 'hidden',
											'value' => $this->security->get_csrf_hash()
										),
										array(
											'id' => 'menu_id',
											'name' => 'menu_id',
											'type' => 'hidden'
										),
										array(
											'id' => 'val_name',
											'name' => 'name',
											'placeholder' => 'Name',
											'label' => 'Name'
										),
										array(
											'id' => 'val_controller',
											'name' => 'controller',
											'placeholder' => 'Controller',
											'label' => 'Controller'
										),
										array(
											'id' => 'val_action',
											'name' => 'action',
											'placeholder' => 'Action',
											'label' => 'Action'
										),							
										array(
											'id' => 'val_plugin',
											'name' => 'plugin',
											'placeholder' => 'Plugin',
											'label' => 'Plugin'
										),							
										array(
											'id' => 'val_icon',
											'name' => 'icon',
											'placeholder' => 'Icon',
											'label' => 'Icon'
										),
										array(
											'id' => 'val_parent_id',
											'name' => 'parent_id',
											'type' => 'dropdown',
											'options' => $temp_parent_id
										),			
										array(
											'id' => 'val_orders',
											'name' => 'orders',
											'placeholder' => 'Order',
											'label' => 'Order'
										)
									)
								); */
							?>							
								
						<!--</form>-->
						
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="text-center">
							<button type="submit" id="btnSave" onclick="saveData()" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
			
	</section>
</div>