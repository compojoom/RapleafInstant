<?php

defined('KOOWA') or die('');

class ComRapleafModelUsers extends KModelTable {

	protected function _buildQueryColumns(KDatabaseQuery $query)
	{
			$query->select(array(
				'tbl.*',
				'u.name',
				'u.username',
				'u.email',
			));
	}
	
	protected function _buildQueryJoins(KDatabaseQuery $query) {
		$query
			->join('LEFT', 'users AS u', 'u.id = tbl.user_id');
	}

	protected function _buildQueryWhere(KDatabaseQuery $query) {

	}

}