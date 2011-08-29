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

class RapleafModelUsers extends JModel {

	public $_total = null;
	public $_pagination = null;

	function __construct()
	{
		parent::__construct();

		$mainframe = JFactory::getApplication();

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');

		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	public function getUsers()
	{
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
			
		}
		return $this->_data;
	}
	
	public function getUsersForCsv() {
		$db = JFactory::getDbo();
		$query = 'SELECT ju.name, ju.username, ju.email, ru.user_id, ru.age, ru.gender, ru.location  FROM ' . $db->nameQuote('#__rapleaf_users') . ' AS ru'
				. ' LEFT JOIN ' . $db->nameQuote('#__users') . ' AS ju'
				. ' ON ru.user_id = ju.id'
				. $this->_buildQueryWhere();
		$db->setQuery($query);
		return $db->loadAssocList();
		
	}

	public function getOnlyJoomlaUsers($offset, $limit)
	{
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM ' . $db->nameQuote('#__users');
		$db->setQuery($query, $offset, $limit);

		return $db->loadObjectList();
	}

	private function _buildQuery()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT ru.*, ju.* FROM ' . $db->nameQuote('#__rapleaf_users') . ' AS ru'
				. ' LEFT JOIN ' . $db->nameQuote('#__users') . ' AS ju'
				. ' ON ru.user_id = ju.id'
				. $this->_buildQueryWhere();

