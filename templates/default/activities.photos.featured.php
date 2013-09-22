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

$param = new CParameter($this->act->params);

$user = CFactory::getUser($this->act->actor);
$album = JTable::getInstance('Album', 'CTable');
$album->load($this->act->cid);
$album->user = CFactory::getUser($album->creator);

?>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<b>
			<?php echo JText::sprintf('COM_COMMUNITY_ALBUM_IS_FEATURED','<a href="'.CRoute::_($param->get('album_url')).'" class="cStream-Title">'.$this->escape($album->name).'</a>')?>

		</b>
	</div>
	<div class="cStream-Attachment">
		<div class="cSnippets Block">
			<div class="cSnip clearfix">
				<a class="cSnip-Avatar Album cFloat-L" href="<?php echo CRoute::_($param->get('album_url'))?>">
					<img class="cAvatar" src="<?php echo $album->getCoverThumbURI()?>" >
				</a>
				<div class="cSnip-Detail">
					<a class="cSnip-Title" href="<?php echo CRoute::_($param->get('album_url'))?>">
						<?php echo $this->escape($album->name)?>
					</a>
					<div class="cSnip-Info small">
						<span>
							<?php echo JText::_('COM_COMMUNITY_PHOTOS_BY'); ?>
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$album->creator); ?>"><?php echo $album->user->getDisplayName(); ?></a>

						</span>
						<span>
							<?php echo $album->getLastUpdate(); ?>
						</span>
						<span>
							<?php
							if(isset($album->location) && $album->location != "")
							{
								echo JText::sprintf('COM_COMMUNITY_EVENTS_TIME_SHORT', $album->location );
							}
							?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Tell actions that this is a featured stream
	$this->act->isFeatured = true;
	$this->load('activities.actions');
	?>

</div>