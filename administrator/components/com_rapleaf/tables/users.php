<?php
/**
 * @version		$Id: banner.php 21320 2011-05-11 01:01:37Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Banner table
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.5
 */
class RapleafTableUsers extends JTable
{

	function __construct(&$_db)
	{
		parent::__construct('#__rapleaf_users', 'rapleaf_user_id', $_db);
	}

}

