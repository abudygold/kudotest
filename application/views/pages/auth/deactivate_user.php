<section class="content">

	<!-- box -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('deactivate_heading');?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			
			<p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>
			
			<?php echo form_open("auth/deactivate/".$user->id, array('class'=>'form-horizontal col-sm-12')); ?>
			
				<?php echo form_hidden($csrf); ?>
	  			<?php echo form_hidden(array('id'=>$user->id)); ?>

	            <?php
	            	echo $this->form_builder->build_form_horizontal(
						array(
							array(
								'id' => 'confirm',
								'label' => false,
								'type' => 'radio',
								'options' => array(
									array(
										'id' => 'yes',
										'value' => 'yes',
										'class' => 'flat-red',
										'label' => 'Yes'
									),
									array(
										'id' => 'no',
										'value' => 'no',
										'class' => 'flat-red',
										'label' => 'No'
									)
								)
							)
						)
					);
	            ?>	            
		            
		      	<br />
		      	<?php echo form_submit('submit', lang('deactivate_submit_btn'), array('class'=>'btn btn-primary')); ?>
			
			<?php echo form_close();?>
			
		</div>
	</div>
	<!-- /.box -->

</section>


<!--<h1><?php echo lang('deactivate_heading');?></h1>
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></p>

<?php echo form_close();?>-->