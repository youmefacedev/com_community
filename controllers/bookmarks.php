<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

defined('_JEXEC') or die();
jimport( 'joomla.application.component.controller' );

class CommunityBookmarksController extends CommunityBaseController
{
	public function ajaxShowBookmarks( $uri )
	{
		$filter	    =	JFilterInput::getInstance();
		$uri	    =	$filter->clean( $uri, 'string' );

		$config		= CFactory::getConfig();
		$shareviaemail	= $config->get( 'shareviaemail' );

		//CFactory::load( 'libraries' , 'bookmarks' );
		$bookmarks	= new CBookmarks( $uri );

		//CFactory::load( 'libraries' , 'apps' );
		$appsLib	= CAppPlugins::getInstance();

		$appsLib->loadApplications();

		// @onLoadBookmarks deprecated.
		// since 1.5
		$appsLib->triggerEvent( 'onLoadBookmarks' , array( $bookmarks ) );

		$response	= new JAXResponse();
		$tmpl		= new CTemplate();
		$tmpl->set( 'config'	    , $config )
		     ->set( 'bookmarks' , $bookmarks->getBookmarks() );

		$html		= $tmpl->fetch( 'bookmarks.list' );
		$total		= $bookmarks->getTotalBookmarks();
		$height		= $total * 10;
		$actions    = '';

		if($shareviaemail){
				$actions   .= '<input type="button" class="btn" onclick="cWindowHide();" value="' . JText::_('COM_COMMUNITY_CANCEL_BUTTON') . '"/>';
		    $actions   .= '<input type="button" class="btn btn-primary pull-right" onclick="joms.bookmarks.email(\'' . $uri. '\');" value="' . JText::_('COM_COMMUNITY_SHARE_BUTTON') . '"/>';
		} else {
		    $actions   .= '<input type="button" class="btn" onclick="cWindowHide();" value="' . JText::_('COM_COMMUNITY_CANCEL_BUTTON') . '"/>';
		}

		$response->addAssign('cwin_logo', 'innerHTML', JText::_('COM_COMMUNITY_SHARE_THIS'));
		$response->addScriptCall('cWindowAddContent', $html, $actions);

		return $response->sendResponse();
	}

	public function ajaxEmailPage( $uri , $emails , $message = '' )
	{
		$filter	    =	JFilterInput::getInstance();
		$uri	    =	$filter->clean( $uri, 'string' );
		$emails	    =	$filter->clean( $emails, 'string' );
		$message	    =	$filter->clean( $message, 'string' );

		$message	= stripslashes( $message );
		$mainframe	= JFactory::getApplication();
		$bookmarks	= CFactory::getBookmarks( $uri );
		$mailqModel = CFactory::getModel( 'mailq' );
		$config		= CFactory::getConfig();
		$response	= new JAXResponse();

		if(empty($emails ) )
		{
			$content	= '<div>' . JText::_('COM_COMMUNITY_SHARE_INVALID_EMAIL') . '</div>';
			$actions	= '<input type="button" class="btn" onclick="joms.bookmarks.show(\'' . $uri . '\');" value="' . JText::_('COM_COMMUNITY_GO_BACK_BUTTON') . '"/>';
		}
		else
		{
			$emails		= explode( ',' , $emails );
			$errors		= array();

			// Add notification
			//CFactory::load( 'libraries' , 'notification' );

			foreach( $emails as $email )
			{
				$email	= JString::trim($email);

				if(!empty($email) && CValidateHelper::email($email) )
				{
					$params			= new CParameter( '' );
					$params->set('uri' , $uri );
					$params->set('message' , $message );

					CNotificationLibrary::add( 'system_bookmarks_email' , '' , $email , JText::sprintf('COM_COMMUNITY_SHARE_EMAIL_SUBJECT', $config->get('sitename') ) , '' , 'bookmarks' , $params );
				}
				else
				{
					// If there is errors with email, inform the user.
					$errors[]	= $email;
				}
			}

			if( $errors )
			{
				$content	= '<div>' . JText::_('COM_COMMUNITY_EMAILS_ARE_INVALID') . '</div>';
				foreach($errors as $error )
				{
					$content	.= '<div style="font-weight:700;color: red;">' . $error . '</span>';
				}
				$actions   = '<input type="button" class="btn" onclick="joms.bookmarks.show(\'' . $uri . '\');" value="' . JText::_('COM_COMMUNITY_GO_BACK_BUTTON') . '"/>';
			}
			else
			{
				$content	= '<div>' . JText::_('COM_COMMUNITY_EMAIL_SENT_TO_RECIPIENTS') . '</div>';
				$actions   = '<input type="button" class="btn" onclick="cWindowHide();" value="' . JText::_('COM_COMMUNITY_DONE_BUTTON') . '"/>';
			}
		}

		$response->addAssign('cwin_logo', 'innerHTML', JText::_('COM_COMMUNITY_SHARE_THIS'));
		$response->addScriptCall('cWindowAddContent', $content, $actions);

		return $response->sendResponse();
	}
}