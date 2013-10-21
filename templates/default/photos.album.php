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
?>
<?php
if( $photos && $isOwner )
{
?>

<script type="text/javascript" src="<?php echo rtrim(JURI::root(),'/'); ?>/components/com_community/assets/ui.core.js"></script>
<script type="text/javascript" src="<?php echo rtrim(JURI::root(),'/'); ?>/components/com_community/assets/ui.sortable.js"></script>
<script type='text/javascript'>
joms.jQuery(document).ready(function(){
	joms.jQuery("ul.cMedia-ThumbList").dragsort({ dragSelector: "li div.cMedia-Box .cDragControl",
  		dragEnd: function() {
  			// Get new ordering
  			var ordering = [];
  			joms.jQuery("ul.cMedia-ThumbList li").each(function(index) {
				ordering.push( 'app-list[]=' + joms.jQuery(this).data('photoid') );
			});
  			console.log(ordering);
  			jax.call('community', 'photos,ajaxSaveOrdering', ordering.join('&') , joms.jQuery('#albumid').val() );
  			return false;
  		}, placeHolderTemplate: "<li class=\"dragged\"><div class=\"cMedia-Box\" style=\"height:200px;\"></div></li>", dragBetween: false
	});
});
</script>
<?php
}
?>
<script type='text/javascript'>
// Not required in this feature page
// Script below separate from top as applies to view on own and others albums
joms.jQuery(document).ready(function(){
	joms.jQuery('.cMapLoc').remove();
});

</script>

