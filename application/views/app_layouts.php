<?php
	$server_url = base_url();
	$sess_title = (isset($this->session->userdata['config']))? $this->session->userdata['config']['app_name'] : '';
	//$sess_logo = (isset($this->session->userdata['config']))? $server_url.$this->session->userdata['config']['logo'] : '';
	$sess_favicon = '';//(isset($this->session->userdata['config']))? $server_url.$this->session->userdata['config']['favicon'] : '';
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<title><?php echo $sess_title .' | '. ucwords($this->router->class); ?></title>
	
    <link rel="icon" href="<?php echo $sess_favicon; ?>">

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/ionicons/css/ionicons.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/AdminLTE.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/skins/_all-skins.min.css" />
	<!--<link rel="stylesheet" href="<?php //echo base_url('assets/'); ?>plugins/iCheck/square/blue.css">-->
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/pace/pace.min.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/custom.css" />
	
	<?php
		/* set external css */
		if($this->session->tempdata('external_css')) {
			foreach($this->session->tempdata('external_css') as $value) {
				echo $value;		
			}
		}
		
		$this->session->unset_tempdata('external_css');
	?>
	
	<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>';
		var currentUrl = "<?php echo base_url($this->router->class); ?>/";
		var segment = "<?php echo $this->uri->segment(3); ?>";
		var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
	</script>

</head>
<body class="hold-transition skin-blue sidebar-mini">

	<!-- Wrapper -->
	<div class="wrapper">

		<!-- Header -->
		<?php
			$this->load->view('elements/header');
		?>

		<!-- SIDEBAR -->
		<?php
			$this->load->view('elements/sidebar');
		?>
		
		<!-- Content -->
		<div class="content-wrapper">		
			<!-- Breadcrumb -->
			<section class="content-header">
				<h1>
					<?php
						echo ucwords( str_replace(array( '-', '_' ), ' ', $this->router->class) );
					?> 
					<small>
						<?php
							echo ucwords( str_replace(array( '-', '_' ), ' ', $this->router->method) );
						?>
					</small>
				</h1>
				<?php
					echo generateBreadcrumb();
				?>
			</section>
	
			<?php
				/* -- Alert Not Allowed Access -- */
				echo ( $this->session->flashdata('not_allowed_access') ) ?	
				'<section class="content-header"><div class="alert alert-danger alert-dismissible">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        '.$this->session->flashdata('not_allowed_access').'
			  	</div></section>' : '';
		  	?>
		
			<!-- Main Content -->
			<section class="content">
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<?php
							if(( !empty($this->session->flashdata('message')) || !empty($message) ))
								echo (!empty($message))? $message : $this->session->flashdata('message');
						?>
					</div>
					
					<?php
						echo $contents
					?>
				</div>
			</section>
		</div>
		
		<!-- Footer -->
		<?php
			$this->load->view('elements/footer');
		?>
		
	</div>

	<!-- Script -->
	<script src="<?php echo base_url('assets/'); ?>plugins/jQuery/jquery-3.1.1.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/pace/pace.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/fastclick/fastclick.js"></script>
	<script src="<?php echo base_url('assets/'); ?>dist/js/adminlte.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>dist/js/demo.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/js-ucfirst/ucfirst.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/momentjs/moment.js"></script>
	<!--<script src="<?php //echo base_url('assets/'); ?>plugins/iCheck/icheck.min.js"></script>-->
	<script type="text/javascript">
		$(function() {
			$(document).ajaxStart(function() {
				Pace.restart();
			});
			
		    /* $('input').iCheck({
		  		checkboxClass: 'icheckbox_square-blue',
			  	radioClass: 'iradio_square-blue',
			  	increaseArea: '20%'
		    }); */
		});
	</script>
	
	<?php
		/* set external js */
		if($this->session->tempdata('external_js')) {
			foreach($this->session->tempdata('external_js') as $value) {
				echo $value;		
			}
		}
		
		$this->session->unset_tempdata('external_js');
	?>
	
</body>
</html>