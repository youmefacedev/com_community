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

class CommunityViewMySupport extends CommunityView
{
	public function display($tpl = null)
	{
		$this->listSupport();
	}
	
    public function listSupport()
	{
		$mainframe		= JFactory::getApplication();
		$config			= CFactory::getConfig();
		$document		= JFactory::getDocument();
		
		$tmpl	= new CTemplate();
		
		$withdrawUrl = CRoute::_('index.php?option=com_community&view=mywithdraw', false);
		
		
		$giftModel = CFactory::getModel('support');
		$giftResult = $giftModel->getList();
		
		$supportList = $this->showMySupportGifts();
		
		echo $tmpl->set('supportList', $supportList)
				  ->set('withdrawUrl', $withdrawUrl)
			  	  ->fetch( 'mysupport.list');
	}
	
	
	private function showMySupportGifts()
	{
		$my 		= CFactory::getUser();
		$userPointModel = CFactory::getModel('userpointactivity');
		
		$supportList = array();
		
		$giftList =$userPointModel->getGiftByTargetUser($my->id, 1);
		 
		$idx = 0; 
		
		foreach ($giftList as $giftElement)
		{	
			$giftValue = $userPointModel->getGiftValuePoint($giftElement->giftId);
			
			$supportList[$idx]["giftValue"] = $giftValue;

			$user = CFactory::getUser($giftElement->sourceUserId);
			
			$supportList[$idx]["supportName"] = $user->username;
			
			$supportList[$idx]["avatar"] = $user->getAvatar();
			
			$idx++;
		}
		return $supportList;
	}
	
	
	public function removeComplete()
	{
		$targetUrl = CRoute::_('index.php?option=com_community&view=configuregift', false);	
		echo  '<a href="'. $targetUrl . '">Gift deleted. Click here to continue.</a>';
	}
	
	public function saveComplete()
	{
		$targetUrl = CRoute::_('index.php?option=com_community&view=configuregift', false);	
		echo  '<a href="' . $targetUrl . '">Gift saved. Click here to continue.</a>';
	}
	
}
