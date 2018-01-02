<h3 class="login-box-msg"><?php echo lang('forgot_password_heading'); ?></h3>
<p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
	
<?php echo form_open("forgot"); ?>

  	<div class="form-group has-feedback">
  		<?php 
			echo(($type=='email')?
				sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));
			echo form_input($identity, '', array('class'=>'form-control'));
		?>        
  	</div>
  	<div class="row">
        <div class="col-xs-12 pull-right">
          	<?php
				echo form_submit('submit', lang('forgot_password_submit_btn'), array('class'=>'btn btn-primary btn-block btn-flat'));
			?>
			<a class="btn btn-success btn-block btn-flat" href="<?php echo base_url('login'); ?>"><?php echo lang('login_submit_btn');?></a>
        </div>
  	</div>
  	
<?php echo form_close(); ?>
