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

class RapleafHelperLanguage extends JObject {
	public function outputJsonLanguage() {
		$language = array();
		
	
		$language['wrong'] = JText::_('COM_RAPLEAF_JS_SOMETHIN_WENT_WRONG');
		$language['tableEmptyed'] = JText::_('COM_RAPLEAF_JS_TABLE_EMPTYED');
		$language['emptyTable'] = JText::_('COM_RAPLEAF_JS_EMPTY_TABLE');
		$language['reportGenerated'] = JText::_('COM_RAPLEAF_JS_REPORT_GENERATED');
		$language['generateReport'] = JText::_('COM_RAPLEAF_JS_GENERATE_REPORT');
		$language['getData'] = JText::_('COM_RAPLEAF_JS_CONTACT_RAPLEAF_TO_GET_DATA');
		$language['rapleafNotAvailable'] = JText::_('COM_RAPLEAF_JS_CONTACT_RAPLEAF_NOT_AVAILABLE');
		$language['contactSomethingWrong'] = JText::_('COM_RAPLEAF_JS_CONTACT_RAPLEAF_SOMETHING_WENT_WRONG');
		$language['rapleafResponseGood'] = JText::_('COM_RAPLEAF_JS_CONTACT_RAPLEAF_RESPONSE_GOOD');
		$language['calculateJoomlausers'] = JText::_('COM_RAPLEAF_JS_CALCULATE_JOOMLA_USERS');
		$language['youHave'] = JText::_('COM_RAPLEAF_JS_YOU_HAVE');
		$language['users'] = JText::_('COM_RAPLEAF_JS_USERS');

		
		return json_encode($language);
	}
}
