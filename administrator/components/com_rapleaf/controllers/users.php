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


defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RapleafControllerUsers extends JController {

	public function deleteAll() {

		$model = $this->getModel('users');
		
		if($model->deleteUsers()) {
			echo json_encode('success');
		} else {
			echo json_encode('failure');
		}
		jexit();
	}
	
	public function count() {
		$model = $this->getModel('users');
		$count = $model->countJoomlaUsers();

		if($count) {
			echo json_encode(array('status'=>'success', 'number' => $count));
		} else {
			echo json_encode(array('status'=>'failure'));
		}
		jexit();
	}
	
	public function csvExport() {
		$model = $this->getModel('users');
		
		$users = $model->getUsersForCsv();

		$output = fopen('php://output','w') or die("Can't open php://output");
		$total = 0;
		
		header('Content-Type:application/csv');
		header('Content-Disposition: attachment; filename="users.csv"');
		
		fputcsv($output, array('name','username','email','user_id','age','gender','location'));
		
		foreach ($users as $user) {
			fputcsv($output, $user);
		}
		
		fclose($output) or die("can't close php://output");
		
		jexit();
	}
}