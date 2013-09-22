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

class CommunityViewTopupCredit extends CommunityView
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
		
		$coreUrl = CRoute::_('index.php?option=com_community&view=topupcredit&task=topupForUser', false);
		
		$giftModel = CFactory::getModel('support');
		$giftResult = $giftModel->getList();
		
		echo $tmpl->set('giftList', $giftResult)
				  ->set('coreUrl', $coreUrl)
			      ->fetch( 'topupcredit');
	}
	
	public function addGift()
	{
		$tmpl	= new CTemplate();
		$saveGiftUrl = CRoute::_('index.php?option=com_community&view=configuregift&task=saveGift', false);	
		echo $tmpl->set('coreUrl', $saveGiftUrl)->fetch( 'configuregift.addgift');
	}
	
	public function editGift()
	{
		$mainframe = JFactory::getApplication();
		$giftModel = CFactory::getModel('configuregift');
		$mainframe = JFactory::getApplication();
		$giftRequest = JRequest::get('REQUEST');
		$id = $giftRequest["id"];
		
		if (isset($id))
		{
			$result  = $giftModel->getGiftObject($id);
						
			if (isset($result))
			{
				$tmpl	= new CTemplate();
				$saveGiftUrl = CRoute::_('index.php?option=com_community&view=configuregift&task=saveGift', false);	
				$giftRecord; 
				
				foreach ($result as $key)
				{
					$giftRecord = $key;
				}

				echo $tmpl->set('coreUrl', $saveGiftUrl)
						  ->set('giftRecord', $giftRecord)
						  //->set('description', $result["description"])
						  //->set('valuePoint', $result["valuePoint"])
						  //->set('imageURL', $result["imageURL"])
						  ->fetch('configuregift.addgift');
			}
			else 
			{
				$url = CRoute::_('index.php?option=com_community&view=configuregift');
				$mainframe->redirect($url, "unable to load requsted record");
			}
		}
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
