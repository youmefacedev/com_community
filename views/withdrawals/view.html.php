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

class CommunityViewWithdrawals extends CommunityView
{
	public function display($tpl = null)
	{
	    $document     = JFactory::getDocument(); 
        $document->setTitle("Credit Withdrawal"); 
		$this->displayWithdrawalRequest();
	}

	// Jeremy marked
	public function displayWithdrawalRequest()
	{
		$my = CFactory::getUser();
		$mainframe		= JFactory::getApplication();
		$config			= CFactory::getConfig();
		$document		= JFactory::getDocument();

		$tmpl	= new CTemplate();

		$coreUrl = CRoute::_('index.php?option=com_community', false);

		$withdrawalRequestModel = CFactory::getModel('withdrawalrequest');
		$wstatus=1;
         if($_REQUEST["wstatus"] != "")
		   $wstatus=$_REQUEST["wstatus"];
		   
		 $requestList = $withdrawalRequestModel->getWithdrawalRequestByStatus($wstatus);

		$adminUser = COwnerHelper::isCommunityAdmin($my->id);

		if ($adminUser)
		{
			echo $tmpl->set('coreUrl', $coreUrl)
			->set('requestList', $requestList)
			->fetch( 'withdrawalRequest.list');
		}
		else 
		{
			$coreUrl = CRoute::_('index.php?option=com_community', false);
			echo $tmpl->set('coreUrl', $coreUrl)->
			fetch( 'adminOnly.access');
		}
	}


	public function withdraw()
	{
		$tmpl	= new CTemplate();
		$my		= CFactory::getUser();
		$config	= CFactory::getConfig();
		$userPointModel = CFactory::getModel('userpoint');
		$coreUrl = CRoute::_('index.php?option=com_community&view=getcredit&task=withdraw', false);
			
		if($my->id == 0)
		{
			return $this->blockUnregister();
		}

		$post = JRequest::get('post');

		if (isset($post))
		{

			$withdrawValue = isset($post['withdrawValue']) ? $post['withdrawValue'] : 0;

			if (in_array("withdrawValue", $post))
			{
				$withdrawValue = $post["withdrawValue"];
			}

			$balancePoint = 0;
			$errorMessage = "";

			if (isset($withdrawValue))
			{
				$balancePoint = $this->getBalancePoint($my->id);
				$remainingBalance = $balancePoint - $withdrawValue;
				if ($remainingBalance >= 0)
				{
					$userPointModel->updateUserBalancePoint($my->id, $remainingBalance);
					$withdrawalDate = new DateTime();

					$this->initiateRequest($my->id, $withdrawalDate->format('Y-m-d H:i:s'), $withdrawValue, 0, 0, $withdrawalDate->format('Y-m-d H:i:s'));

				}
				else
				{
					$errorMessage = "You do not have enough balance to complete operation.";
				}
			}
		}
			
		$balancePoint = $this->getBalancePoint($my->id);
		$withdrawalPoint = $this->getWithdrawalPoint($my->id);

		echo $tmpl->set('balancePoint', $balancePoint)
		->set('errorMessage', $errorMessage)
		->set('coreUrl', $coreUrl)
		->set('withdrawalPoint', $withdrawalPoint)
		->fetch( 'getcredit.view');


	}

	private function getBalancePoint($userId)
	{
		$my 			= CFactory::getUser();
		$userPointModel = CFactory::getModel('userpoint');
		$userPoint 		= $userPointModel->getUserPoint($userId);
		$balancePoint = 0;
			
		foreach ($userPoint as $balanceElement)
		{
			$balancePoint = $balanceElement->balance_point;
		}

		return $balancePoint;
	}

	private function getWithdrawalPoint($userId)
	{
		$my 			= CFactory::getUser();
		$userPointModel = CFactory::getModel('userpoint');
		$userPoint 		= $userPointModel->getUserPoint($userId);

		$withdrawalPoint = 0;
		foreach ($userPoint as $balanceElement)
		{
			$withdrawalPoint = $balanceElement->withdrawal_point;
		}
		return $withdrawalPoint;
	}


	private function initiateRequest($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate)
	{
		$withdrawalRequestModel = CFactory::getModel('withdrawalrequest');
		$result = $withdrawalRequestModel->createRequest($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate);
			
	}

}
