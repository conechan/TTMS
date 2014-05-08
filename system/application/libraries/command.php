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
class Command {
    
    var $pyscript_path = "/home/web/ttms/pyscript";

	function get_host_name($ip)
	{
        return (exec("python $this->pyscript_path/host.py $ip"));
	}

    function run($ip, $command)
    {
        return shell_exec("sudo python $this->pyscript_path/run.py $ip \"$command\"");
    }

    function guarant($ip, $rpasswd)
    {
        return shell_exec("sudo python $this->pyscript_path/guarant.py $ip $rpasswd");
    }

    function ping($ip)
    {
        $result = shell_exec("sudo python $this->pyscript_path/ping.py $ip");
        if ($result == 1)
            echo '<img src='. str_replace('ttms/', 'web/ttms/', site_url('img/good.png')). ' title="Good" />';
        else
            echo '<img src='. str_replace('ttms/', 'web/ttms/', site_url('img/bad.png')). ' title="Bad" />';
    }

}

// END Command class

/* End of file Command.php */
/* Location: ./system/application/libraries/Command.php */
