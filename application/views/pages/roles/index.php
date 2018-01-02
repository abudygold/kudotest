<?php
	/* set external js */
	$external_js = array(
		'<script>
			$(".col_check").on("click", function(){
				var colnum = $(this).attr("data-col");
				$("input[data-col="+colnum+"]").prop("checked", this.checked);
			});
			
			$(".row_check").on("click", function(){
				var rownum = $(this).attr("data-row");
				$("input[data-row="+rownum+"]").prop("checked", this.checked);
			});
			
			$(".group_check").on("click", function(){
				var rownum = $(this).attr("data-group");
				$("input[data-group="+rownum+"]").prop("checked", this.checked);
			});
		</script>'
	);	
	$this->session->set_tempdata('external_js', $external_js);
?>

<div class="col-md-12 col-xs-12">
	<div class="box box-primary">
	
		<div class="box-header with-border">
			<h3 class="box-title">Menu Roles</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<?php
				$attributes = array('class' => 'form-horizontal');
				echo form_open('roles/add', $attributes);
			?>
			
				<table class="table table-bordered table-striped">
					<thead>
						<th class="text-center">Controller</th>
						<th class="text-center">Action</th>					
						<?php
							foreach($groups->result() as $row) {
						?>
							<th class="text-center"> 
								<?php echo ucwords($row->nama);?> <br />
								<input type="checkbox" class="col_check" data-col="<?php echo $row->nama; ?>" />
							</th>
						<?php
							}
						?> 
					</thead>
					<?php
						foreach($this->controllerlist->getControllers() as $k=>$d)
						{
							echo '<tr>';
							echo '<td rowspan="'.((!empty($d))? (count($d)+1) : 1).'"><pre>'.$k.' <input type="checkbox" class="group_check" data-group="'.$k.'" /></pre></td>';
							echo '</tr>';
							
							if(!empty($d))
							{
								echo '<tr>';
								foreach($d as $key=>$dt)
								{											
									echo '<td><pre>'.$dt.' <input type="checkbox" class="row_check" data-row="'.$k.$dt.'" /></pre></td>';
									
									$checked = '';
									
									foreach($groups->result() as $row)
									{
										$allGroups = unserialize($row->akses_menu);
										(isset($allGroups[$k]))? $arrOne=$allGroups[$k] : $arrOne='';
										
										echo '<td class="text-center">';										
										/*-- form_checkbox --*/
										$data = array(
											'type' => 'checkbox',
											'label' => false,
											'name' => $row->nama.'['.$k.'][]',
											'id' => strtolower($k)
										);
										echo form_checkbox(
											$data, $dt,
											( ($arrOne)?  ( (in_array($dt, $arrOne))? 'checked' : '' ) : $checked ),
											array(
												'data-col' => $row->nama,
												'data-row' => $k.$dt,
												'data-group' => $k
											)
										);
										echo '</td>';
									}
									
									echo '</tr><tr>';
								}
							}
						}
					?>
				</table>
				
				<div class="text-center">
					<button type="submit" id="submit" class="btn btn-primary">Submit</button>
				</div>
			
			<?php
				echo form_close();
			?>
		</div>
		
	</div>
</div>