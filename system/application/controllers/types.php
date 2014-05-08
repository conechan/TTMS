<?php
class Types extends Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('login_manager', array('admin' => TRUE));
    }

    function index()
    {
        $type = new Type();
        $type->get_iterated();

        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Name', 'Notice for users', 'Manage');
        foreach ($type as $s)
        {
            $this->table->add_row($s->name, $s->intro,
                    anchor('types/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('types/delete/'.$s->id,'delete', 'class="delete"')
                    );
        }
        
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'Admin Types', 'section' => 'admin'));
        $this->load->view('types/list', $data);
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $type = new Type();
        $this->_edit($type, 'types/add/save', $save);
    }

    function edit($id)
    {
        $type = new Type();
        if($id == 'save')
        {
            $type->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $type->get_by_id($id);
            $save = FALSE;
        }
        if($type->exists())
        {
            $this->_edit($type, 'types/edit/save', $save);
        }
        else
        {
            show_error('Invalid Type ID');
        }
    }

    function _edit($type, $url, $save)
    {
        if($save)
        {
            $type->trans_start();

            $rel = $type->from_array($_POST, array(
                'name',
                'intro'
            ));
            
            $exists = $type->exists();
            if($type->save($rel))
            {
                $type->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This type was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This type was created successfully.');
				}
                redirect('types');
            }
        }
        
        $type->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
            'intro'
        );
        $this->load->view('template/header', array('title' => 'Admin Types', 'section' => 'admin'));
        $this->load->view('types/edit', array('type' => $type, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');
    }

	function delete($id = 0)
	{
		$type = new Type();
		$type->get_by_id($id);
		if( ! $type->exists())
		{
			show_error('Invalid Onwer Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $type->name;
			$type->delete();
			$this->session->set_flashdata('message', 'The type ' . $name . ' was successfully deleted.');
			redirect('types');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('types');
		}
        $this->load->view('template/header', array('title' => 'Admin Types', 'section' => 'admin'));
		$this->load->view('types/delete', array('type' => $type));
        $this->load->view('template/footer');
	}
 

}
