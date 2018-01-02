<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu" data-widget="tree">
		
			<?php
				if($this->session->userdata('_menus')) {
					
					foreach ($this->session->userdata('_menus') as $k=>$d) {
						
						$breakD = explode(";", $d['menu']);
						
						$name = $breakD[0];
						$icons = $breakD[4];
						
						if($d['sub_menu'])
						{
							$sub_active = '';
							
							foreach ($d['sub_menu'] as $key=>$dt) {
								$sub_breakD = explode(";", $dt);								
								if($sub_breakD[1] === $this->router->class)
									$sub_active='active';
							}
							
							$link = $breakD[1];
							($breakD[2] == $this->router->class)? $active='active' : $active=$sub_active;
							
							echo '<li class="treeview '.$active.'"><a href="'.$link.'"><i class="fa fa-'.$icons.'"></i> <span>'.$name.'</span>
							<span class="pull-right-container">
							  	<i class="fa fa-angle-left pull-right"></i>
							</span></a>';
							echo '<ul class="treeview-menu">';
							
								foreach ($d['sub_menu'] as $key=>$dt)
								{
									$sub_breakD = explode(";", $dt);
									
									$sub_name = $sub_breakD[0];
									
									if($sub_breakD[2] === 'index') {
										$sub_link = base_url( $sub_breakD[1] );
									} else {
										$sub_link = base_url( $sub_breakD[1].'/'.$sub_breakD[2].'/'.$sub_breakD[3] );
									}
									
									$sub_icons = $sub_breakD[4];
									($sub_breakD[1] == $this->router->class)? $sub_active='active' : $sub_active = '';
									
									echo '<li class="'.$sub_active.'"><a href="'.$sub_link.'"><i class="fa fa-'.$sub_icons.'"></i> '.$sub_name.'</a></li>';
								}
								
							echo '</ul>';
							echo '</li>';
						}
						else
						{
							if($breakD[1] !== '#') {
								
								if($breakD[2] === 'index') {
									$link = base_url( $breakD[1] );
								} else {
									($breakD[1] === 'profile')? $breakD[3] = str_replace('{id}', $this->session->userdata('pengguna_id'), $breakD[3]) : '';
									
									$link = base_url( $breakD[1].'/'.$breakD[2].'/'.$breakD[3] );
								}								
								
								($breakD[1] === $this->router->class)? $active='active' : $active='';
								
								echo '<li class="'.$active.'"><a href="'.$link.'"><i class="fa fa-'.$icons.'"></i> <span>'.$name.'</span></a></li>';
							}
						}

					}
				}
			?>
		</ul>
	</section>
</aside>