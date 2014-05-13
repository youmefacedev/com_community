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

class CommunityViewMyWithdraw extends CommunityView
{
	public function display($tpl = null)
	{
	    $document     = JFactory::getDocument(); 
        $document->setTitle("Credit Withdrawal"); 
		
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
		$my		= CFactory::getUser();
		$tmpl	= new CTemplate();
		
		$coreUrl = CRoute::_('index.php?option=com_community&view=mywithdraw&task=withdrawPoint', false);
		
		$giftModel = CFactory::getModel('support');
		$giftResult = $giftModel->getList();
		
		$balancePoint = $this->getBalancePoint($my->id);
	
		echo $tmpl->set('balancePoint', $balancePoint)
				  ->set('coreUrl', $coreUrl)	
			  ->fetch( 'mywithdraw');
	}
	
	public function withdrawPoint()
	{
		
		$tmpl	= new CTemplate();
		$my		= CFactory::getUser();
		$config	= CFactory::getConfig();
		$userPointModel = CFactory::getModel('userpoint');
		$coreUrl = CRoute::_('index.php?option=com_community&view=mywithdraw', false);
			
		if($my->id == 0)
		{
			return $this->blockUnregister();
		}
		
		$post = JRequest::get('post');
		
		if (isset($post))
		{		
			$withdrawValue = isset($post['withdrawPoint']) ? $post['withdrawPoint'] : 0;
				
			if (in_array("withdrawValue", $post))
			{
				$withdrawValue = $post["withdrawPoint"];
				
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
					
					$name = $post["name"];
					$bankName = $post["bankName"];
					$mepsRouting = $post["mepsRouting"];
					$acctnum = $post["acctnum"];
					$bankCountry = $post["bankCountry"];
					
					
					$this->initiateRequest($my->id, $withdrawalDate->format('Y-m-d H:i:s'), $withdrawValue, 0, 0, $withdrawalDate->format('Y-m-d H:i:s'), $name, $bankName, $mepsRouting, $acctnum, $bankCountry);
					
					$coreUrl = CRoute::_('index.php?option=com_community&view=mywithdraw', false);
					
					echo $tmpl->set('coreUrl', $coreUrl)
					->fetch( 'mywithdraw.success');
				}
				else
				{
					$errorMessage = "You do not have enough balance to complete operation.";
					
					$balancePoint = $this->getBalancePoint($my->id);
					$withdrawalPoint = $this->getWithdrawalPoint($my->id);
					
					echo $tmpl->set('balancePoint', $balancePoint)
					->set('errorMessage', $errorMessage)
					->set('coreUrl', $coreUrl)
					->fetch( 'mywithdraw');
						
				}
			}
		}
	}

	public function withdrawPointSuccess()
	{		
		$tmpl	= new CTemplate();
		$coreUrl = CRoute::_('index.php?option=com_community&view=mywithdraw', false);
		
		echo $tmpl->set('coreUrl', $coreUrl)
		->fetch( 'mywithdraw.success');
	}
	

	private function doAccessCheck()
	{
		
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
	
	private function initiateRequest($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRouting, $acctnum, $bankCountry)
	{
		$withdrawalRequestModel = CFactory::getModel('withdrawalrequest');
		$result = $withdrawalRequestModel->createRequestWithBankInfo($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRouting, $acctnum, $bankCountry);
		$withdrawalRequestModel->createRequestWithBankInfoHistory($userId, $withdrawal_date, $withdrawal_amount, $payment_method, $approvedByUser, $lastUpdate, $name, $bankName, $mepsRouting, $acctnum, $bankCountry);
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
}
