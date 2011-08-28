<?php
/**
 * @package LiveUpdate
 * @copyright Copyright ©2011 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */

defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates. Override to your liking.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig
{
	var $_extensionName			= 'com_hotspots';
	var $_extensionTitle		= 'Hotspots';
	var $_updateURL				= 'http://compojoom.com/index.php?option=com_ars&view=update&format=ini&id=4';
	var $_requiresAuthorization	= true;
	var $_versionStrategy		= 'different';
}