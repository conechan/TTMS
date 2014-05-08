<?php

/**
 * Server DataMapper Model
 *
 * Use this basic model as a server for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Server library (as the classes may collide).
 * 
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Server' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'server' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'Servers' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Server extends DataMapper {
	
	// Uncomment and edit these two if the class has a model name that
	//   doesn't convert properly using the inflector_helper.
	var $model = 'server';
	var $table = 'servers';
	
	// You can override the database connections with this option
	// var $db_params = 'db_config_name';
	
	// --------------------------------------------------------------------
	// Relationships
	//   Configure your relationships below
	// --------------------------------------------------------------------
	
	// Insert related models that Server can have just one of.
	var $has_one = array("type");
	
	// Insert related models that Server can have more than one of.
	var $has_many = array("system", "action");
	
	/* Relationship Examples
	 * For normal relationships, simply add the model name to the array:
	 *   $has_one = array('user'); // Server has one User 
	 * 
	 * For complex relationships, such as having a Creator and Editor for
	 * Server, use this form:
	 *   $has_one = array(
	 *   	'creator' => array(
	 *   		'class' => 'user',
	 *   		'other_field' => 'created_server'
	 *   	)
	 *   );
	 *   
	 * Don't forget to add 'created_server' to User, with class set to
	 * 'server', and the other_field set to 'creator'!
	 * 
	 */
	
	// --------------------------------------------------------------------
	// Validation
	//   Add validation requirements, such as 'required', for your fields.
	// --------------------------------------------------------------------
	
	var $validation = array(
		'name' => array(
			'rules' => array('required', 'unique'),
			'label' => 'Host name'
		    ),
		'ip' => array(
			'rules' => array('required', 'unique'),
			'label' => 'IP'
            ),
        'description' => array(
			'rules' => array('required'),
			'label' => 'Description',
            'type' => 'textarea'
            ),
        'login_name' => array(
			'label' => 'Login name'
            ),
        'login_pwd' => array(
			'label' => 'Login password'
            ),
        'root_pwd' => array(
			'label' => 'root password'
            ),
        'type' => array(
			'rules' => array('required'),
			'label' => 'Type'
            ),
        'system' => array(
			'rules' => array('required'),
			'label' => 'System',
            'type' => 'checkbox'
		    ),
        'action' => array(
			'label' => 'Action',
            'type' => 'checkbox'
		    )
	);
	
	// --------------------------------------------------------------------
	// Default Ordering
	//   Uncomment this to always sort by 'name', then by
	//   id descending (unless overridden)
	// --------------------------------------------------------------------
	
	var $default_order_by = array('name');
	
	// --------------------------------------------------------------------

	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
	
	// --------------------------------------------------------------------
	// Custom Methods
	//   Add your own custom methods here to enhance the model.
	// --------------------------------------------------------------------
	
	/* Example Custom Method
	function get_open_Servers()
	{
		return $this->where('status <>', 'closed')->get();
	}
	*/
	
	// --------------------------------------------------------------------
	// Custom Validation Rules
	//   Add custom validation rules for this model here.
	// --------------------------------------------------------------------
	
	/* Example Rule
	function _convert_written_numbers($field, $parameter)
	{
	 	$nums = array('one' => 1, 'two' => 2, 'three' => 3);
	 	if(in_array($this->{$field}, $nums))
		{
			$this->{$field} = $nums[$this->{$field}];
	 	}
	}
	*/
}

/* End of file server.php */
/* Location: ./application/models/server.php */
