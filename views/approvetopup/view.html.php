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

class CommunityViewApproveTopup extends CommunityView
{
	public function display($tpl = null)
	{
	    $document     = JFactory::getDocument(); 
        $document->setTitle("Top Up Credit Approval"); 
		$this->listTopupRequest();
	}

	public function listTopupRequest()
	{
		$mainframe		= JFactory::getApplication();
		$config			= CFactory::getConfig();
		$document		= JFactory::getDocument();
		$my		= CFactory::getUser();
		$tmpl	= new CTemplate();

		$mainUrl = CRoute::_('index.php?option=com_community', false);
		$topupactivityModel = CFactory::getModel('topupactivity');
		$adminUser = COwnerHelper::isCommunityAdmin($my->id);

		if ($adminUser)
		{
			$result= $topupactivityModel->getTopupRequestList(1);
		}
		else
		{
			JError::raiseError( 403, JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN') );
			return;
		}
		
		if ($result != NULL)
		{
			$finalList = array();

			foreach ($result as $element)
			{
				$object = new stdClass();
				$object->id = $element->id;

				$object->valuePoint = $element->valuePoint;
				$object->lastUpdate = date('Y-m-d h:i:s a', strtotime($element->lastUpdate));

				$sourceUser = CFactory::getUser($element->userId);
					
				$object->avatar = $sourceUser ->getAvatar();
				$object->valuePoint = $element->valuePoint;
				$object->actualValue = $element->actualValue;

				$object->requestorName = $sourceUser->getDisplayName();
					
				array_push($finalList, $object);
			}

			echo $tmpl->set('topupRequestResult', $finalList)
			->fetch( 'topuprequest.list');
		}
	}
}