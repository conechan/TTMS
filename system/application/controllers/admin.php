<?php

class Admin extends Controller {

	function Admin()
	{
		parent::Controller();	
        $this->load->library('login_manager', array('admin' => TRUE));
	}
	
	function index()
	{
		$this->load->view('template/header', array('title' => 'Admin', 'section' => 'admin'));
        $this->load->view('admin/index');
        $this->load->view('template/footer');
	}

    function help_common()
	{
		$this->load->view('template/header', array('title' => 'Admin', 'section' => 'admin'));
        $this->load->view('admin/help_common');
        $this->load->view('template/footer');
	}

    function help_dev()
	{
		$this->load->view('template/header', array('title' => 'Admin', 'section' => 'admin'));
        $this->load->view('admin/help_dev');
        $this->load->view('template/footer');
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
