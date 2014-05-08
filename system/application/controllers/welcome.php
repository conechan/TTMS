<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
        $this->load->library('login_manager');
	}
	
	function index()
	{
		$this->load->view('template/header', array('title' => 'Welcome', 'section' => 'welcome'));
        $this->load->view('welcome/index');
        $this->load->view('template/footer');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
