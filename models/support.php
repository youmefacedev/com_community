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

class CommunityModelSupport extends JCCModel
{
	var $_data = null;
	var $_profile;
	var $_pagination;
	var $_total;
	
	public function getList()
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('code') . ", " .$db->quoteName('description') . ", " .$db->quoteName('valuePoint') . ", " .$db->quoteName('imageURL') . ' FROM '.$db->quoteName('#__gift');
		$sql = $sql . ' WHERE '.$db->quoteName('CODE') . '!= ""';
		
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadObjectList();
		return $result;
	}
	
	public function getGiftObject($id)
	{		
		$db	= $this->getDBO();
		$sql = 'SELECT '.$db->quoteName('id') .  ", " . $db->quoteName('code') . ", " .$db->quoteName('description') . ", " .$db->quoteName('valuePoint') . ", " .$db->quoteName('imageURL') . ' FROM '.$db->quoteName('#__gift');
		$sql = $sql . ' WHERE '.$db->quoteName('id') . '=' . $db->Quote($id);
		
		$db->setQuery($sql);
		$db->query();
		
		$result = $db->loadObjectList();
		return $result;

	}
	
	public function getGift($id)
	{		
		$db	= $this->getDBO();
		
		$sql = 'SELECT '.$db->quoteName('code').' FROM '.$db->quoteName('#__gift')
				.' WHERE '.$db->quoteName('CODE') . '=' . $db->Quote($id);

		$db->setQuery($sql);
		
		$result = $db->loadResult();

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}
		return $result;
	}
	
	public function deleteGift($id)
	{
		$db    = $this->getDBO();
		$query = 'DELETE FROM '.$db->quoteName('#__gift');
		$query .= ' WHERE '.$db->quoteName('id').' = '.$db->Quote($id);
		
		$db->setQuery($query);
		$db->query();
		
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
			return -1;
		}
		
		return 0;
	}
	
	public function saveGift($data, $userId, $filePart)
	{
		$db	= $this->getDBO();
		$id = $data["giftcode"];
		$result = $this->getGift($id);
		
		if (isset($result))
		{
			$this->updateGift($data, $userId, $filePart);
		}
		else 
		{
			$this->createGift($data, $userId, $filePart);
		}
		
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr());
		}		
	}
	
	private function createGift($data, $userId, $filePart)
	{
		$code = $data["giftcode"];
		
		if (isset($code))
		{
			$db	= $this->getDBO();	
		
			$description = $data["giftdescription"];
			$valuepoint = $data["giftvaluepoint"];
			
			$obj = new stdClass();
			$obj->code = $code; 
			$obj->description = $description;
			$obj->valuePoint = $valuepoint; 
			$obj->imageURL = $filePart;
			$obj->updatedByUser = $userId;
		
			return $db->insertObject( '#__gift' ,  $obj);
		}
	}
	
	private function updateGift($data, $userId, $filePart)
	{	
		$code = $data["giftcode"];
		$description = $data["giftdescription"];
		$valuepoint = $data["giftvaluepoint"];
		
		if (isset($code))
		{
			$db	= $this->getDBO();
			$query	= 'UPDATE ' . $db->quoteName( '#__gift' ) . ' '
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
}