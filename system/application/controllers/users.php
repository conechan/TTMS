<?php
class Users extends Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('login_manager', array('admin' => TRUE));
    }

    function index()
    {
        $user = new User();
        $user->get_iterated();

        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Name', 'Manage');
        foreach ($user as $s)
        {
            $this->table->add_row($s->name,
                    anchor('users/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('users/delete/'.$s->id,'delete', 'class="delete"')
                    );
        }
        
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'Admin Users', 'section' => 'admin'));

        $this->load->view('users/list', $data);
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $user = new User();
        $this->_edit($user, 'users/add/save', $save);
    }

    function edit($id)
    {
        $user = new User();
        if($id == 'save')
        {
            $user->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $user->get_by_id($id);
            $save = FALSE;
        }
        if($user->exists())
        {
            $this->_edit($user, 'users/edit/save', $save);
        }
        else
        {
            show_error('Invalid User ID');
        }
    }

    function _edit($user, $url, $save)
    {
        if($save)
        {
            $user->trans_start();

            $rel = $user->from_array($_POST, array(
                'name',
            ));
            
            $exists = $user->exists();
            if($user->save($rel))
            {
                $user->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This user was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This user was created successfully.');
				}
                redirect('users');
            }
        }
        
        $user->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
        );
        $this->load->view('template/header', array('title' => 'Admin Users', 'section' => 'admin'));
        $this->load->view('users/edit', array('user' => $user, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');

    }

	function delete($id = 0)
	{
		$user = new User();
		$user->get_by_id($id);
		if( ! $user->exists())
		{
			show_error('Invalid Onwer Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $user->name;
			$user->delete();
			$this->session->set_flashdata('message', 'The user ' . $name . ' was successfully deleted.');
			redirect('users');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('users');
		}
        $this->load->view('template/header', array('title' => 'Admin Users', 'section' => 'admin'));
		
		$this->load->view('users/delete', array('user' => $user));
        $this->load->view('template/footer');

	}
 

}
