<?php
	$sess_copyright = (isset($this->session->userdata['config']))? $this->session->userdata['config']['admin_copyright'] : '';
?>

<footer class="main-footer">
	<div class="pull-right hidden-xs">
		Page rendered in <strong>{elapsed_time}</strong> seconds | 
		<b>Version</b> 1.0
	</div>
	<strong>
		<?php
			$sess_copyright = str_replace('{year}', date('Y'), $sess_copyright);
			echo $sess_copyright; 
		?>
	</strong>
</footer>

<!--<aside class="control-sidebar control-sidebar-dark">
	<div class="tab-content">
		<div class="tab-pane" id="control-sidebar-home-tab"></div>
	</div>
</aside>-->