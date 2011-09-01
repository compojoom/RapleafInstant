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

defined('_JEXEC') or die('');
require_once (JPATH_COMPONENT_ADMINISTRATOR.'/libraries/rapleafApiBulk.php');

jimport('joomla.application.component.model');

class RapleafModelRapleafs extends JModel {
	
	public function getRapleafUserData($offset = 0, $limit = 10000) {
		$model = JModel::getInstance('users', 'RapleafModel');
		$users = $model->getOnlyJoomlaUsers($offset, $limit);
		
		$api = new RapleafApiBulk;
		
		$rapleafData = array();
		
		foreach($users as $key => $user) {
			$name = explode(' ', $user->name);
			$rapleafData[] = array(
				'email' => $user->email
			);
			$rapleafData1[] = array(
				'user_id' => $user->id,
				'email' => $user->email
			);
		}
		try {
			$rapleafResponse = $api->getJsonResponse($rapleafData);
		} 
		catch (Exception $e) {
			$rapleafResponse = false;
		}
		
		if($rapleafResponse) {
			return $this->mergeData($rapleafData1,$rapleafResponse);
		}
		
		return false;
	}
	
	private function mergeData($array1, $array2) {
		foreach($array1 as $key => $value) {
			foreach($array2[$key] as $key2 => $value2) {
				$array1[$key][$key2] = $value2;
			}
		}
		
		return $array1;
	}
	
}