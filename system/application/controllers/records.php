<?php
class Records extends Controller {

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
        $record = new Record();
        $record->get_iterated(20, $offset);
        
        //generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('records/index/');
        $config['total_rows'] = $record->count();
        $config['per_page'] = 20;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

        //generate table
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $tmpl = array ( 'table_open'  => '<table class="list">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('When', 'Who', 'Action');
        foreach ($record as $r)
        {
            $this->table->add_row($r->created, $r->name,
                    "submit <span class=\"bb\">$r->command</span> on <span class=\"bb\">$r->host</span>($r->ip)."
                                  );
        }
            
        $data['table'] = $this->table->generate();
        $this->load->view('template/header', array('title' => 'See Records', 'section' => 'admin'));

        $this->load->view('records/list', $data);    
        $this->load->view('template/footer');
    }
}
