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

require_once( JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS . 'defines.php');

// check if mtupgrade is activated on joomla 1.5 websites
require_once( JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'mootools.php');
MootoolsRapleafHelper::checkMootools();

require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate'.DS.'liveupdate.php';
if(JRequest::getCmd('view','') == 'liveupdate') {
	JToolBarHelper::preferences( 'com_rapleaf' );
    LiveUpdate::handleRequest();
    return;
}

//JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');

// thank you for this black magic Nickolas :)
// Magic: merge the default translation with the current translation
$jlang =& JFactory::getLanguage();
$jlang->load('com_rapleaf', JPATH_SITE, 'en-GB', true);
$jlang->load('com_rapleaf', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('com_rapleaf', JPATH_SITE, null, true);
$jlang->load('com_rapleaf', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_rapleaf', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_rapleaf', JPATH_ADMINISTRATOR, null, true);

// Require specific controller if requested
$controller = JRequest::getCmd('view');

$path = JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php';
if (file_exists($path)) {
	require_once $path;
} else {
	require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . 'dashboard.php';
	$controller = 'Dashboard';
}

// Create the controller
$classname = 'RapleafController' . $controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
