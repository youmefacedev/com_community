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

class CommunityModelUserPoint extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getPoint($id)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('balance_point') . ", " .$db->quoteName('withdrawal_point') . ", " .$db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_point');
		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($id);
		
		$db->setQuery($sql);
		$db->query();
		
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function getUserPoint($userId)
	{
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('userId') . ", " .$db->quoteName('balance_point') . ", " .$db->quoteName('withdrawal_point') . ", " .$db->quoteName('lastUpdate') . ' FROM '.$db->quoteName('#__user_point');
		$sql = $sql . ' WHERE '.$db->quoteName('userId') . '=' . $db->Quote($userId);
	
		$db->setQuery($sql);
		$db->query();
	
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function getUserPointValue($userId)
	{
		$result = $this->getUserPoint($userId);
		$balanceValue = 0;
		
		foreach ($result as $element)
		{
			$balanceValue = $element->balance_point;
		}
		
		return $balanceValue;
	}
	
	
	public function updateUserBalancePoint($userId, $point)
	{
			$db	= $this->getDBO();
			$query	= 'UPDATE ' . $db->quoteName( '#__user_point' ) . ' '
					. 'SET ' . $db->quoteName('balance_point') . '=' . $db->Quote($point) . ' '
					. 'WHERE ' . $db->quoteName( 'userId' ) . '=' . $db->Quote( $userId );
	
			$db->setQuery( $query );
			$db->query( $query );
	
			if($db->getErrorNum())
			{
				JError::raiseError( 500, $db->stderr());
			}
	 }
	
	 public function updateUserWithdrawalPoint($userId, $point)
	 {
	 	$db	= $this->getDBO();
	 	$query	= 'UPDATE ' . $db->quoteName( '#__user_point' ) . ' '
	 			. 'SET ' . $db->quoteName('withdrawal_point') . '=' . $db->Quote($point) . ' '
	 					. 'WHERE ' . $db->quoteName( 'userId' ) . '=' . $db->Quote( $userId );
	 
	 	$db->setQuery( $query );
	 	$db->query( $query );
	 
	 	if($db->getErrorNum())
	 	{
	 		JError::raiseError( 500, $db->stderr());
	 	}
	 }
	 
	
	public function createUserPoint($userId, $point)
	{
		if (isset($userId))
		{
			$db	= $this->getDBO();	
			$obj = new stdClass();
			$obj->userId = $userId;
			$obj->balance_point = $point;
			return $db->insertObject( '#__user_point' ,  $obj);
		}
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