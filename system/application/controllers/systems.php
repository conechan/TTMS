<?php
class Systems extends Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('login_manager', array('admin' => TRUE));
    }

    function index($offset = 0)
    {
        //pagination parameter
        $uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
        
        //get data
        $system = new System();
        $system->get_iterated(10, $offset);
        
        //generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('systems/index/');
        $config['total_rows'] = $system->count();
        $config['per_page'] = 10;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

        //generate table
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Name', 'Owner', 'Manage');
        foreach ($system as $s)
        {
            $this->table->add_row($s->name, $s->owner->name,
                    anchor('systems/view/'.$s->id,'view', 'class="view"').' '.
                    anchor('systems/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('systems/delete/'.$s->id,'delete', 'class="delete"')
                    );
        }
            
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'Admin Systems', 'section' => 'admin'));

        $this->load->view('systems/list', $data);    
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $system = new System();
        $this->_edit($system, 'systems/add/save', $save);
    }

    function edit($id)
    {
        $system = new System();
        if($id == 'save')
        {
            $system->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $system->get_by_id($id);
            $save = FALSE;
        }
        if($system->exists())
        {
            $this->_edit($system, 'systems/edit/save', $save);
        }
        else
        {
            show_error('Invalid System ID');
        }
    }

    function _edit($system, $url, $save)
    {
        if($save)
        {
            $system->trans_start();

            $rel = $system->from_array($_POST, array(
                'name',
                'owner'
            ));
            
            $exists = $system->exists();
            if($system->save($rel))
            {
                $system->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This system was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This system was created successfully.');
				}
                redirect('systems/view/' . $system->id);
            }
        }
        
        $system->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
            'owner'
        );
        $this->load->view('template/header', array('title' => 'Admin Systems', 'section' => 'admin'));
        $this->load->view('systems/edit', array('system' => $system, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');

    }

    function view($id)
    {
        $system = new System();
        //$system->include_related('owner','name', TRUE, TRUE);
        $system->get_by_id($id);
        if( ! $system->exists())
        {
            show_error('Invalid System ID');
        }

        //$system->owners->get_iterated();
        $this->load->view('template/header', array('title' => 'Admin Systems', 'section' => 'admin'));
        $this->load->view('systems/view', array('system' => $system));
        $this->load->view('template/footer');

    }

	function delete($id = 0)
	{
		$system = new System();
		$system->get_by_id($id);
		if( ! $system->exists())
		{
			show_error('Invalid System Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $system->name;
			$system->delete();
			$this->session->set_flashdata('message', 'The system ' . $name . ' was successfully deleted.');
			redirect('systems');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('systems');
		}
        $this->load->view('template/header', array('title' => 'Admin Systems', 'section' => 'admin'));
	    $this->load->view('systems/delete', array('system' => $system));
        $this->load->view('template/footer');
	}
 
}
