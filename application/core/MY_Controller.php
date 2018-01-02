<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
 	protected $login_layouts = 'login_layouts';
 	protected $app_layouts = 'app_layouts';
	 
 	protected function login_render($content)
 	{
		//if ( !$this->ion_auth->logged_in() || !$this->ion_auth->is_admin() )
		if ( $this->ion_auth->logged_in() ) {
			redirect('welcome', 'refresh');
		}
		
		/* Load config */
		if(!$this->session->userdata('config'))
			$this->configuration->load_configs();
		
 	 	$view_data = array(
 	 		'contents' => $content
		);
		
    	$this->load->view($this->login_layouts, $view_data);
  	}
	 
 	protected function app_render($content)
 	{
		//if ( !$this->ion_auth->logged_in() || !$this->ion_auth->is_admin() )
		if ( !$this->ion_auth->logged_in() ) {
			redirect('login', 'refresh');
		}
		
		/* Load config */
		if(!$this->session->userdata('config'))
			$this->configuration->load_configs();
		/* Load userRoles */
		if(!$this->session->userdata('userRoles'))
			$this->configuration->userRole();
		/* Load _menus */
		if(!$this->session->userdata('_menus'))
			$this->configuration->load_menus();
		
 	 	$view_data = array(
 	 		'contents' => $content
		);
		
    	$this->load->view($this->app_layouts, $view_data);
  	}
	
}