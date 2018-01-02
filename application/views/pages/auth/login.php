<p class="login-box-msg">
	<?php echo $this->lang->line('login_subheading'); ?>
</p>
	
<?php
	echo form_open("login");
?>
  	<div class="form-group has-feedback">
  		<?php
			echo $this->lang->line('login_identity_label', 'username');
			echo form_input($username, '', array('class'=>'form-control'));
		?>
  	</div>
  	<div class="form-group has-feedback">
  		<?php
			echo $this->lang->line('login_password_label', 'password');
			echo form_input($password, '', array('class'=>'form-control'));
		?>
  	</div>
  	<div class="row">
    	<div class="col-xs-8">
          	<div class="checkbox icheck">
              	<?php
					echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> <?php echo $this->lang->line('login_remember_label', 'remember');
				?>
	        </div>
    	</div>
        <div class="col-xs-4">
          	<?php
				echo form_submit('submit', $this->lang->line('login_submit_btn'), array('class'=>'btn btn-primary btn-block btn-flat'));
			?>
        </div>
  	</div>
<?php
	echo form_close();
?>

<a href="<?php echo base_url('forgot'); ?>">
	<?php echo $this->lang->line('login_forgot_password');?>
</a>