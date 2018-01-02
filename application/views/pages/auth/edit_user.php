<?php
	/* set external js */
	$external_js = array(
		'<script>
			function save_data() {

				$("#btnSave").text("saving...");
				$("#btnSave").attr("disabled", true);
				
				/* var formData = new FormData($("#formUpdate").serialize()); */
				var formData = new FormData($("#formUpdate")[0]);
				
				$.ajax({
					"url": "'.site_url("editUser").'",
					"type": "POST",
					"data": formData,
					"cache": false,
					"contentType": false,
					"processData": false,
					"dataType": "json",
					"success": function(data) {
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
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('edit_user_heading');?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			
			<p><?php echo lang('edit_user_subheading'); ?></p>
			
			<?php //echo form_open(uri_string(), array('class'=>'form-horizontal col-sm-12')); ?>
			
			<?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'formUpdate');
				echo form_open('', $attributes);
			?>
			
				<?php echo form_hidden('id', $dataPengguna->id); ?>

	            <?php echo lang('edit_user_fname_label', 'first_name'); ?>
	            <?php echo form_input('nama_pertama', $dataPengguna->nama_pertama, array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_lname_label', 'last_name'); ?>
            	<?php echo form_input('nama_terakhir', $dataPengguna->nama_terakhir, array('class'=>'form-control')); ?>
            	
	            <?php echo lang('edit_user_company_label', 'company'); ?>
	            <?php echo form_input('alamat', $dataPengguna->alamat, array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_phone_label', 'phone'); ?>
            	<?php echo form_input('telpon', $dataPengguna->telpon, array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_password_label', 'password'); ?>
            	<?php echo form_input('password', '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?>
            	<?php echo form_input('password_confirm', '', array('class'=>'form-control')); ?>
		            
		      	<br />
				<div class="text-center">
					<button type="submit" id="btnSave" onclick="save_data()" class="btn btn-primary">Edit</button>
				</div>
			
			<?php echo form_close();?>
			
		</div>
	</div>
	<!-- /.box -->

</div>