<div class="col-md-12 col-xs-12">

	<!-- box -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo lang('edit_group_heading');?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			
			<p><?php echo lang('edit_group_subheading'); ?></p>
			
			<?php echo form_open(current_url(), array('class'=>'form-horizontal col-sm-12')); ?>

	            <?php echo lang('edit_group_name_label', 'group_name'); ?>
	            <?php echo form_input($group_name, '', array('class'=>'form-control')); ?>

            	<?php echo lang('edit_group_desc_label', 'description'); ?>
            	<?php echo form_input($group_description, '', array('class'=>'form-control')); ?>
		            
		      	<br />
		      	<?php echo form_submit('submit', lang('edit_group_submit_btn'), array('class'=>'btn btn-primary')); ?>
			
			<?php echo form_close();?>
			
		</div>
	</div>
	<!-- /.box -->

</div>