<?php

/**
 * Simple utility class to handle logins.
 */
class Login_Manager {
	
    var $pyscript_path = "/home/web/ttms/pyscript";

	function __construct($params = array())
	{
		
		$this->CI =& get_instance(); 
		$this->session =& $this->CI->session;
        $ip = $this->session->userdata('ip_address');
		$user = $this->get_user($ip);
		if(! $user)
		{
            show_error('Sorry, you do not have access to this page before you join domain rnd.gdnt.local');
		}
        $this->session->set_userdata('user_name', $user);
        if(isset($params['admin']))
        {
            if($params['admin'] == TRUE)
            $this->check_admin($user);
        } 
	}

    function check_admin($user)
    {
        $u = new User();
        $u->get_by_name($user);
        if( ! $u->exists())
        {
            show_error('Sorry, you are not the administrator.');
        }

    }
	
	function get_user($ip)
	{
        return (exec("python $this->pyscript_path/host.py $ip"));
	}
	
}
