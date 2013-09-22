<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

$groupsModel = CFactory::getModel('groups');
$activeGroup = $groupsModel->getMostActiveGroup();

if( is_null($activeGroup)) { 
	$title = JText::_('COM_COMMUNITY_GROUPS_NONE_CREATED'); 
} else {
	$title       = JText::sprintf('COM_COMMUNITY_MOST_POPULAR_GROUP_ACTIVITY_TITLE', CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$activeGroup->id), $activeGroup->name);

}

?>
<div class="cStream-Content">

	<div class="cStream-Headline">
		<b><?php echo $title; ?></b>
	</div>

	<!-- .cStream-Attachment -->
	<div class="cStream-Attachment">
		<div class="cSnippets Block">
			<?php if( !is_null($activeGroup)) { 
				$memberCount = $activeGroup->getMembersCount(); ?>
			<!-- .cSnip -->
			<div class="cSnip clearfix">
				<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$activeGroup->id) ?>" class="cSnip-Avatar cFloat-L">
					<img alt="Ila Damia" src="<?php echo $activeGroup->getThumbAvatar(); ?>" class="cAvatar cAvatar-Large">
				</a>
				<div class="cSnip-Detail">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$activeGroup->id) ?>" class="cSnip-Title">
						<?php echo $this->escape($activeGroup->name); ?>
					</a>
					<div class="cSnip-Info small">
						<span>
							<?php echo JText::sprintf( (CStringHelper::isPlural( $memberCount)) ? 'COM_COMMUNITY_GROUPS_MEMBER_COUNT_MANY' : 'COM_COMMUNITY_GROUPS_MEMBER_COUNT' , $memberCount ); ?>
						</span>
					</div>
				</div>
			</div>
			<!-- .cSnip -->
			<?php } ?>

		</div>
	</div>
	<!-- .cStream-Attachment -->
	<?php $this->load('activities.actions'); ?>
</div>