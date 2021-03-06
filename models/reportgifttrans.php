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

class CommunityModelReportGiftTrans extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getUserList($sourceUserId)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('sourceUserId') . ", " .$db->quoteName('targetUserId'); 
		$sql = $sql . ", " .$db->quoteName('giftId') . ", " .$db->quoteName('giftValue') . ", " .$db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_reward_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('sourceUserId') . '=' . $db->Quote($sourceUserId);
		$sql = $sql . ' ORDER BY '.$db->quoteName('lastUpdate') .' DESC';
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadObjectList();
		return $result;
	}
	
	
	public function getAdminList($sourceUserId)

	{

		$db	= $this->getDBO();

		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('sourceUserId') . ", " .$db->quoteName('targetUserId');

		$sql = $sql . ", " .$db->quoteName('giftId') . ", " .$db->quoteName('giftValue') . ", " .$db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_reward_activity');
       $sql = $sql . ' ORDER BY '.$db->quoteName('lastUpdate') .' DESC';
		

		$db->setQuery($sql);

		$db->query();

		$result = $db->loadObjectList();

		return $result;

	}
	
}