<div class="cLayout cPhotos-Album">

	<div class="cPageActions cPageAction clearfix">
		<?php echo $bookmarksHTML;?>
	</div>


	<?php
	if($photos)
	{
	?>
	<ul class="cMedia-ThumbList Photos cDragable cResetList cFloatedList clearfix">
	<?php
		$i = 0;
		for( $j=0; $j<count($photos); $j++ )
		{
			$row =& $photos[$j];
	?>
			<li id="photo-<?php echo $j;?>" title="<?php echo $this->escape($row->caption);?>" data-photoid="<?php echo $row->id;?>">
			<div class="cMedia-Box">
				<div class="cMedia-Avatar">
					<a href="<?php echo $row->link;?>" class="cMedia-Thumb cPhoto-Thumb">
						<img src="<?php echo $row->getThumbURI();?>" alt="<?php echo $this->escape($row->caption);?>" id="photoid-<?php echo $row->id;?>" />
					</a>
					<?php
					if( $isOwner || COwnerHelper::isCommunityAdmin() )
					{
					?>
					<div class="cMedia-Drag">
						<b class="btn cDragControl"><i class="com-icon-move"></i></b>
					</div>
					<div class="cMedia-Controls">
						<a class="btn btn-primary btn-small" href="javascript:void(0);" title="<?php echo JText::_('COM_COMMUNITY_REMOVE');?>" onclick="joms.gallery.confirmRemovePhoto('<?php echo $row->id;?>');">
							<?php echo JText::_('COM_COMMUNITY_REMOVE');?>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php
		$i++;
		if( $i % 4 == 0 ) {
			$i = 0; ?>
		<div class="clearfix"></div>
		<?php }
		}?>

	</ul>
	<?php if(isset($pagination)){?>
		<div class="cPagination">
			<?php echo $pagination->getPagesLinks(); ?>
		</div>
		<?php }?>
	<?php
		}
		else
		{
	?>
		<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_PHOTOS_NO_PHOTOS_UPLOADED');?></div>
	<?php
		}
	?>

	<div class="cLayout cMedia-Respond">

		<div class="row-fluid">

			<div class="span8">
				<div class="cMain">
					<div class="cMedia-Meta clearfull">
						<!-- Photo Description Section -->
						<?php
						if( ( $isOwner || $isAdmin ) || !empty($album->description) )
						{
						?>
						<div class="cMeta-Desc">
							<strong><?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_DESC');?></strong>
							<textarea class="community-photo-desc-editable <?php echo ( $isOwner || $isAdmin ) ? 'editable' : 'readonly';?>" <?php echo ( $isOwner || $isAdmin ) ? '' : 'readonly disabled="disabled"';?> style="border:medium none; resize:none;"><?php echo (($isOwner || $isAdmin) && empty($album->description)) ? JText::_('COM_COMMUNITY_PHOTOS_SHOW_EDITOR') : $this->escape($album->description); ?></textarea>
						</div>
						<?php
						}
						?>

						<?php if ($people): ?>
						<div class="cMedia-TagPeople">
							<strong><?php echo JText::_('COM_COMMUNITY_PHOTOS_IN_THIS_ALBUM'); ?> </strong>
								<?php $totalpeople = sizeof($people); $count = 1;
								foreach($people as $peep):?>
									<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid=' . $peep->id); ?>" rel="nofollow"><?php echo $peep->getDisplayName(); ?><?php if($count<$totalpeople){ echo ","; } ?></a>
								<?php
								$count++;
								endforeach;
								?>
						</div>
						<?php endif; ?>

						<a href="<?php echo CUrlHelper::userLink($owner->id); ?>" class="cMeta-Avatar cFloat-L">
							<img src="<?php echo $owner->getThumbAvatar(); ?>" class="cAvatar" alt="<?php echo $owner->getDisplayName(); ?>" />
						</a>

						<div class="cMeta-Details">
							<div class="cMeta-Like cFloat-R">
								<div id="like-container"><?php echo $likesHTML; ?></div>
							</div>
							<div class="cMedia-Updated">
								<?php echo JText::_('COM_COMMUNITY_BY').' <a href="'.CUrlHelper::userLink($owner->id). '">'. $owner->getDisplayName() . '</a>';?>
								<?php echo ' . '.JText::sprintf('COM_COMMUNITY_PHOTOS_ALBUM_LAST_UPDATED', $album->lastUpdated);?>
							</div>

							<?php if (!empty($album->location)): ?>
							<div class="cMedia-Location">
								<?php
									$link = $album->location;
									if($photosmapdefault==1 && $zoomableMap)
									{
										$link = '<a class="album-map-link" href="javascript:void(0);" onclick="joms.jQuery(\'#album-map\').toggle();">'.$album->location.'</a>';
									}
									echo JText::sprintf('COM_COMMUNITY_PHOTOS_ALBUM_TAKEN_AT_DESC', $link);
								?>
							</div>
							<?php endif ?>
						</div>
					</div>

					<div class="cMedia-Comments">
						<a name="comments"></a>
						<div class="cWall-Header"><?php echo JText::_('COM_COMMUNITY_COMMENTS') ?></div>
						<div id="wallForm" class="cWall-Form"><?php echo $wallForm; ?></div>
						<div id="wallContent" class="cWall-Content"><?php echo $wallContent; ?></div>
					</div>
				</div>
			</div>

			<div class="span4">
				<div class="cSidebar">
					<?php if($photosmapdefault==1 && $zoomableMap){ ?>
					<div class="cModule app-box">
						<div id="album-map">
							<h3 class="app-box-header cResetH"><?php echo JText::sprintf('COM_COMMUNITY_PHOTOS_ALBUM_TAKEN_AT_DESC', ''); ?></h3>
							<?php echo $zoomableMap;?>
						</div>
					</div>
					<?php } ?>

					<!-- Other Album Section -->
					<!-- Other Group Album -->
					<?php if(!empty($groupId)) { ?>
					<?php if (!empty($otherGroupAlbums)) {?>
					<div class="cModule app-box">
						<h3 class="app-box-header cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS_OTHER_ALBUMS'); ?></h3>
						<div class="app-box-content">
							<ul class="cThumbDetails cResetList">
								<?php
								foreach($otherGroupAlbums as $others) { ?>
								<li>
									<a class="cThumb-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $others->id . '&userid=' . $others->creator). '&groupid=' . $groupId; ?>">
										<img class="cAvatar" src="<?php echo $others->getCoverThumbURI(); ?>" alt="<?php echo $this->escape($others->name);?>" data="album_prop_<?php echo rand(0,200).'_'.$others->id;?>" />
									</a>
									<div class="cThumb-Detail">
										<a class="cThumb-Title" href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $others->id . '&userid=' . $others->creator. '&groupid=' . $groupId); ?>"><?php echo $this->escape($others->name); ?></a>
										<div class="cThumb-Brief small">
											<?php if(CStringHelper::isPlural($others->count)) {
												echo JText::sprintf('COM_COMMUNITY_PHOTOS_COUNT', $others->count );
												} else {
												echo JText::sprintf('COM_COMMUNITY_PHOTOS_COUNT_SINGULAR', $others->count );
												} ?>
										</div>
									</div>
									<div class="clear"></div>
								</li>
								<?php } //end foreach ?>
							</ul>
						</div>
					</div>
					<?php } //end if ?>
					<?php } else { ?>
					<!-- Other Album Section -->
					<?php
					if (!empty($otherAlbums)) {
					?>
					<div class="cModule app-box">
						<h3 class="app-box-header"><?php echo JText::_('COM_COMMUNITY_PHOTOS_OTHER_ALBUMS');?></h3>
						<div class="app-box-content">
							<ul class="cThumbDetails cResetList">
								<?php
								foreach($otherAlbums as $others) { ?>
								<li>
									<a class="cThumb-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $others->id . '&userid=' . $others->creator); ?>">
										<img class="cAvatar" src="<?php echo $others->getCoverThumbURI(); ?>" alt="<?php echo $this->escape($others->name);?>" data="album_prop_<?php echo rand(0,200).'_'.$others->id;?>" width="50" height="50"/>
									</a>
									<div class="cThumb-Detail">
										<a class="cThumb-Title" href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=album&albumid=' . $others->id . '&userid=' . $others->creator); ?>">
											<?php echo $this->escape($others->name); ?>
										</a>
										<div class="cThumb-Brief small">
											<?php if(CStringHelper::isPlural($others->count)) {
												echo JText::sprintf('COM_COMMUNITY_PHOTOS_COUNT', $others->count );
												} else {
												echo JText::sprintf('COM_COMMUNITY_PHOTOS_COUNT_SINGULAR', $others->count );
												} ?>
										</div>
									</div>
								</li>
								<?php } //end foreach ?>
							</ul>
						</div>
					</div>
					<?php } //end if ?>
					<?php } ?>

				</div>
			</div>
		</div>

	</div>

	<input type="hidden" name="albumid" value="<?php echo $album->id;?>" id="albumid" />
