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

class CommunityViewPayment extends CommunityView
{
	//$paymentState = 0; 
	
	public function display($tpl = null)
	{
		
			//header("HTTP/1.1 200 OK");
			//$paymentState = 1; 
	    
			// echo contents back to paypal
			//$queryStringPaypal = $_SERVER['QUERY_STRING'];
			//$paypalAckPost = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_notify-validate&" . $queryStringPaypal;
			//$xml = file_get_contents($paypalAckPost);
		
			//file_put_contents("paypal.txt", $person, FILE_APPEND | LOCK_EX);

echo 'etst';
		
	}

	
	public function paymentSuccess()
	{
		$tmpl	= new CTemplate();
		$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);
		
		$mainframe = JFactory::getApplication();
		$my		= JFactory::getUser();
		
		if($my->id == 0)
		{
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
			return;
		}
		
		$trxId =  (isset($_REQUEST["txn_id"]) ? $_REQUEST["txn_id"] : null);
		$status = (isset($_REQUEST["payment_status"]) ? $_REQUEST["payment_status"] : null);
		
		if (strtoupper($status) == "COMPLETED")
		{
			$userTopupModel = CFactory::getModel('topupactivity');
			$tempTopupId = $userTopupModel->getTempId($trxId);
			
			if ($tempTopupId != null)
			{	
				$topupDate = new DateTime();
				
				$userTopupModel->createRequest($my->id, 'user topup request', $tempTopupId->valuePoint, $tempTopupId->valuePoint, $tempTopupId->paymentTransactionId, $topupDate->format('Y-m-d H:i:s'));
				$userTopupModel->createRequestHistory($my->id, 'user topup test', $tempTopupId->valuePoint, $tempTopupId->valuePoint, $tempTopupId->paymentTransactionId, $topupDate->format('Y-m-d H:i:s'), 1);
				$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);
				
				// Update user balance point // 
				$userPointModel = CFactory::getModel('userpoint');
				$currentPoint = $userPointModel->getUserPointValue($my->id);
				
				$newBalancePoint = $currentPoint + $tempTopupId->valuePoint;
				$userPointModel->updateUserBalancePoint($my->id, $newBalancePoint);
				
				echo $tmpl->set('targetDestinationUrl', $targetDestinationUrl)->set('topupPoint', $tempTopupId->valuePoint)
				->fetch( 'payment.success');
			}
			
		}
		else 
		{
			$tmpl	= new CTemplate();
			$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);
			
			echo $tmpl->set('targetDestinationUrl', $targetDestinationUrl)
			->fetch( 'payment.cancel');
		}
	}
	
	public function success()
	{
		$tmpl	= new CTemplate();
		$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);
		
		$mainframe = JFactory::getApplication();
		$my		= JFactory::getUser();
		
		if($my->id == 0)
		{
			$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
			return;
		}
		
		$session	= JFactory::getSession();
		$data = $session->get('topupPoint');

		$isValidSessionId = false;

		$topupPoint = 0; 
		
		if ($data == "10pts")
		{
			$isValidSessionId = true;
			$topupPoint = 10;
			$this->updateUserPoint($topupPoint);
		}
		
		
		if ($data == "20pts")
		{
			$isValidSessionId = true;
			$topupPoint = 20;
			$this->updateUserPoint($topupPoint);
		}
		
		if ($data == "50pts")
		{
			$isValidSessionId = true;
			$topupPoint = 50;
			$this->updateUserPoint($topupPoint);
		}
		
		if ($data == "100pts")
		{
			$isValidSessionId = true;
			$topupPoint = 100;
			$this->updateUserPoint($topupPoint);
		}

		if ($data == "500pts")
		{
			$isValidSessionId = true;
			$topupPoint = 500;
			$this->updateUserPoint($topupPoint);
		}

		if ($data == "1000pts")
		{
			$isValidSessionId = true;
			$topupPoint = 1000;
			$this->updateUserPoint($topupPoint);
		}

		if ($isValidSessionId)
		{
			echo $tmpl->set('targetDestinationUrl', $targetDestinationUrl)->set('topupPoint', $topupPoint)
			->fetch( 'payment.success');
		}
		else {
			echo $tmpl->set('targetDestinationUrl', $targetDestinationUrl)
			->fetch( 'payment.cancel');
		}
	}

	public function cancel()
	{
		$tmpl	= new CTemplate();
		$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);
		
		echo $tmpl->set('targetDestinationUrl', $targetDestinationUrl)
		->fetch( 'payment.cancel');
	}

	private function updateUserPoint($point)
	{
		$session	= JFactory::getSession();
		$my 			= CFactory::getUser();
		
		$topupDate = new DateTime();
		$userTopupModel = CFactory::getModel('topupactivity');
		$userTopupModel->createRequest($my->id, 'test', $point, $point, 911, $topupDate->format('Y-m-d H:i:s'));
		$userTopupModel->createRequestHistory($my->id, 'test', $point, $point, 911, $topupDate->format('Y-m-d H:i:s'), 1);
		$session->set('topupPoint', '');
		
	}
}
