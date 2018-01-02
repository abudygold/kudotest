<div class="col-md-12 col-xs-12">

	<!-- box -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('create_group_heading');?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">

			<p><?php echo lang('create_group_subheading');?></p>
			
			<?php echo form_open("auth/create_group", array('class'=>'form-horizontal col-sm-12')); ?>
			
	            <?php echo lang('create_group_name_label', 'group_name'); ?>
	            <?php echo form_input($group_name, '', array('class'=>'form-control')); ?>
	
	            <?php echo lang('create_group_desc_label', 'description'); ?>
	            <?php echo form_input($description, '', array('class'=>'form-control')); ?>
	      
	      		<br />
	      		<?php echo form_submit('submit', lang('create_group_submit_btn'), array('class'=>'btn btn-primary'));?>
			
			<?php echo form_close();?>
			
		</div>
	</div>
	<!-- /.box -->

</div>