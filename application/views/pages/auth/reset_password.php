<h3 class="login-box-msg"><?php echo lang('reset_password_heading'); ?></h3>

<div id="infoMessage"><?php echo $message;?></div>
	
<?php echo form_open("auth/reset_password/".$code); ?>

  	<div class="form-group has-feedback">
  		<?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?>
        <?php echo form_input($new_password, '', array('class'=>'form-control')); ?>        
  	</div>
  	<div class="form-group has-feedback">
  		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?>
        <?php echo form_input($new_password_confirm, '', array('class'=>'form-control')); ?>        
  	</div>
  	<div class="row">
        <div class="col-xs-12 pull-right">
          	<?php echo form_submit('submit', lang('reset_password_submit_btn'), array('class'=>'btn btn-primary btn-block btn-flat')); ?>
        </div>
  	</div>
  	
  	<?php echo form_input($user_id); ?>
	<?php echo form_hidden($csrf); ?>
  	
<?php echo form_close(); ?>

<br /><a href="<?php echo base_url('auth'); ?>"><?php echo lang('login_submit_btn');?></a>