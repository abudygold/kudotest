<?php
	/* set external css */
	$external_css = array(
		'<link rel="stylesheet" href="'.base_url('assets/plugins/fancyBox/source/jquery.fancybox.css').'">'
	);	
	$this->session->set_tempdata('external_css', $external_css);
	
	/* set external js */
	$external_js = array(
		'<script src="'.base_url('assets/plugins/fancyBox/source/jquery.fancybox.pack.js').'"></script>',
		'<script src="'.base_url('assets/plugins/tinymce/tinymce.js').'"></script>',
		'<script src="'.base_url('assets/custom/tinymce.js').'"></script>',
		'<script src="'.base_url('assets/custom/configuration.js').'"></script>'
		//'<script src="'.base_url('assets/custom/favicon_responsive_file_manager.js').'"></script>'
	);	
	$this->session->set_tempdata('external_js', $external_js);
	
	$app_name = $app_short_name = $admin_copyright = $frontend_copyright = $website_logo = $favicon_logo = $contact_person = $contact_email = $contact_number = $fax_number = $contact_address = $meta_description = $meta_keywords = $facebook_url = $twitter_url = $youtube_url = $google_url = '';
	
	if(!empty($data)) {
		foreach($data->result_array() as $k=>$v) {
			
			if($v['judul'] === 'app_name')
				$app_name = $v['deskripsi'];
			if($v['judul'] === 'app_short_name')
				$app_short_name = $v['deskripsi'];
			if($v['judul'] === 'admin_copyright')
				$admin_copyright = $v['deskripsi'];
			if($v['judul'] === 'frontend_copyright')
				$frontend_copyright = $v['deskripsi'];
			if($v['judul'] === 'contact_person')
				$contact_person = $v['deskripsi'];
			if($v['judul'] === 'contact_email')
				$contact_email = $v['deskripsi'];
			if($v['judul'] === 'contact_number')
				$contact_number = $v['deskripsi'];
			if($v['judul'] === 'fax_number')
				$fax_number = $v['deskripsi'];
			if($v['judul'] === 'contact_address')
				$contact_address = $v['deskripsi'];
			if($v['judul'] === 'meta_description')
				$meta_description = $v['deskripsi'];
			if($v['judul'] === 'meta_keywords')
				$meta_keywords = $v['deskripsi'];
			if($v['judul'] === 'facebook_url')
				$facebook_url = $v['deskripsi'];
			if($v['judul'] === 'twitter_url')
				$twitter_url = $v['deskripsi'];
			if($v['judul'] === 'youtube_url')
				$youtube_url = $v['deskripsi'];
			if($v['judul'] === 'google_url')
				$google_url = $v['deskripsi'];
		}
	}
?>

