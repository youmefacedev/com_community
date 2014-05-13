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

class CommunityModelTopupActivity extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;

	/*
	 * 1 - new
	* 2 - approved + transfered
	* 3 - dismissed
	*/

	public function getTopupRequestList($requestStatus)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') .  ", " . $db->quoteName('description')  . ", " . $db->quoteName('valuePoint')
		. ", " . $db->quoteName('actualValue') . ", " . $db->quoteName('lastUpdate') . ", " . $db->quoteName('status')  . ", "
				. $db->quoteName('paymentTransactionId')
				. ' FROM ' . $db->quoteName('#__user_topup_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('status') . '=' . $db->Quote($requestStatus);

		$db->setQuery($sql);
		$db->query();

		$result = $db->loadObjectList();
		return $result;
	}

	public function getId($id)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') .  ", " . $db->quoteName('description')  . ", " . $db->quoteName('valuePoint')
		. ", " . $db->quoteName('actualValue') . ", " . $db->quoteName('lastUpdate') . ", " . $db->quoteName('status')  . ", "
				. $db->quoteName('paymentTransactionId')
				. ' FROM ' . $db->quoteName('#__user_topup_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($id);

		$db->setQuery($sql);
		$db->query();

		$result = $db->loadObjectList();
		return $result;
	}

	public function createRequest($userId, $description, $valuePoint, $actualValue, $paymentTransactionId, $lastUpdate)
	{
		if (isset($userId))
		{
			$db	= $this->getDBO();
			$obj = new stdClass();

			$obj->userId = $userId;
			$obj->description = $description;
			$obj->valuePoint = $valuePoint;
			$obj->actualValue = $actualValue;
			$obj->status = 1;
			$obj->paymentTransactionId = $paymentTransactionId;
			$obj->lastUpdate = $lastUpdate;

			$result = $db->insertObject( '#__user_topup_activity' ,  $obj);
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
		return $result; 
	}

	public function createRequestHistory($userId, $description, $valuePoint, $actualValue, $paymentTransactionId, $lastUpdate, $status)
	{
		if (isset($userId))
		{
			$db	= $this->getDBO();
			$obj = new stdClass();

			$obj->userId = $userId;
			$obj->description = $description;
			$obj->valuePoint = $valuePoint;
			$obj->actualValue = $actualValue;
			$obj->status = $status;
			$obj->paymentTransactionId = $paymentTransactionId;
			$obj->lastUpdate = $lastUpdate;

			$result = $db->insertObject( '#__user_topup_activity_history' ,  $obj);
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}

	public function updateUserTopupStatus($id, $status, $lastUpdate)
	{
		$db	= $this->getDBO();
		$query	= 'UPDATE ' . $db->quoteName( '#__user_topup_activity' ) . ' '
				. 'SET ' . $db->quoteName('status') . '=' . $db->Quote($status) . ', ' . $db->quoteName('lastUpdate') . '=' . $db->Quote($lastUpdate) . ' '
						. 'WHERE ' . $db->quoteName( 'id' ) . '=' . $db->Quote($id);

		$db->setQuery( $query );
		$db->query( $query );

		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
	
	public function updateTempRequest($id, $points)
	{
		$db	= $this->getDBO();
		$query	= 'UPDATE ' . $db->quoteName( '#__user_temp_topup_activity' ) . ' '
				. 'SET ' . $db->quoteName('valuePoint') . '=' . $db->Quote($points) . ' '
						. 'WHERE ' . $db->quoteName( 'paymentTransactionId' ) . '=' . $db->Quote($id);
	
		$db->setQuery($query);
		$db->query( $query );
	
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	}
	
	
	public function createTempTopupRequest($userId, $description, $valuePoint, $actualValue, $paymentTransactionId, $lastUpdate)
	{
		if (isset($userId))
		{
			$db	= $this->getDBO();
			$obj = new stdClass();
	
			$obj->userId = $userId;
			$obj->description = $description;
			$obj->valuePoint = $valuePoint;
			$obj->actualValue = $actualValue;
			$obj->status = 1;
			$obj->paymentTransactionId = $paymentTransactionId;
			$obj->lastUpdate = $lastUpdate;
	
			$result = $db->insertObject( '#__user_temp_topup_activity' ,  $obj);
		}
			
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
	
		return $result;
	}
	
	public function getTempId($id)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') .  ", " . $db->quoteName('description')  . ", " . $db->quoteName('valuePoint')
		. ", " . $db->quoteName('actualValue') . ", " . $db->quoteName('lastUpdate') . ", " . $db->quoteName('status')  . ", "
				. $db->quoteName('paymentTransactionId')
				. ' FROM ' . $db->quoteName('#__user_temp_topup_activity');
		$sql = $sql . ' WHERE '.$db->quoteName('paymentTransactionId') . '=' . $db->Quote($id);
	

		$db->setQuery($sql);
		$db->query();
	
		$result = $db->loadObjectList();
		$requestData = null; 
		
		foreach ($result as $resultElement)
		{
			$requestData = $resultElement;
		}

		return $requestData;
	}
	
	
}