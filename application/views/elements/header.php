<?php
	$sess_title = (isset($this->session->userdata['config']))? $this->session->userdata['config']['app_name'] : '';
	$sess_subtitle = (isset($this->session->userdata['config']))? $this->session->userdata['config']['app_short_name'] : '';
?>

<header class="main-header">
	<a href="<?php echo base_url('welcome'); ?>" class="logo">
		<span class="logo-mini"><?php echo $sess_subtitle; ?></span>
		<span class="logo-lg"><?php echo $sess_title; ?></span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<span class="hidden-xs">
							<?php echo($this->session->userdata('username'))? ucwords($this->session->userdata('username')) : ''; ?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<img src="<?php echo base_url('assets/'); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
							<p>
								<?php echo($this->session->userdata('username'))? ucwords($this->session->userdata('username')) : ''; ?>
								<?php
									$difference = $created_on = '';
									
									if($this->session->userdata('dibuat_tgl')) {
										$post_date = $this->session->userdata('dibuat_tgl');
										$created_on = date("M. Y", $post_date);
										$difference = timespan($post_date, time(), 2);
									}
								?>
								<small>Member since <?php echo $created_on; ?></small>
								<small>(<?php echo $difference; ?>)</small>
							</p>
						</li>
						<li class="user-footer text-center">
							<!--<div class="pull-left">
								<a href="<?php //echo base_url('editUser/'.$this->session->userdata('user_id')); ?>" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="<?php //echo base_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
							</div>-->
							<a href="<?php echo base_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
			</ul>
		</div>
	</nav>
</header>