<div class="col-md-12 col-xs-12">

	<!-- box -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('create_user_heading');?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			
			<p><?php echo lang('create_user_subheading'); ?></p>
			
			<?php echo form_open("auth/create_user", array('class'=>'form-horizontal col-sm-12'));?>
		
            	<?php echo lang('create_user_fname_label', 'first_name');?>
            	<?php echo form_input($first_name, '', array('class'=>'form-control')); ?>
            	
            	<?php echo lang('create_user_lname_label', 'last_name'); ?>
            	<?php echo form_input($last_name, '', array('class'=>'form-control')); ?>		      
            	
		      	<?php
				  	if($identity_column!=='email') {
						echo '<p>';
						echo lang('create_user_identity_label', 'identity');
						echo '<br />';
						echo form_error('identity');
						echo form_input($identity, '', array('class'=>'form-control'));
						echo '</p>';
				  	}
		      	?>
		
	            <?php echo lang('create_user_company_label', 'company'); ?> 
	            <?php echo form_input($company, '', array('class'=>'form-control')); ?>
	            
	            <?php echo lang('create_user_email_label', 'email'); ?>
	            <?php echo form_input($email, '', array('class'=>'form-control')); ?>

	            <?php echo lang('create_user_phone_label', 'phone'); ?>
	            <?php echo form_input($phone, '', array('class'=>'form-control')); ?>

	            <?php echo lang('create_user_password_label', 'password'); ?>
	            <?php echo form_input($password, '', array('class'=>'form-control')); ?>

	            <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?>
	            <?php echo form_input($password_confirm, '', array('class'=>'form-control')); ?>
		      	
		      	<br />		      	
		      	<?php echo form_submit('submit', lang('create_user_submit_btn'), array('class'=>'btn btn-primary')); ?>
		
			<?php echo form_close(); ?>
			
		</div>
	</div>
	<!-- /.box -->

</div>
