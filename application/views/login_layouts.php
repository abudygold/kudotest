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
	
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>plugins/iCheck/square/blue.css">	
	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>dist/css/custom.css" />
	
</head>
<body class="hold-transition login-page">
	
	<div class="login-box">		
	  	<div class="login-logo">
	    	<a href="<?php echo base_url(); ?>">
				<?php echo $sess_title; ?>
			</a>
	  	</div>
	  	<div class="login-box-body">
			<?php
				if(( !empty($this->session->flashdata('message')) || !empty($message) )) {
					echo (!empty($message))? $message : $this->session->flashdata('message');
				}
			?>
		
	  		<!-- Main Content -->
			<?php echo $contents ?>
	  	</div>
	</div>

	<script src="<?php echo base_url('assets/'); ?>plugins/jQuery/jquery-3.1.1.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/iCheck/icheck.min.js"></script>
	<script>
		$(function() {
		    $('input').iCheck({
		  		checkboxClass: 'icheckbox_square-blue',
			  	radioClass: 'iradio_square-blue',
			  	increaseArea: '20%'
		    });
		});
	</script>

</body>
</html>
