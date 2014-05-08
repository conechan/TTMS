<?php
class Actions extends Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('login_manager', array('admin' => TRUE));
    }

    function index()
    {
        //get data
        $action = new Action();
        $action->get_iterated();
        
        //generate table
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Name', 'Command', 'Description', 'Manage');
        foreach ($action as $s)
        {
            $this->table->add_row($s->name, $s->command, $s->description,
                    anchor('actions/view/'.$s->id,'view', 'class="view"').' '.
                    anchor('actions/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('actions/delete/'.$s->id,'delete', 'class="delete"')
                    );
        }
            
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'Admin Actions', 'section' => 'admin'));
        $this->load->view('actions/list', $data);    
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $action = new Action();
        $this->_edit($action, 'actions/add/save', $save);
    }

    function edit($id)
    {
        $action = new Action();
        if($id == 'save')
        {
            $action->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $action->get_by_id($id);
            $save = FALSE;
        }
        if($action->exists())
        {
            $this->_edit($action, 'actions/edit/save', $save);
        }
        else
        {
            show_error('Invalid Action ID');
        }
    }

    function _edit($action, $url, $save)
    {
        if($save)
        {
            $action->trans_start();

            $rel = $action->from_array($_POST, array(
                'name',
                'command',
                'description'
            ));
            
            $exists = $action->exists();
            if($action->save($rel))
            {
                $action->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This action was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This action was created successfully.');
				}
                redirect('actions/view/' . $action->id);
            }
        }
        
        $action->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
            'command',
            'description'
            );
        $this->load->view('template/header', array('title' => 'Admin Actions', 'section' => 'admin'));
        $this->load->view('actions/edit', array('action' => $action, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');
    }

    function view($id)
    {
        $action = new Action();
        //$action->include_related('owner','name', TRUE, TRUE);
        $action->get_by_id($id);
        if( ! $action->exists())
        {
            show_error('Invalid Action ID');
        }

        //$action->owners->get_iterated();
        $this->load->view('template/header', array('title' => 'Admin Actions', 'section' => 'admin'));
        $this->load->view('actions/view', array('action' => $action));
        $this->load->view('template/footer');
    }

	function delete($id = 0)
	{
		$action = new Action();
		$action->get_by_id($id);
		if( ! $action->exists())
		{
			show_error('Invalid Action Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $action->name;
			$action->delete();
			$this->session->set_flashdata('message', 'The action ' . $name . ' was successfully deleted.');
			redirect('actions');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('actions');
		}
		$this->load->view('template/header', array('title' => 'Admin Actions', 'section' => 'admin'));
		$this->load->view('actions/delete', array('action' => $action));
        $this->load->view('template/footer');

	}
 
}
