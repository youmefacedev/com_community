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

class CommunityMyWithdrawController extends CommunityBaseController
{
	var $_icon = 'search';
	var $moduleName = "support";
	
	public function display($cacheable=false, $urlparams=false)
	{	  
		$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
		//echo json_encode($arr);
		$this->listSupport();
	}	
	
	function listSupport()
	{
		$mainframe	= JFactory::getApplication();
		$my 		= CFactory::getUser();
		$jinput 	= $mainframe->input;
		$data		= new stdClass();
		
		$view = $this->getView('mywithdraw');
			echo $view->get('display');
	}
	
	
	public function withdrawPoint()
	{
		
		 /*$withdrawValue = JRequest::getVar('withdrawPoint', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $country = JRequest::getVar('country', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $name = JRequest::getVar('name', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $bankName = JRequest::getVar('bankName', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $mepsRouting = JRequest::getVar('mepsRouting', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $acctnum = JRequest::getVar('acctnum', '', 'post', 'string', JREQUEST_ALLOWRAW); */
		 
		 $view = $this->getView('mywithdraw');
		 echo $view->get('withdrawPoint');
		 
		 
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