</div>




<script type='text/javascript'>

var prevId = "";
var documentCount=0;
var alinkPattern = "like-album-"; 

function closeSupport(id, liked)
{	
	if (liked)
	{
		jomsQuery("#" + alinkPattern + id).popover('hide');
	}
	reload();
}

function showLikeSupport(id)
{			
	jomsQuery("#" + alinkPattern + id).show();
}

function reload()
{
	functionCount=0;
}

function closeOtherPopup(currentId)
{
	if (prevId == "") 
		return; 

	if (prevId == currentId)
		return;
	
	jomsQuery(prevId).popover('hide');	
}

function showSupport(data, likedItem)
{	

	var content="";
	var idx=0; 
	
 	for(var i=0; i < data.length; i++)
 	{
 		idx++;
 		
		if (idx == 1)
		{
 			content += "<div class='tableRow'>";
		}
		
 			content += "<div class='tableColumn'>"; 
 			content += "<div class='cIndex-Box clearfix'>";
 			
 			content += "<div class='support-Content'>";
 			content += "<h3 class='cIndex-Name cResetH'>";
 					content += "<a href=''>" + data[i].code +  "</a>";
 			content += "</h3>";
 			
 			content += "<div class='cIndex-Status'><span><img src='../../.." + data[i].imageURL +  "'/></span></div>";
 			content += "<div class='cIndex-Status'><span></span><span>" + data[i].valuePoint +  " credits</span></div>";
 			content += "<div class='cIndex-Actions'><a href='#' class='btn btn-primary' id=sendSupport" + data[i].id + " giftId=" + data[i].id + " itemId=" + likedItem  + ">Send</a></div>";

	 		content += "</div>";
 			content += "</div>";
 			content += "</div>";
 			
 		
 		if (idx == 5 || (i + 1) == data.length)
 		{
 			content += "</div>";  // ending tag 
 		}

 		if (idx == 5)
 		{
	 		idx = 0;
 		}
 	}
 	
 	jomsQuery("#" + alinkPattern + likedItem).popover(
	{	
			 	placement : 'top',
			 	title : 'Like ' + 
			 	 '<button type="button" id="close" class="close" onclick="jomsQuery(&quot;' + "#" + alinkPattern + likedItem + '&quot;).popover(&quot;hide&quot;);">&times;</button>',
			 	 //'<button type="button" id="close" class="close" onclick="jomsQuery(&quot;' + ".popover" + '&quot;).hide();">&times;</button>', 
        		content : content 
        	
 	}).popover('show');

 	prevId = "#" + alinkPattern + likedItem;
  }

  function hideUserLike(likedItem)
  {  	
	 jomsQuery("#like-container").html("<i>Thanks! You liked this. </i>");
  }

  function getPhotoId(ctrlId)
  {
	var matchingStringPattern = "album-";
	var patternLen = matchingStringPattern.length;
	var searchResult = ctrlId.indexOf(matchingStringPattern);
	var idStr = ctrlId.substr(searchResult + patternLen);
	return idStr;
	
  }
  
	jomsQuery(document).ready(function()
    {    
	    	    
		if (documentCount == 0)
		{
			
			jomsQuery('a[id^=' +  alinkPattern + ' ]').live('click', function(evt) 
			{
				console.log('show...');
				var e=jomsQuery(this);
			    evt.preventDefault();
			    e.unbind('click');
				var ctrlId = getPhotoId(e.attr('id'));
				var ctrlId = e.attr('id');
			    jax.call('community','system,showSupport', getPhotoId(ctrlId));
			    return false;	
			});


			jomsQuery('a[id^=sendSupport]').live('click',function(evt) 
			{
						var e=jomsQuery(this);
					    e.unbind('click');
						    	
						var giftId = e.attr('giftId');
						var itemId = e.attr('itemId');
						
						if (confirm("Please acknowledge if you would like to proceed with this?"))
						{	
							jax.call('community','system,sendSupportAlbum', giftId, itemId);
							closeSupport(itemId, true);
						}
						else 
						{	
							closeSupport(itemId, false);
							prevId = "";
						}
						return false;
						    
			});
					
			documentCount++; // bind only DOM object tree only once
		}	
      });
	