<div class="row">
	<div class="col-md-12 col-xs-12">
		<section class="content">
			
			<?php
				$attributes = array('class' => 'form-horizontal');
				echo form_open('configurations/add', $attributes);
				
				echo form_input(array(
					'name' => 'website_logo',
					'type'=> 'hidden',
					'value'=> $website_logo,
					'id' => 'website_logo_txt'
				));
				echo form_input(array(
					'name' => 'favicon_logo',
					'type'=> 'hidden',
					'value'=> $favicon_logo,
					'id' => 'favicon_logo_txt'
				));
			?>
	
				<div class="nav-tabs-custom">
	          		
		            <ul class="nav nav-tabs">
		              	<li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
		              	<li><a href="#tab_2" data-toggle="tab">Contact</a></li>
		              	<li><a href="#tab_3" data-toggle="tab">SEO</a></li>
		              	<li><a href="#tab_4" data-toggle="tab">Social Media</a></li>
		            </ul>
		            
		            <div class="tab-content">
	              		<div class="tab-pane active" id="tab_1">

							<?php
								/*-- app_name --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('App Name', 'app_name', $attributes);
								
								$data = array(
									'name' => 'app_name',
									'id' => 'app_name',
									'value' => $app_name,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- app_short_name --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('App Short Name', 'app_short_name', $attributes);
								
								$data = array(
									'name' => 'app_short_name',
									'id' => 'app_short_name',
									'value' => $app_short_name,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- admin_copyright --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Admin Copyright Text', 'admin_copyright', $attributes);
								
								$data = array(
									'name' => 'admin_copyright',
									'id' => 'admin_copyright',
									'value' => $admin_copyright,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- frontend_copyright --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Frontend Copyright Text', 'frontend_copyright', $attributes);
								
								$data = array(
									'name' => 'frontend_copyright',
									'id' => 'frontend_copyright',
									'value' => $frontend_copyright,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
							?>
							
		              	</div>
		              	<div class="tab-pane" id="tab_2">

							<?php
								/*-- contact_person --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Contact Person', 'contact_person', $attributes);
								
								$data = array(
									'name' => 'contact_person',
									'id' => 'contact_person',
									'value' => $contact_person,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- contact_email --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Contact Email', 'contact_email', $attributes);
								
								$data = array(
									'name' => 'contact_email',
									'id' => 'contact_email',
									'value' => $contact_email,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- contact_number --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Contact Number', 'contact_number', $attributes);
								
								$data = array(
									'name' => 'contact_number',
									'id' => 'contact_number',
									'value' => $contact_number,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- fax_number --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Fax Number', 'fax_number', $attributes);
								
								$data = array(
									'name' => 'fax_number',
									'id' => 'fax_number',
									'value' => $fax_number,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
							
								/*-- contact_address --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Address', 'contact_address', $attributes);
								
								$data = array(
									'name' => 'contact_address',
									'id' => 'contact_address',
									'rows' => 3,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_textarea($data, $contact_address).'</div>';
								echo '</div>';
							?>
							
		              	</div>
		              	<div class="tab-pane" id="tab_3">

							<?php							
								/*-- meta_description --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Meta Description', 'meta_description', $attributes);
								
								$data = array(
									'name' => 'meta_description',
									'id' => 'meta_description',
									'rows' => 3,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_textarea($data, $meta_description).'</div>';
								echo '</div>';
							
								/*-- meta_keywords --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Meta Keywords', 'meta_keywords', $attributes);
								
								$data = array(
									'name' => 'meta_keywords',
									'id' => 'meta_keywords',
									'rows' => 3,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_textarea($data, $meta_keywords).'</div>';
								echo '</div>';
							?>
							
		              	</div>
	              		<div class="tab-pane" id="tab_4">	

							<?php
								/*-- facebook_url --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Facebook URL', 'facebook_url', $attributes);
								
								$data = array(
									'name' => 'facebook_url',
									'id' => 'facebook_url',
									'value' => $facebook_url,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- twitter_url --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Twitter URL', 'twitter_url', $attributes);
								
								$data = array(
									'name' => 'twitter_url',
									'id' => 'twitter_url',
									'value' => $twitter_url,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- youtube_url --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Youtube URL', 'youtube_url', $attributes);
								
								$data = array(
									'name' => 'youtube_url',
									'id' => 'youtube_url',
									'value' => $youtube_url,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
								
								/*-- google_url --*/
								echo '<div class="form-group">';
								$attributes = array('class' => 'col-sm-3 control-label');
								echo form_label('Google+ URL', 'google_url', $attributes);
								
								$data = array(
									'name' => 'google_url',
									'id' => 'google_url',
									'value' => $google_url,
									'class' => 'form-control'
								);
								echo '<div class="col-sm-8">'.form_input($data).'</div>';
								echo '</div>';
							?>
							
		              	</div>
		            </div>
					
					<div class="modal-footer">
						<div class="text-center">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
		            
	          	</div>	          	
	
			<?php
				echo form_close();
			?>
	
		</section>
	</div>
</div>