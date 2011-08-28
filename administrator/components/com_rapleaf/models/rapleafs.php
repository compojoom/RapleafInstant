<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  Copyright 2011 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of the Hotspots project. The Hotspots project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
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
				'email' => $user->email,
				'first' => isset($name[0]) ? $name[0] : '',
				'last' => isset($name[1]) ? $name[1] : ''
			);
			$rapleafData1[] = array(
				'user_id' => $user->id,
				'email' => $user->email,
				'first' => isset($name[0]) ? $name[0] : '',
				'last' => isset($name[1]) ? $name[1] : ''
			);
		}
		try {
			$rapleafResponse = $api->getJsonResponse($rapleafData);
		} 
		catch (Exception $e) {
//			var_dump($e);
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
	
//	public function dro
}