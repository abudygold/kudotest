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
			
			<?php echo form_open(uri_string(), array('class'=>'form-horizontal col-sm-12')); ?>
			
				<?php echo form_hidden('id', $user->id);?>
	      		<?php echo form_hidden($csrf); ?>

	            <?php echo lang('edit_user_fname_label', 'first_name'); ?>
	            <?php echo form_input($first_name, '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_lname_label', 'last_name'); ?>
            	<?php echo form_input($last_name, '', array('class'=>'form-control')); ?>
            	
	            <?php echo lang('edit_user_company_label', 'company'); ?>
	            <?php echo form_input($company, '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_phone_label', 'phone'); ?>
            	<?php echo form_input($phone, '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_password_label', 'password'); ?>
            	<?php echo form_input($password, '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?>
            	<?php echo form_input($password_confirm, '', array('class'=>'form-control')); ?>
            	
        		<?php if ($this->ion_auth->is_admin()): ?>

	          		<h3><?php echo lang('edit_user_groups_heading'); ?></h3>
		          	<?php foreach ($groups as $group): ?>
		              	<label class="checkbox">
		              		<?php
			                  	$gID=$group['id'];
			                  	$checked = null;
			                  	$item = null;
			                  	foreach($currentGroups as $grp) {
			                      	if ($gID == $grp->id) {
			                          	$checked= ' checked="checked"';
			                      		break;
			                      	}
			                  	}
			              	?>
			              	<input type="checkbox" name="groups[]" class="flat-red" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
		              		<?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
		              	</label>
		          	<?php endforeach; ?>
		
	      		<?php endif ?>
		            
		      	<br />
				<div class="text-center">
					<?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class'=>'btn btn-primary')); ?>
				</div>
			
			<?php echo form_close();?>
			
		</div>
	</div>
	<!-- /.box -->

</div>