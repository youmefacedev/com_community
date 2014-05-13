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

/*
 * The primary purpose of this class is to log user transaction - gift transaction to be more exact. 
 * 
 */
class CommunityModelUserPointActivity extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;

	/*
	 * logs each gift transaction between source and target users  
	 */
	
	public function logGiftHistory($sourceUserId, $targetUserId, $referenceId, $giftId, $giftValue, $eventDate, $activityStatus)
	{
			
			if (isset($sourceUserId))
			{
				$db	= $this->getDBO();
				$obj = new stdClass();
				$obj->sourceUserId = $sourceUserId;
				$obj->targetUserId = $targetUserId;
				$obj->referenceId = $referenceId;
				
				$obj->giftId = $giftId;
				$obj->giftValue = $giftValue;
				$obj->transactionType = 0;
				$obj->activityStatus = $activityStatus; // 1 : gift was given 2 : withdrawn // 3 : approved 
				$obj->lastUpdate = $eventDate;
				
				return $db->insertObject( '#__user_reward_activity' ,  $obj);
			}
			
			
			if($db->getErrorNum())
			{
				JError::raiseError( 500, $db->stderr());
			}			
	 }
	 
	 
	 public function getGiftActivity($referenceId)
	 {
	 	if (isset($referenceId))
	 	{
	 		$db	= $this->getDBO();
	 		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('giftId') . ", " . $db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_reward_activity');
	 		$sql = $sql . ' WHERE '.$db->quoteName('referenceId') . '=' . $db->Quote($referenceId);
	 		
	 		$db->setQuery($sql);
	 		$db->query();
	 		$result = $db->loadObjectList();
	 		return $result;
	 	}
	 	return NULL;
	 }
	 
	 
	 public function getGiftByTargetUser($userId , $activityStatus)
	 {
	 	if (isset($userId))
	 	{
	 		$db	= $this->getDBO();
	 		
	 		$sql = 'SELECT ' . $db->quoteName('id') .  ", " . $db->quoteName('giftId') . ", " . $db->quoteName('sourceUserId')  .
	 		 ", " . $db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_reward_activity');
	 		
	 		$sql = $sql . ' WHERE '. $db->quoteName('targetUserId') . '=' . $db->Quote($userId) . " AND " . $db->quoteName('activityStatus') . '=' . $db->Quote($activityStatus)  . " ORDER BY " . $db->quoteName('lastUpdate') . " DESC" ;
	 
	 		$db->setQuery($sql);
	 		$db->query();
	 		$result = $db->loadObjectList();
	 		return $result;
	 	}
	 	return NULL;
	 }
	 
	 public function getGiftActivityBySourceUser($userId , $referenceId, $activityStatus)
	 {
	 	if (isset($userId))
	 	{
	 		$db	= $this->getDBO();
	 
	 		$sql = 'SELECT ' . $db->quoteName('id') .  ", " . $db->quoteName('giftId') . ", " . $db->quoteName('giftValue')  . ", " . $db->quoteName('sourceUserId')  .
	 		", " . $db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_reward_activity');
	 
	 		$sql = $sql . ' WHERE '. $db->quoteName('sourceUserId') . '=' . $db->Quote($userId) . " AND " . $db->quoteName('activityStatus') . '=' . $db->Quote($activityStatus)
	 		. " AND " . $db->quoteName('referenceId') . '=' . $db->Quote($referenceId);
	 
	 		$db->setQuery($sql);
	 		$db->query();
	 		$result = $db->loadObjectList();
	 		return $result;
	 	}
	 	return NULL;
	 }
	 
	 
	 public function getGiftValueActivity($referenceId)
	 {		
	 	
	 	if (isset($referenceId))
	 	{	 		
	 		$giftIdResult = $this->getGiftActivity($referenceId);
	 		
	 		$giftId = -1;
	 		
	 		foreach ($giftIdResult as $giftElement)
	 		{
	 			$giftId = $giftElement->giftId;
	 		}
	 		
	 		if ($giftId != -1) 
	 		{
		 		$db	= $this->getDBO();
		 		$sql = 'SELECT '.$db	->quoteName('valuePoint') .  ' FROM '.$db->quoteName('#__gift');
		 		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($giftId);
		 	 	$db->setQuery($sql);
		 		$db->query();
		 		$result = $db->loadObjectList();
		 		
		 		$valuePoint = 0;
		 		
		 		foreach ($result as $giftRecord)
		 		{
		 			$valuePoint = $giftRecord->valuePoint;
		 		}
		 		return $valuePoint;
	 		}
	 	}
	 	return NULL;
	 }
	 
	 
	 
	 public function getUserDisplayName($userId)
	 {	
	 	$db	= $this->getDBO();
	 	$sql = 'SELECT '.$db	->quoteName('username') .  ' FROM '.$db->quoteName('#__users');
	 	$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($userId);
	 	
	 	$db->setQuery($sql);
	 	$db->query();
	 	$result = $db->loadObjectList();
	 	
	 	$username = "";
	 	
	 	foreach ($result as $userRecord)
	 	{
	 		$username = $userRecord->username;
	 	}
	 	return $username;
	 	
	 }
	 
	 
	 public function getGiftValuePoint($giftId)
	 {
	 	$db	= $this->getDBO();
	 	$sql = 'SELECT '.$db	->quoteName('valuePoint') .  ' FROM '.$db->quoteName('#__gift');
	 	$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($giftId);
	 	$db->setQuery($sql);
	 	$db->query();
	 	$result = $db->loadObjectList();
	 	 
	 	$valuePoint = 0;
	 	 
	 	foreach ($result as $giftRecord)
	 	{
	 		$valuePoint = $giftRecord->valuePoint;
	 	}
	 	return $valuePoint;
	 }
	 
	 
	 
	/*
	private function updateGift($data, $userId, $filePart)
	{	
		$code = $data["giftcode"];
		$description = $data["giftdescription"];
		$valuepoint = $data["giftvaluepoint"];
		
		if (isset($code))
		{
			$db	= $this->getDBO();
			$query	= 'UPDATE ' . $db->quoteName( '#__user_point' ) . ' '
						. 'SET ' . $db->quoteName('description') . '=' . $db->Quote( $description ) . ' ' 
						. ', ' . $db->quoteName('valuePoint') . '=' . $db->Quote( $valuepoint ) . ' '
						. ', ' . $db->quoteName('updatedByUser') . '=' . $db->Quote( $userId ) . ' '
						. ', ' . $db->quoteName('imageURL') . '=' . $db->Quote($filePart) . ' '
						. 'WHERE ' . $db->quoteName( 'code' ) . '=' . $db->Quote( $code );

			$db->setQuery( $query );
			$db->query( $query );

			if($db->getErrorNum())
			{
				JError::raiseError( 500, $db->stderr());
			}
		}
	}
	*/	
}