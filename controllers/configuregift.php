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

class CommunityConfiguregiftController extends CommunityBaseController
{
	var $_icon = 'search';
	
	public function display($cacheable=false, $urlparams=false)
	{	    
		$this->listGift();
	}	
	
	function listGift()
	{
		$mainframe	= JFactory::getApplication();
		$my 		= CFactory::getUser();
		$jinput 	= $mainframe->input;
		$data		= new stdClass();
		
		$view = $this->getView('configuregift');
		echo $view->get('display');
	}
	
	public function addGift()
	{
		$view	=  $this->getView('configuregift');
		$my		= CFactory::getUser();
		$config	= CFactory::getConfig();

		if($my->id == 0 && !$config->get('configuregift'))
		{
			return $this->blockUnregister();
		}
		
		// save update feature is in the view // 
		echo $view->get('addGift');
	}
	
	public function editGift()
	{
		$view	=  $this->getView('configuregift');
		$my		= CFactory::getUser();
		$config	= CFactory::getConfig();

		if($my->id == 0 && !$config->get('configuregift'))
		{
			return $this->blockUnregister();
		}
		echo $view->get('editGift');
	}
	
	public function saveGift()
	{
		$view	=  $this->getView('configuregift');
		$my		= CFactory::getUser();
		$config	= CFactory::getConfig();
		$post = JRequest::get('post');
		$giftModel = CFactory::getModel('configuregift');
		
		if($my->id == 0 && !$config->get('configuregift'))
		{
			return $this->blockUnregister();
		}
		
		
		// just file upload module 
		jimport('joomla.filesystem.file');
        jimport('joomla.utilities.utility');
		
		$mainframe = JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$url = CRoute::_('index.php?option=com_community&view=configuregift');
		
		if ($jinput->post->get('action', '')) 
		{
            $mainframe = JFactory::getApplication();
			$fileFilter = new JInput($_FILES);
            $file = $fileFilter->get('Filedata', '', 'array');
			$userid = $my->id;
		}
	
		$fileFilter = new JInput($_FILES);
        $file = $fileFilter->get('Filedata', '', 'array');
		$giftRequest = JRequest::get('REQUEST');
		
		if (array_key_exists("filePart", $giftRequest))
		{
			$filePart = $giftRequest["filePart"]; 
		}
		else 
		{
			$filePart = "";
		}
		
		if (!isset($file['tmp_name']) || empty($file['tmp_name'])) 
		{ 
			//$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_NO_POST_DATA'), 'error');
			//if (isset($url)) {
            //    $mainframe->redirect($url);
            //}
        } 
		else 
		{
                
				$config = CFactory::getConfig();
                $uploadLimit = (double) $config->get('maxuploadsize');
                $uploadLimit = ( $uploadLimit * 1024 * 1024 );

                // @rule: Limit image size based on the maximum upload allowed.
                if (filesize($file['tmp_name']) > $uploadLimit && $uploadLimit != 0) {
                    $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_VIDEOS_IMAGE_FILE_SIZE_EXCEEDED'), 'error');

                    if (isset($url)) {
                        $mainframe->redirect($url);
                    }

                    $mainframe->redirect(CRoute::_('index.php?option=com_community&view=profile&userid=' . $userid . '&task=uploadAvatar', false));
                }

                if (!CImageHelper::isValidType($file['type'])) {
                    $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_IMAGE_FILE_NOT_SUPPORTED'), 'error');

                    if (isset($url)) {
                        $mainframe->redirect($url);
                    }

                    $mainframe->redirect(CRoute::_('index.php?option=com_community&view=profile&userid=' . $userid . '&task=uploadAvatar', false));
                }
				
				$storage = JPATH_ROOT . '/' . $config->getString('imagefolder') . '/avatar';
                $profileType = $my->getProfileType();
                $fileName = JApplication::getHash($file['tmp_name'] . time());
                $hashFileName = JString::substr($fileName, 0, 24);
				
				$filePart = '/images/gift/' . $fileName . CImageHelper::getExtension($file['type']);
				$destination = JPATH_ROOT . $filePart;
				
				JFile::copy($file['tmp_name'], $destination);
                $this->cacheClean(array(COMMUNITY_CACHE_TAG_ACTIVITIES, COMMUNITY_CACHE_TAG_FRONTPAGE));
                
			}
		
			$userId = $my->id;
			$giftModel->saveGift($post, $userId, $filePart);
			echo $view->get('saveComplete');
	}
	
	public function deleteGift()
	{
		$view	=  $this->getView('configuregift');
		$giftRequest = JRequest::get('REQUEST');
		
		$giftModel = CFactory::getModel('configuregift');
		
		$id = $giftRequest["id"];
		if (isset($id))
		{
			$giftModel->deleteGift($id);
			echo $view->get('removeComplete');
		}
	}
}