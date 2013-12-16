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
	public function display($tpl = null)
	{
		JError::raiseError( 403, JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN') );
		return;
	}

	public function success()
	{
		$tmpl	= new CTemplate();

		$targetDestinationUrl = CRoute::_('index.php?option=com_community', false);

		$user	= JFactory::getUser();
		if ( $user->get('guest'))
		{
			JError::raiseError( 403, JText::_('COM_COMMUNITY_ACCESS_FORBIDDEN') );
			return;
		}

		$session	= JFactory::getSession();
		$data = $session->get('topupPoint');

		$isValidSessionId = false;

		$topupPoint = 0; 
		
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

		$userPointModel = CFactory::getModel('userpoint');
		$currentPoint = $userPointModel->getUserPointValue($my->id);

		$newBalancePoint = $currentPoint + $point;

		$userPointModel->updateUserBalancePoint($my->id, $newBalancePoint);
		$session->set('topupPoint', '');
		
	}
}
