<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

defined('_JEXEC') or die('Restricted access');

class CUserHelper
{
	static public function getUserId( $username )
	{
		$db		= JFactory::getDBO();
		$query	= 'SELECT ' . $db->quoteName( 'id' ) . ' '
				. 'FROM ' . $db->quoteName( '#__users' ) . ' '
				. 'WHERE ' . $db->quoteName( 'username' ) . '=' . $db->Quote( $username );

		$db->setQuery( $query );

		$id		= $db->loadResult();

		return $id;
	}

	static function getThumb( $userId , $imageClass = '' , $anchorClass = '' )
	{
		//CFactory::load( 'helpers' , 'string' );
		$user	= CFactory::getUser( $userId );

		$imageClass		= (!empty( $imageClass ) ) ? ' class="' . $imageClass . '"' : '';
		$anchorClass	= ( !empty( $anchorClass ) ) ? ' class="' . $anchorClass . '"' : '';

		$data	= '<a href="' . CRoute::_('index.php?option=com_community&view=profile&userid=' . $user->id ) . '"' . $anchorClass . '>';
		$data	.= '<img src="'.$user->getThumbAvatar().'" alt="' . CStringHelper::escape( $user->getDisplayName() ) . '"' . $imageClass . ' />';
		$data	.= '</a>';

		return $data;
	}

	/**
	 * Get the html code to be added to the page
	 *
	 * return	$html	String
	 */
	static public function getBlockUserHTML( $userId, $isBlocked )
	{
		$my    = CFactory::getUser();
		$html = '';

		if(!empty($my->id)) {

		    $tmpl  = new Ctemplate();

		    $tmpl->set( 'userId'   , $userId );
		    $tmpl->set( 'isBlocked', $isBlocked);
		    $html = $tmpl->fetch( 'block.user' );

	  	}

		return $html;
	}

	static public function isUseFirstLastName()
	{
		$isUseFirstLastName	= false;

		// Firstname, Lastname for base on field code FIELD_GIVENNAME, FIELD_FAMILYNAME
		$modelProfile	= CFactory::getModel('profile');

		$firstName		= $modelProfile->getFieldId('FIELD_GIVENNAME');
		$lastName		= $modelProfile->getFieldId('FIELD_FAMILYNAME');
		$isUseFirstLastName	= ($firstName && $lastName);

		if ($isUseFirstLastName)
		{
			$table		= JTable::getInstance('ProfileField', 'CTable');
			$table->load($firstName);
			$isFirstNamePublished	= $table->published;
			$table->load($lastName);
			$isLastNamePublished	= $table->published;
			$isUseFirstLastName		= ($isFirstNamePublished && $isLastNamePublished);

			// we don't use this html because the generated class name doesn't match in this case
			//$firstNameHTML	= CProfile::getFieldHTML($firstName);
			//$lastNameHTML	= CProfile::getFieldHTML($lastName);
		}

		return $isUseFirstLastName;
	}

	/**
	 * Add default items for status box
	 */
	static function addDefaultStatusCreator(&$status)
	{
		$mainframe	= JFactory::getApplication();
		$jinput 	= $mainframe->input;

		$my 		= CFactory::getUser();
		$userid		= $jinput->get('userid', $my->id, 'INT'); //JRequest::getVar('userid', $my->id);
		$user		= CFactory::getUser($userid);
		$config 	= CFactory::getConfig();
		$template	= new CTemplate();

		$isMine = COwnerHelper::isMine($my->id, $user->id);

		/* Message creator */
		$creator        = new CUserStatusCreator('message');
		$creator->title = JText::_('COM_COMMUNITY_STATUS');
		$creator->html  = $template->fetch('status.message');
		$status->addCreator($creator);

		if($isMine){
		if( $config->get( 'enablephotos') )
		{
			/* Photo creator */
			$creator        = new CUserStatusCreator('photo');
			$creator->title = JText::_('COM_COMMUNITY_SINGULAR_PHOTO');
			$creator->html  = $template->fetch('status.photo');

			$status->addCreator($creator);
		}

		if( $config->get( 'enablevideos') )
		{
			/* Video creator */
			$creator        = new CUserStatusCreator('video');
			$creator->title = JText::_('COM_COMMUNITY_SINGULAR_VIDEO');
			$creator->html  = $template->fetch('status.video');

			$status->addCreator($creator);
		}

		if( $config->get( 'enableevents') && ($config->get('createevents') || COwnerHelper::isCommunityAdmin() )  )
		{
			/* Event creator */
			//CFactory::load( 'helpers' , 'event' );
			$dateSelection = CEventHelper::getDateSelection();

			$model		= CFactory::getModel( 'events' );
			$categories	= $model->getCategories();

			// Load category tree

			$cTree	= CCategoryHelper::getCategories($categories);
			$lists['categoryid']	=   CCategoryHelper::getSelectList( 'events', $cTree );

			$template->set( 'startDate'       , $dateSelection->startDate );
			$template->set( 'endDate'         , $dateSelection->endDate );
			$template->set( 'startHourSelect' , $dateSelection->startHour );
			$template->set( 'endHourSelect'   , $dateSelection->endHour );
			$template->set( 'startMinSelect'  , $dateSelection->startMin );
			$template->set( 'repeatEnd'       , $dateSelection->endDate );
			$template->set( 'enableRepeat'    , $my->authorise('community.view', 'events.repeat'));
			$template->set( 'endMinSelect'    , $dateSelection->endMin );
			$template->set( 'startAmPmSelect' , $dateSelection->startAmPm );
			$template->set( 'endAmPmSelect'   , $dateSelection->endAmPm );
			$template->set( 'lists'           , $lists );

			$creator  = new CUserStatusCreator('event');
			$creator->title = JText::_('COM_COMMUNITY_SINGULAR_EVENT');
			$creator->html  = $template->fetch('status.event');

			$status->addCreator($creator);
		}
		}
	}
}