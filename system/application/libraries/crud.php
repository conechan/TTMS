<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Command Class
 *
 * This class enables you to mark points and calculate the time difference
 * between them.  Memory consumption can also be displayed.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/benchmark.html
 */
class Crud {
    
	function index($offset = 0, $controller = '', $model = '', $heading, )
	{
        
        $uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);


        $item = new $model;
        $item->get_iterated(10, $offset);
        
        $this->load->library('pagination');
        $config['base_url'] = site_url("$controller/index/");
        $config['total_rows'] = $item->count();
        $config['per_page'] = 10;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();


        $this->load->library('table');
        $this->table->set_empty("&nbsp;");

        //$this->table->set_heading('No', 'Name', 'Owner', 'Actions');
        $i = 0 + $offset;
        foreach ($system as $s)
        {
            $this->table->add_row(++$i, $s->name, $s->owner->name,
                    anchor('systems/view/'.$s->id,'view').' '.
                    anchor('systems/edit/'.$s->id,'edit').' '.
                    anchor('systems/delete/'.$s->id,'delete')
                    );

	}

}

// END Command class

/* End of file Command.php */
/* Location: ./system/application/libraries/Command.php */
