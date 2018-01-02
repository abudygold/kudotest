<?php
/**
 * @author Abdullah Umar Babsel <abudy.gold@yahoo.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('has_alert'))
{
	function has_alert($type='', $message='')
	{
		$CI =& get_instance();
		
		$set_alert = '';
		
		if(!empty($message)) {
			/* danger, info, warning, success */
			$set_alert = '<div class="alert alert-'.$type.' alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				'.$message.'
			</div>';
		}
		
		return $set_alert;
	}
}
