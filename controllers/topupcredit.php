<?php
/**
 * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
 * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author iJoomla.com <webmaster@ijoomla.com>
 * @url https://www.jomsocial.com/license-agreement
 * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
 * More info at https://www.jomsocial.com/license-agreement
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.utilities.date');

class CommunityTopupCreditController extends CommunityBaseController
{
	var $_icon = 'search';
	var $moduleName = "support";

	public function display($cacheable=false, $urlparams=false)
	{	
		$this->listSupport();
	}

	function listSupport()
	{
		$mainframe	= JFactory::getApplication();
		$my 		= CFactory::getUser();
		$jinput 	= $mainframe->input;
		$data		= new stdClass();

		$view = $this->getView('topupcredit');
		echo $view->get('display');
	}


	public function topupForUser()
	{
		$view = $this->getView('topupcredit');
		echo $view->get('topupForUser');
	}

	public function buySupport()
	{
		$view	=  $this->getView($moduleName);
		$giftRequest = JRequest::get('REQUEST');

		$giftModel = CFactory::getModel($moduleName);

		$id = $giftRequest["id"];
		if (isset($id))
		{
			$giftModel->deleteGift($id);
			echo $view->get('removeComplete');
		}
	}
}