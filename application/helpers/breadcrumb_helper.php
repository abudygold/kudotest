<?php

if(!function_exists('generatedBreadcrumb')) {
	
    function generateBreadcrumb() {
		
        $ci = &get_instance();
        $i = 1;
        $uri = $ci->uri->segment($i);
        $link = '<ol class="breadcrumb">';

        while($uri != '') {
			
			$prep_link = '';
			
			for($j=1; $j<=$i; $j++) {
				$prep_link .= $ci->uri->segment($j).'/';
			}
			
			if($ci->uri->segment($i+1) == '') {
				if(!is_numeric($ci->uri->segment($i))) {
					$link .= '<li><a href='.site_url($prep_link).'>';
					$link .= ucwords( str_replace(array( '-', '_' ), ' ', $ci->uri->segment($i)) ).'</a></li>';
				}
			} else {
				if(!is_numeric($ci->uri->segment($i))) {
					$link .= '<li><a href='.site_url($prep_link).$ci->uri->segment(3).'>';
					$link .= ucwords( str_replace(array( '-', '_' ), ' ', $ci->uri->segment($i)) ).'</a></li>';
				}
			}			

			$i++;
			$uri = $ci->uri->segment($i);
        }
		
        $link .= '</ol>';
		
        return $link;
	}
}