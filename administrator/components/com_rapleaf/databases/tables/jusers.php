<?php
defined('KOOWA') or die('');

/**
 * Joomla #__users table adapter
 *   
 * @author   	Daniel Dimitrov <danielsd_bg@yahoo.fr>
 * @package		rapleaf
 */
class ComRapleafDatabaseTableJusers extends KDatabaseTableAbstract
{
	public function __construct(KConfig $config)
	{
		$config->name = 'users';
		$config->base = 'users';
		$config->identity_column = 'id';
  
		parent::__construct($config);
    }    
}