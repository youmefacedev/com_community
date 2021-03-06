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

class CommunityModelWithdrawalRequest extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getRequest($requestId)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('withdrawal_date') . ", " 
				. $db->quoteName('withdrawal_amount') . ", " .$db->quoteName('lastUpdate') . ", "
				. $db->quoteName('status') . ", "
				. $db->quoteName('payment_method') . ", "
				. $db->quoteName('approvedByUser') . ", "
				. $db->quoteName('lastUpdate') . ", "
				. $db->quoteName('name') . ", "
				. $db->quoteName('bankName') . ", "
				. $db->quoteName('bankCountry') . ", "
				. $db->quoteName('acctnum') 
				. ' FROM '.$db->quoteName('#__user_withdrawal_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($requestId);
		
		$db->setQuery($sql);
		$db->query();
		
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function createRequest($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate)
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
	
			$result = $db->insertObject( '#__user_withdrawal_activity' ,  $obj);
			
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
	
	
	public function createRequestWithBankInfo($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRoutingCode, $acctnum, $bankCountry)
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
			$obj->mepsRouting = $mepsRoutingCode;
			$obj->acctnum = $acctnum;
			$obj->bankCountry = $bankCountry;
			
			$result = $db->insertObject( '#__user_withdrawal_activity' ,  $obj);
				
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}

	
	public function createRequestWithBankInfoHistory($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRoutingCode, $acctnum, $bankCountry)
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
			$obj->mepsRouting = $mepsRoutingCode;
			$obj->acctnum = $acctnum;
			$obj->bankCountry = $bankCountry;
				
			$result = $db->insertObject( '#__user_withdrawal_activity_history' ,  $obj);
	
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
	
	
	// Get all the withdrawal request with status = 1 - User just initiated request
	public function getWithdrawalRequest()
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('withdrawal_date') . ", "
				. $db->quoteName('withdrawal_amount') . ", " .$db->quoteName('lastUpdate')
				. $db->quoteName('status')
				. $db->quoteName('payment_method')
				. $db->quoteName('transactionType')
				. $db->quoteName('approvedByUser')
				. $db->quoteName('lastUpdate')
				. ' FROM '.$db->quoteName('#__user_withdrawal_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('status') . '=' . $db->Quote(1);
		$sql = $sql .' ORDER BY '.$db->quoteName('lastUpdate') . ' DESC ';
	
		$db->setQuery($sql);
		$db->query();
	
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function approveWithdrawalRequest($id, $approvedByUser, $lastUpdate)
	{
		$db	= $this->getDBO();
		$sql	= 'UPDATE ' . $db->quoteName( '#__user_withdrawal_activity' ) . ' '
		      	  . 'SET ' . $db->quoteName('approvedByUser') . '=' . $db->Quote($approvedByUser) . ' '
				  . ', ' . $db->quoteName('status') . '=' . $db->Quote(2) . ' '
				  . ', ' . $db->quoteName('lastUpdate') . '=' . $db->Quote($lastUpdate) . ' '
				  . 'WHERE ' . $db->quoteName( 'id' ) . '=' . $db->Quote($id);
		
		$db->setQuery($sql);
		$db->query();
	
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
	}
	
	public function denyWithdrawalRequest($id, $approvedByUser, $lastUpdate)
	{
		$db	= $this->getDBO();
		$sql	= 'UPDATE ' . $db->quoteName( '#__user_withdrawal_activity' ) . ' '
				. 'SET ' . $db->quoteName('approvedByUser') . '=' . $db->Quote($approvedByUser) . ' '
						. ', ' . $db->quoteName('status') . '=' . $db->Quote(-1) . ' '
								. ', ' . $db->quoteName('lastUpdate') . '=' . $db->Quote($lastUpdate) . ' '
										. 'WHERE ' . $db->quoteName( 'id' ) . '=' . $db->Quote($id);
	
		$db->setQuery($sql);
		$db->query();
	
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	
	}
	
	public function moneyInBank($id, $approvedByUser, $lastUpdate)
	{
		$db	= $this->getDBO();
		$sql	= 'UPDATE ' . $db->quoteName( '#__user_withdrawal_activity' ) . ' '
				. 'SET ' . $db->quoteName('approvedByUser') . '=' . $db->Quote($approvedByUser) . ' '
						. ', ' . $db->quoteName('status') . '=' . $db->Quote(3) . ' '
								. ', ' . $db->quoteName('lastUpdate') . '=' . $db->Quote($lastUpdate) . ' '
										. 'WHERE ' . $db->quoteName( 'id' ) . '=' . $db->Quote($id);
	
		$db->setQuery($sql);
		$db->query();
	
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}	
	}
	
	
	
	public function getWithdrawalRequestByStatus($status)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('withdrawal_date') . ", "
				. $db->quoteName('withdrawal_amount') . ", " .$db->quoteName('lastUpdate') . ", "
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
		 
		   $sql = $sql . ' WHERE '.$db->quoteName('status') . '=' .  $db->Quote($status);
		
		$sql = $sql .' ORDER BY '.$db->quoteName('lastUpdate') . ' DESC '; //Miki 26Apr2014.
			
		$db->setQuery($sql);
		$db->query();
	
		$result = $db->loadObjectList();
		return $result;
	}
		
}

?>