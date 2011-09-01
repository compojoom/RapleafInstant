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


defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RapleafControllerRapleaf extends JController {
	
	/**
	 * Gets the data from rapleaf and stores it in the database.
	 * If for some reason the rapleaf API return false, then
	 * the application returns failure
	 */
	public function getUserData() {
		$rapleafs = $this->getModel('rapleafs');
		
		$offset = JRequest::getInt('offset');
		$limit = JRequest::getInt('limit');
		$rapleafData = $rapleafs->getRapleafUserData($offset,$limit);
		

		if($rapleafData) {
			$users = $this->getModel('users');
			if($users->saveRapleafData($rapleafData)) {
				echo json_encode(array('status' => 'success'));
			} else {
				echo json_encode(array('status' => 'failure', 'type' => 'database'));
			}
		} else {
			echo json_encode(array('status' => 'failure', 'type' => 'rapleaf'));
		}
		
		jexit();
	}
}