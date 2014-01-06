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

class CommunityViewReportWithdrawal extends CommunityView
{
	public function display($tpl = null)
	{
		
		$mainframe = JFactory::getApplication();
		$my		= JFactory::getUser();
		
		if($my->id == 0)
		{
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
			return;
		}
		
        $this->listGiftReport();
	}

	public function listGiftReport()
	{
		$mainframe		= JFactory::getApplication();
		$config			= CFactory::getConfig();
		$document		= JFactory::getDocument();
		$my		= CFactory::getUser();
		$tmpl	= new CTemplate();

		$saveGiftUrl = CRoute::_('index.php?option=com_community&view=configuregift&task=saveGift', false);

		$giftModel = CFactory::getModel('reportwithdrawal');

		$adminUser = COwnerHelper::isCommunityAdmin($my->id);

		if ($adminUser)
		{
			 $giftResult = $giftModel->getAdminList($my->id);
		}
		else
		{
			$giftResult = $giftModel->getUserList($my->id);
		}

		$finalList = array();


		foreach ($giftResult as $element)
		{
			$object = new stdClass();
			
			$object->id = $element->id;
			$object->bankName = $element->bankName;
			$object->acctnum = $element->acctnum;
			$object->withdrawal_amount = $element->withdrawal_amount;
			$object->bankcountry = $element->bankcountry;
			
			$object->lastUpdate = date('Y-m-d h:i:s a', strtotime($element->lastUpdate));
				
			$sourceUser = CFactory::getUser($element->userId);
			
			$object->avatar = $sourceUser ->getAvatar();
				
			$object->lastUpdate = date('Y-m-d h:i:s a', strtotime($element->lastUpdate));
			$object->avatar = $sourceUser->getAvatar();
				
			array_push($finalList, $object);
		} 


		echo $tmpl->set('giftList', $finalList)
		->fetch( 'reportwithdrawal.list');

	}
}