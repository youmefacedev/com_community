<?php
/**
 * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
 * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author iJoomla.com <webmaster@ijoomla.com>
 * @url https://www.jomsocial.com/license-agreement
 * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
 * More info at https://www.jomsocial.com/license-agreement
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');
jimport( 'joomla.utilities.arrayhelper');
jimport( 'joomla.html.html');

class CommunityViewViewMember extends CommunityView
{
	public function display($tpl = null)
	{
		$document     = JFactory::getDocument();
		$document->setTitle("Member List");

		$mainframe = JFactory::getApplication();
		$my		= JFactory::getUser();

		if($my->id == 0)
		{
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
			return;
		}

		$this->viewMembers();
	}

	public function viewMembers()
	{
		$mainframe		= JFactory::getApplication();
		$config			= CFactory::getConfig();
		$document		= JFactory::getDocument();
		$my		= CFactory::getUser();
		$tmpl	= new CTemplate();

		$saveGiftUrl = CRoute::_('index.php?option=com_community&view=viewmember', false);
		$userListmodel = CFactory::getModel('viewmember');
		$adminUser = COwnerHelper::isCommunityAdmin($my->id);
		$userListResult = null;

		if ($adminUser)
		{
			$userListResult = $userListmodel->getAllUserList();
		}
		else
		{
			JError::raiseError( 403, JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN') );
			return;
		}

		$finalList = array();
		$totalValue = 0;

		if ($userListResult != null)
		{
			foreach ($userListResult as $element)
			{
				$object = new stdClass();
					
				$object->id = $element->id;
				$object->name = $element->name;
				$object->username = $element->username;
				$object->email = $element->email;
				$object->lastvisitDate = date('Y-m-d h:i:s a', strtotime($element->lastvisitDate));

				$object->userPoints = $this->getUserPoints($userListmodel->getMemberCurrentPoints($element->id));

				$sourceUser = CFactory::getUser($element->id);
				$object->avatar = $sourceUser ->getAvatar();
				$object->avatar = $sourceUser->getAvatar();
					
				array_push($finalList, $object);
			}
		}

		echo $tmpl->set('memberList', $finalList)->fetch( 'viewmember.list');

	}

	private function getUserPoints($data)
	{
		
		if ($data == null)
			return 0;
		
		foreach ($data as $element)
		{
			return $element->balance_point;
		}
		return 0;
	}

}