		return $query;
	}

	public function getTotal()
	{
		// Load the content if it doesn't already exist
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	public function getPagination()
	{
		// Load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_pagination;
	}

	protected function _buildQueryColumns(KDatabaseQuery $query)
	{
		$query->select(array(
			'tbl.*',
			'u.name',
			'u.username',
			'u.email',
		));
	}

	protected function _buildQueryWhere()
	{
		// get the application
		$app = & JFactory::getApplication();
		$db = JFactory::getDbo();
		// get the free text search filter
		$searchWord = $app->getUserStateFromRequest('com_rapleaf.user.search', 'search', '', 'string');
		$searchWord = JString::strtolower($searchWord);

		$where = array();
	
		if ($searchWord) {
			if (strstr($searchWord, ':')) {
				$words = explode(':', $searchWord);
				
				$search = $db->quote('%' . $db->getEscaped($words[1]) . '%');
				$tableColumns = $db->getTableColumns('#__rapleaf_users');
				if (!in_array($words[0], array('name', 'username', 'email'))) {
					if (isset($tableColumns[$words[0]])) {
						if ($words[0] == 'gender') {
							if ($words[1] == 'male') {
								$search = 1;
							} else {
								$search = 2;
							}
						}
						
						$where[] = $words[0] . ' LIKE ' . $search;
					}
				} else {
					$where[] = 'ju.' . $words[0] . ' LIKE ' . $search;
				}
			} else {
				$search = $db->quote('%' . $db->getEscaped($searchWord) . '%');
				$normalSearch[] = 'ju.name' . ' LIKE ' . $search;
				$normalSearch[] = 'ju.username' . ' LIKE ' . $search;
				$normalSearch[] = 'ju.email' . ' LIKE ' . $search;
				$normalSearch[] = 'age' . ' LIKE ' . $search;
				$normalSearch[] = 'location' . ' LIKE ' . $search;

				$where[] = implode(' OR ', $normalSearch);
			}
		}

		$where = count($where) ? ' WHERE '.implode(' AND ', $where) : '';
		return $where;
	}

	public function userAge()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(age) AS count, age FROM ' . $db->nameQuote('#__rapleaf_users')
				. ' WHERE age != ""'
				. ' GROUP BY age';
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public function userGender()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(gender) AS count, gender, age FROM ' . $db->nameQuote('#__rapleaf_users')
				. ' WHERE age != "" AND gender != 0 '
				. ' GROUP BY age, gender';
		$db->setQuery($query);

		$this->_gender = $db->loadAssocList();
		$newArray = array();
		$gender = array();
		
		foreach ($this->_gender as $key => $value) {
			if ($value['gender'] == 1) {
				$gender[$value['age']]['male'] = $value['count'];
			} elseif($value['gender'] == 2) {
				$gender[$value['age']]['female'] = $value['count'];
			}
		}
		
		foreach ($gender as $key => $value) {
			$newArray[] = array(
				'age' => $key,
				'male' => isset($value['male']) ? $value['male'] : 0,
				'female' => isset($value['female']) ? $value['female'] : 0
			);
		}
		return $newArray;
	}

	public function userLocation()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(location) AS count, location FROM ' . $db->nameQuote('#__rapleaf_users')
				. ' WHERE location != ""'
				. ' GROUP BY location';
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public function deleteUsers()
	{
		$db = JFactory::getDbo();
		$query = 'DELETE FROM ' . $db->nameQuote('#__rapleaf_users');
		$db->setQuery($query);
		return $db->query();
	}

	public function countJoomlaUsers()
	{
		$db = JFactory::getDbo();
		$query = 'SELECT count(*) AS count FROM ' . $db->nameQuote('#__users');
		$db->setQuery($query);

		return $db->loadObject()->count;
	}
	
	public function countRapleafUsers() {
		$db = JFactory::getDbo();
		$query = 'SELECT count(rapleaf_user_id) as count FROM ' . $db->nameQuote('#__rapleaf_users')
				.' WHERE gender != 0 OR location != "" OR age != ""';
		
		$db->setQuery($query);

		return $db->loadObject()->count;
	}
	
	public function totalMaleUsers() {
		$db = JFactory::getDbo();
		$query = 'SELECT count(rapleaf_user_id) as count FROM ' . $db->nameQuote('#__rapleaf_users')
				.' WHERE gender = 1';
		
		$db->setQuery($query);

		return $db->loadObject()->count;
	}
	
	public function totalFemaleUsers() {
		$db = JFactory::getDbo();
		$query = 'SELECT count(rapleaf_user_id) as count FROM ' . $db->nameQuote('#__rapleaf_users')
				.' WHERE gender = 2';
		
		$db->setQuery($query);

		return $db->loadObject()->count;
	}

	public function saveRapleafData($users)
	{
		$db = JFactory::getDbo();

		foreach ($users as $key => $user) {
//			save just the country
			if (isset($user['location'])) {
				$location = explode(',', ($user['location']));
				$location = array_pop($location);
				$location = $db->quote($location);
			} else {
				$location = $db->quote('');
			}

//			prepare gender for storing in the database
			if (isset($user['gender'])) {
				if ($user['gender'] == 'Male') {
					$gender = 1;
				} else {
					$gender = 2;
				}
			} else {
				$gender = 0;
			}

			$value = array(
				$db->quote(''),
				isset($user['user_id']) ? $db->quote($user['user_id']) : $db->quote(''),
				isset($user['age']) ? $db->quote($user['age']) : $db->quote(''),
				$gender,
				$location,
				isset($user['household_income']) ? $db->quote($user['household_income']) : $db->quote(''),
				isset($user['children']) ? $db->quote($user['children']) : $db->quote(''),
				isset($user['marital_status']) ? $db->quote($user['marital_status']) : $db->quote(''),
				isset($user['home_market_value']) ? $db->quote($user['home_market_value']) : $db->quote(''),
				isset($user['home_owner_status']) ? $db->quote($user['home_owner_status']) : $db->quote(''),
				isset($user['home_property_type']) ? $db->quote($user['home_property_type']) : $db->quote(''),
				isset($user['length_of_residence']) ? $db->quote($user['length_of_residence']) : $db->quote(''),
				isset($user['education']) ? $db->quote($user['education']) : $db->quote(''),
				isset($user['occupation']) ? $db->quote($user['occupation']) : $db->quote(''),
				$db->quote(json_encode($user))
			);
			$inserts[] = '(' . implode(',', $value) . ')';
		}

		$query = 'INSERT INTO ' . $db->nameQuote('#__rapleaf_users') . 'VALUES '
				. implode(',', $inserts);

		$db->setQuery($query);
		return $db->query();
	}

}