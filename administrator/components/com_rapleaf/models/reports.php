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

jimport('joomla.application.component.model');

class RapleafModelReports extends JModel {

	public function getReports()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM ' . $db->nameQuote('#__rapleaf_reports')
				.' ORDER BY date ASC';
		$db->setQuery($query);

		return $db->loadObjectList('rapleaf_report_id');
	}
	
	public function getLastReport()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM ' . $db->nameQuote('#__rapleaf_reports')
				.' ORDER BY date DESC';
		$db->setQuery($query,0,1);

		return $db->loadObject();
	}

	public function generateReport()
	{
		$users = JModel::getInstance('Users','RapleafModel');
		$age = $users->userAge();
		$gender = $users->userGender();
		$location = $users->userLocation();
		
		$joomlaUsers = $users->countJoomlaUsers();
		$rapleafUsers = $users->countRapleafUsers();
		
		$totalMale = $users->totalMaleUsers();
		$totalFemale = $users->totalFemaleUsers();
		
		$report = array(
			'joomlaUsers' => $joomlaUsers,
			'rapleafUsers' => $rapleafUsers,
			'totalMale' => $totalMale,
			'totalFemale' => $totalFemale,
			'age' => $age,
			'gender' => $gender,
			'location' => $location
		);
		$date = JFactory::getDate();
		$rowData = array(
			'date' => $date->toMysql(),
			'report' => json_encode($report)
		);
		
		$table = JTable::getInstance('Reports', 'RapleafTable');

		$table->bind($rowData);
		
		return $table->store();
	}

}