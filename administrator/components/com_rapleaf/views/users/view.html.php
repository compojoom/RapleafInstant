<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  Copyright 2011 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of com_rapleaf. com_rapleaf is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class RapleafViewUsers extends JView
{
	protected $pagination;
	protected $state;
	
	public function display()
	{
		$appl = JFactory::getApplication();
		$model = $this->getModel('users');
		
		$lists = array();
		$search = $appl->getUserStateFromRequest('com_rapleaf.user.search', 'search', '', 'string');
		$search = JString::strtolower($search);
		
		$lists['search'] = $search;
				
		$pagination	= $model->getPagination();
		$state		= $model->getState();
		
		$users = $model->getUsers();
		
		$this->assignRef('lists', $lists);
		$this->assignRef('users', $users);
		$this->assignRef('state', $state);
		$this->assignRef('pagination', $pagination);
		return parent::display();
	}
}