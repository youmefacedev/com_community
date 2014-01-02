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

class CommunityApproveTopupController extends CommunityBaseController
{
	var $_icon = 'search';

	public function display($cacheable=false, $urlparams=false)
	{
		$this->listNewTopupRequest();
	}

	public function approveRequest()
	{
		$view = $this->getView('approvetopup');
		echo $view->get('approveRequest');
	}
	
	public function cancelRequest()
	{
		$view = $this->getView('approvetopup');
		echo $view->get('cancelRequest');
	}
	
	
	function listNewTopupRequest()
	{	
		$view = $this->getView('approvetopup');
		echo $view->get('display');
	}
}