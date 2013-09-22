<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

$user = CFactory::getUser($this->act->actor);
$users = explode(',', $this->actors);
$actorsHTML = array();
?>
<div class="cStream-Content">
<i class="cStream-Icon com-icon-groups"></i>
	<?php foreach($users as $actor)
	{
		if (!$actor) {
			//http://www.jomsocial.com/forum/events/2411-2-8-1-shows-users-attending-events-they-have-not-signed-up-for-on-the-wall#12571
			$actor = $this->act->actor;
		}
		$user = CFactory::getUser($actor);
		$actorsHTML[] = '<a class="cStream-Author" href="'. CUrlHelper::userLink($user->id).'">'. $user->getDisplayName().'</a>';
	}

	echo implode(', ', $actorsHTML); ?>
	-
	<?php echo JText::sprintf('COM_COMMUNITY_ACTIVITIES_EVENT_ATTEND' , $this->event->getLink(), $this->event->title);
	?>
</div>
