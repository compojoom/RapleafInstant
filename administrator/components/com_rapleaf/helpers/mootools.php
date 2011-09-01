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

/**
 * This is a helper class to check if mootools 1.2 is enabled
 * on joomla 1.5
 *
 * @author Daniel Dimitrov
 */
class MootoolsRapleafHelper {

	public function isMootools12Activated()
	{
		return JPluginHelper::isEnabled('system', 'mtupgrade');
	}

	public function checkMootools()
	{
		if (RAPLEAF_JVERSION == 15) {
			if (!self::isMootools12Activated()) {
				$appl = JFactory::getApplication();
				$url = JRoute::_('index.php?option=com_plugins&search=system - mootools upgrade');
				$warning = JText::sprintf('COM_RAPLEAF_MOOTOOLS12_IS_NOT_ACTIVATED', $url);

				$appl->enqueueMessage($warning, 'error');
				return false;
			}
		}
		return true;
	}

}

?>