</script>



<script type="text/javascript">




		joms.jQuery(document).ready(function() {
		var photoAlbumDesc = joms.jQuery('.community-photo-desc-editable');


		if (photoAlbumDesc.hasClass('editable'))
		{
			photoAlbumDesc
				.stretchToFit()
				.autogrow({lineHeight: 0, minHeight: 0})
				.focus(function()
				 {
					photoAlbumDesc
						.addClass('editing')
						.stretchToFit()
						.data('oldPhotoCaption', photoAlbumDesc.val());

					if ( photoAlbumDesc.val() == '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_SHOW_EDITOR'));?>')
					{
						photoAlbumDesc.val('');
					}
				 })
				.blur(function()
				 {
					photoAlbumDesc
						.removeClass('editing')
						.stretchToFit();

					var oldPhotoCaption = joms.jQuery.trim(photoAlbumDesc.data('oldPhotoCaption'));
					var newPhotoCaption = joms.jQuery.trim(photoAlbumDesc.val());

					if (newPhotoCaption=='' || newPhotoCaption==oldPhotoCaption)
					{
						photoAlbumDesc
							.val(oldPhotoCaption)
							.trigger('autogrow');
						return;
					}

					jax.call('community', 'photos,ajaxSaveAlbumDesc', joms.jQuery('#albumid').val(), newPhotoCaption);
				 });
		}
	});
</script>