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

$language = JFactory::getLanguage();
$language->load('com_rapleaf.menu', JPATH_ADMINISTRATOR, null, true);

$view	= JRequest::getCmd('view');

$subMenus = array (
	'dashboard' => 'COM_RAPLEAF_DASHBOARD',
	'users' => 'COM_RAPLEAF_USERS',
	'liveupdate' => 'COM_RAPLEAF_LIVE_UPDATE'
);

foreach($subMenus as $key => $name) {
	$active	= ( $view == $key );
	
	JSubMenuHelper::addEntry( JText::_($name) , 'index.php?option=com_rapleaf&view=' . $key , $active );
}
