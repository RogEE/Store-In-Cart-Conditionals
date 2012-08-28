<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Store: In_Cart Conditionals Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Michael Rog
 * @link		http://rog.ee
 */

class Store_in_cart_conditionals_ext {
	
	public $settings 		= array();
	public $description		= 'Adds entry_id_in_cart and sku_in_cart conditionals within Store template tags';
	public $docs_url		= 'http://rog.ee';
	public $name			= 'Store: In_Cart Conditionals';
	public $settings_exist	= 'n';
	public $version			= '0.0.0';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'add_in_cart_conditionals',
			'hook'		=> 'store_cart_update_end',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------
	
	/**
	 * Process conditionals
	 *
	 * @param 
	 * @return 
	 */
	public function add_in_cart_conditionals($cart_contents)
	{
		
		$items_in_cart = array();
		$skus_in_cart = array();
		
		foreach (($cart_contents['items']) as $item)
		{
			$items_in_cart[] = $item['entry_id'];
			$skus_in_cart[] = $item['sku'];
		}

		foreach (array_count_values($items_in_cart) as $i => $q)
		{
			$cart_contents['store:entry_id_in_cart:'.$i] = TRUE;
		}

		foreach (array_count_values($skus_in_cart) as $s => $q)
		{
			$cart_contents['store:sku_in_cart:'.$s] = TRUE;
		}
		
		return $cart_contents;
		
	}

	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.store_in_cart_conditionals.php */
/* Location: /system/expressionengine/third_party/store_in_cart_conditionals/ext.store_in_cart_conditionals.php */