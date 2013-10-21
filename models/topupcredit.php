<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.utilities.date');
jimport('joomla.html.pagination');

require_once( JPATH_ROOT .'/components/com_community/models/models.php' );

class CommunityModelTopupCredit extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getPackage($packageName)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('packageCode') . ", " .$db->quoteName('description') . ", " .$db->quoteName('valuePoint') .  ' FROM '.$db->quoteName('#__user_package');
		$sql = $sql . ' WHERE '.$db->quoteName('packageCode') . '=' . $db->Quote($packageName);
		
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function getPackageValue($packageName)
	{

		if (isset($packageName))
		{
			$packageValue = 0;
			$packageQueryResult = $this->getPackage($packageName);
			
			foreach ($packageQueryResult as $pkg)
			{	
				$packageValue = $pkg->valuePoint;
			}
			
			return $packageValue;
		}
		return NULL;
	}
		
}