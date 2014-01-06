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
		$mainframe = JFactory::getApplication();
		$my		= JFactory::getUser();
		
		if($my->id == 0)
		{
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
			return;
		}
		
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


	public function topupForUser()
	{
		$tmpl	= new CTemplate();
		$my 		= CFactory::getUser();
		$selectedPackage = JRequest::getVar('packageName', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$topupStatus = false;

		$packageModel = CFactory::getModel("topupcredit");

		if (isset($selectedPackage))
		{
			$packageValue = $packageModel->getPackageValue($selectedPackage);
				
			if ($packageValue > 0)
			{
				$userPointModel = CFactory::getModel("userpoint");

				$existingBalancePoint = $userPointModel->getUserPointValue($my->id);

				if ($existingBalancePoint > 0)
				{
					$newBalancePoint = $existingBalancePoint + $packageValue;
					$userPointModel->updateUserBalancePoint($my->id, $newBalancePoint);
					$topupStatus = true;
				}
			}
		}

		$coreUrl = CRoute::_('index.php?option=com_community&view=topupcredit', false);

		if ($topupStatus)
		{
			echo $tmpl->set('coreUrl', $coreUrl)
			->fetch('topup.success');
		}
		else
		{
			echo $tmpl->set('coreUrl', $coreUrl)
			->fetch( 'topupcredit.fail');
		}
	}
	
}
