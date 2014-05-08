<?php
class Owners extends Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('login_manager', array('admin' => TRUE));
    }

    function index()
    {
        $owner = new Owner();
        $owner->get_iterated();

        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Name', 'Manage');
        foreach ($owner as $s)
        {
            $this->table->add_row($s->name,
                    anchor('owners/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('owners/delete/'.$s->id,'delete', 'class="delete"')
                    );
        }
        
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'Admin Owners', 'section' => 'admin'));

        $this->load->view('owners/list', $data);
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $owner = new Owner();
        $this->_edit($owner, 'owners/add/save', $save);
    }

    function edit($id)
    {
        $owner = new Owner();
        if($id == 'save')
        {
            $owner->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $owner->get_by_id($id);
            $save = FALSE;
        }
        if($owner->exists())
        {
            $this->_edit($owner, 'owners/edit/save', $save);
        }
        else
        {
            show_error('Invalid Owner ID');
        }
    }

    function _edit($owner, $url, $save)
    {
        if($save)
        {
            $owner->trans_start();

            $rel = $owner->from_array($_POST, array(
                'name',
            ));
            
            $exists = $owner->exists();
            if($owner->save($rel))
            {
                $owner->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This owner was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This owner was created successfully.');
				}
                redirect('owners');
            }
        }
        
        $owner->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
        );
        $this->load->view('template/header', array('title' => 'Admin Owners', 'section' => 'admin'));
        $this->load->view('owners/edit', array('owner' => $owner, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');

    }

	function delete($id = 0)
	{
		$owner = new Owner();
		$owner->get_by_id($id);
		if( ! $owner->exists())
		{
			show_error('Invalid Onwer Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $owner->name;
			$owner->delete();
			$this->session->set_flashdata('message', 'The owner ' . $name . ' was successfully deleted.');
			redirect('owners');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('owners');
		}
        $this->load->view('template/header', array('title' => 'Admin Owners', 'section' => 'admin'));
		
		$this->load->view('owners/delete', array('owner' => $owner));
        $this->load->view('template/footer');

	}
 

}
