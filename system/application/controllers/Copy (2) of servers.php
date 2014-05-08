<?php
class Servers extends Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index($offset = 0)
    {
        $this->load->library('login_manager', array('admin' => TRUE));
        
        //pagination parameter
        $uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
        
        //get data
        $server = new Server();
        $server->get_iterated(10, $offset);
        
        //generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('servers/index/');
        $config['total_rows'] = $server->count();
        $config['per_page'] = 10;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

        //generate table
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Host name', 'IP', 'Type', 'System', 'Login name', 'Login password', 'root password','Actions', 'Manage');
        foreach ($server as $s)
        {
            $action_list = '';
            $system_list = '';
            $s->actions->get_iterated();
            $s->systems->get_iterated();
            foreach ($s->systems as $y)
            {
                $system_list = $system_list .' '. $y->name;
            }
            foreach ($s->actions as $a)
            {
                $action_list = $action_list."<li><a href=\"javascript:void(0);\" 
                    ip=\"$s->ip\" 
                    h_name=\"0\"
                    command=\"$a->command\" 
                    class=\"send\">". 
                    $a->name.
                    '</a></li>';
            }
                $this->table->add_row($s->name, $s->ip, $s->type->name,
                    $system_list, $s->login_name, $s->login_pwd, $s->root_pwd,
                    $action_list,
                    anchor('servers/view/'.$s->id,'view', 'class="view"').' '.
                    anchor('servers/edit/'.$s->id,'edit', 'class="edit"').' '.
                    anchor('servers/delete/'.$s->id,'delete', 'class="delete"').'<br />'.
                    anchor_popup('servers/guarant/'.$s->ip.'/'.$s->root_pwd, "<span class=\"gua\">Guarantee</span>")
                    );
        }
            
        $data['table'] = $this->table->generate();
        
        $this->load->view('template/header', array('title' => 'Admin Servers', 'section' => 'admin'));
        $this->load->view('servers/list', $data);
        $this->load->view('template/footer');
    }

    function find($type = '')
    {
        $this->load->library('login_manager');
        
		$type = $this->uri->segment(3);
        
        //get data
        $t = new Type();
        $server = new Server();

        $t->get_by_name("$type");
        $server->get_by_related($t);


        //generate table
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="find">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Host name', 'IP', 'Type', 'System', 'Actions');
        foreach ($server as $s)
        {
            $action_list = '';
            $system_list = '';
            $s->actions->get_iterated();
            $s->systems->get_iterated();
            foreach ($s->systems as $y)
            {
                $system_list = $system_list .' '. $y->name;
            }
            foreach ($s->actions as $a)
            {
                $action_list = $action_list."<li><a href=\"javascript:void(0);\" 
                    ip=\"$s->ip\" 
                    h_name=\"$s->name\"
                    command=\"$a->command\" 
                    class=\"send\">". 
                    $a->name.
                    '</a></li>';
            }
                $this->table->add_row($s->name, $s->ip, $s->type->name,
                    $system_list,
                    $action_list);
        }
            
        $data['table'] = $this->table->generate();
        
        $this->load->view('template/header', array('title' => "$type", 'section' => "$type"));
        $this->load->view('servers/find', $data);
        $this->load->view('template/footer');
    }

    function add($save = FALSE)
    {
        $this->load->library('login_manager', array('admin' => TRUE));
        
        $server = new Server();
        $this->_edit($server, 'servers/add/save', $save);
    }

    function edit($id)
    {
        $this->load->library('login_manager', array('admin' => TRUE));
        
        $server = new Server();
        if($id == 'save')
        {
            $server->get_by_id($this->input->post('id'));
            $save = TRUE;
        }
        else
        {
            $server->get_by_id($id);
            $save = FALSE;
        }
        if($server->exists())
        {
            $this->_edit($server, 'servers/edit/save', $save);
        }
        else
        {
            show_error('Invalid Server ID');
        }
    }

    function _edit($server, $url, $save)
    {
        $this->load->library('login_manager', array('admin' => TRUE));
        
        if($save)
        {
            $server->trans_start();

            $rel = $server->from_array($_POST, array(
                'name',
                'ip',
                'description',
                'login_name',
                'login_pwd',
                'root_pwd',
                'type',
                'system',
                'action'
            ));
            
            $exists = $server->exists();
            if($server->save($rel))
            {
                $server->trans_complete();

                if($exists)
                {
					$this->session->set_flashdata('message', 'This server was updated successfully.');
                }
				else
				{
					$this->session->set_flashdata('message', 'This server was created successfully.');
				}
                redirect('servers/view/' . $server->id);
            }
        }
        
        $server->load_extension('htmlform');

        $form_fields = array(
            'id',
            'name',
            'ip',
            'type',
            'system',
            'login_name',
            'login_pwd',
            'root_pwd',
            'action',
            'description'
        );
        $this->load->view('template/header', array('title' => 'Edit Servers', 'section' => 'admin'));
        $this->load->view('servers/edit', array('server' => $server, 'form_fields' => $form_fields, 'url' => $url));
        $this->load->view('template/footer');
    }

    function view($id)
    {
        $this->load->library('login_manager', array('admin' => TRUE));
        
        $server = new Server();
        //$server->include_related('owner','name', TRUE, TRUE);
        $server->get_by_id($id);
        if( ! $server->exists())
        {
            show_error('Invalid Server ID');
        }

        $server->actions->get_iterated();
        $this->load->view('template/header', array('title' => 'View Servers', 'section' => 'admin'));
        $this->load->view('servers/view', array('server' => $server));
        $this->load->view('template/footer');
    }

	function delete($id = 0)
	{
        $this->load->library('login_manager', array('admin' => TRUE));
        
		$server = new Server();
		$server->get_by_id($id);
		if( ! $server->exists())
		{
			show_error('Invalid Server Id');
		}
		if($this->input->post('deleteok') !== FALSE)
		{
			$name = $server->name;
			$server->delete();
			$this->session->set_flashdata('message', 'The server ' . $name . ' was successfully deleted.');
			redirect('servers');
		}
		else if($this->input->post('cancel') !== FALSE)
		{
			redirect('servers');
		}
        $this->load->view('template/header', array('title' => 'Delete Servers', 'section' => 'admin'));		
		$this->load->view('servers/delete', array('server' => $server));
        $this->load->view('template/footer');
	}

    function execute($ip = '', $command = '', $host = '0')
    {
        $this->load->library('login_manager');
        
    	$ip = $this->uri->segment(3);
        $command = $this->uri->segment(4);
        $host = $this->uri->segment(5);
        $this->load->library('Command');
        $result = $this->command->run($ip, $command);
        $this->load->view('servers/result', array('result' => $result));
        
        if ($host != '0')
        {
            $record = new Record();
        
            $record->name = $this->session->userdata('user_name');
            $record->host = $host;
            $record->ip = $ip;
            $record->command = $command;

            $record->trans_start();
            $record->save();
            $record->trans_complete();
        }

    }

    function guarant($ip = '', $rpasswd = '')
    {
        $this->load->library('login_manager');
        
    	$ip = $this->uri->segment(3);
        $rpasswd = $this->uri->segment(4);
        $this->load->library('Command');
        $result = $this->command->guarant($ip, $rpasswd);
        $this->load->view('servers/result', array('result' => $result));
    }
 
}
