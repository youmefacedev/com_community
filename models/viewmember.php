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

class CommunityModelViewMember extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getAllUserList()
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('name') . ", " .$db->quoteName('username') . ", " .$db->quoteName('email') . ", " .$db->quoteName('lastvisitDate'); 
		$sql = $sql  . ' FROM '.$db->quoteName('#__users');
		$sql = $sql  . ' WHERE '.$db->quoteName('usertype') . "= 2"; // non admin users //
		$sql = $sql .' ORDER BY '.$db->quoteName('username') . '  '; 
		
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function getMemberCurrentPoints($userId)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('userId') .  ", " . $db->quoteName('balance_point');
		$sql = $sql  . ' FROM '.$db->quoteName('#__user_point');
		$sql = $sql .' WHERE '.$db->quoteName('userId') . ' = ' . $userId;
		
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadObjectList();
		return $result;
		
	}
		
}