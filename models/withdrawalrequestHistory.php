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

class CommunityModelWithdrawalRequestHistory extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getRequest($requestId)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('withdrawal_date') . ", " 
				. $db->quoteName('withdrawal_amount') . ", "
				. $db->quoteName('status') . ", "
				. $db->quoteName('payment_method') . ", "
				. $db->quoteName('approvedByUser') . ", "
				. $db->quoteName('bankName') . ", "
				. $db->quoteName('name') . ", "
				. $db->quoteName('bankCountry') . ", "
				. $db->quoteName('acctnum') . ", "
				. $db->quoteName('mepsRouting') . ", "
				. $db->quoteName('lastUpdate') . " "
				. ' FROM '.$db->quoteName('#__user_withdrawal_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($requestId);
		$sql = $sql .' ORDER BY '.$db->quoteName('lastUpdate') . ' DESC '; //Miki 26Apr2014.
		
		$db->setQuery($sql);
		$db->query();
		
		$result = $db->loadObjectList();
		return $result;
	}
	
	
	public function create($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRouting, $acctnum, $bankCountry, $status)
	{
		if (isset($userId))
		{
			$db	= $this->getDBO();
			$obj = new stdClass();
				
			$obj->userId = $userId;
			$obj->withdrawal_date = $withdrawal_date;
			$obj->withdrawal_amount = $withdrawal_amount;
			$obj->status = 1;
			$obj->payment_method = $payment_method;
			$obj->approvedByUser = 0;
			$obj->lastUpdate = $lastUpdate;
			
			$obj->name = $name;
			$obj->bankName = $bankName;
			$obj->mepsRouting = $mepsRouting;
			$obj->acctnum = $acctnum;
			$obj->bankCountry = $bankCountry;
			$obj->status = $status;
			$result = $db->insertObject( '#__user_withdrawal_activity_history' ,  $obj);
				
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
			
}