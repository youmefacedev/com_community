<script>
		
		function closeSupport(id, liked)
		{	
			jomsQuery("#like_id" + id).popover('hide');
			
			if (liked)
			{
				jomsQuery("#like_id" + id).hide();
			}
			reload();
		}

		function reload()
		{
			functionCount=0;
		}

		function showLikeSupport(id)
		{			
			jomsQuery("#like_id" + id).show();
		}

		var prevId = ""; 

		// show support 
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
				
		 			content += "<div class='tableColumn' style='text-align:center'>"; 
		 			content += "<div class='cIndex-Box clearfix'>";
		 			
		 			content += "<div class='support-Content'>";
		 			content += "<h3 class='cIndex-Name cResetH'>";
		 					content +=   data[i].description ;
		 			content += "</h3>";
		 			
		 			content += "<div class='cIndex-Status'><span><img src='../../.." + data[i].imageURL +  "'/></span></div>";
		 			content += "<div class='cIndex-Status'><span></span><span>" + data[i].valuePoint +  " pts</span></div>";
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

		 	closeOtherPopup("#like_id" + likedItem);

		 	jomsQuery("#like_id" + likedItem).popover(
				 	{	
					 	placement : 'right',
					 	title : 'Like ' + 
					 	 '<button type="button" id="close" class="close" onclick="jomsQuery(&quot;#like_id' + likedItem + '&quot;).popover(&quot;hide&quot;);">&times;</button>', 
		        		content : content 
		        	
		 	}).popover('show');

		 	prevId = "#like_id" + likedItem;
		 	
		}
		
		function closeOtherPopup(currentId)
		{
			if (prevId == "") 
				return; 

			if (prevId == currentId)
				return;

			jomsQuery(prevId).popover('hide');
			
		}
		
		// binds support buttons
		var documentCount=0;
	         
		jomsQuery(document).ready(function()
        {
			if (documentCount == 0)
			{
				jomsQuery('a[id^=like_id]').live('click', function(evt) {

						var e=jomsQuery(this);
					    evt.preventDefault();
					    e.unbind('click');
						var ctrlId = e.attr('id');
		 			    jax.call('community','system,showSupport', ctrlId);
		   			   
				});

				jomsQuery('a[id^=sendSupport]').live('click',function(evt) 
				{
					var e=jomsQuery(this);
				    e.unbind('click');
					    	
					var giftId = e.attr('giftId');
					var itemId = e.attr('itemId');
					if (confirm("Please acknowledge if you would like to proceed with this?"))
					{
						jax.call('community','system,sendSupport', giftId, itemId);
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


<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/



// test
// $act->app can be a single word or in app.action form.
// EG:// 'event', 'event.wall'. Find the first part only
$appName = explode('.', $act->app);
$appName = $appName[0];

// Grab primary object to be used in permission checking, defined by appname
$obj = $act;
if( $appName == 'groups'){
$obj = $this->group;
}

if($appName == 'events'){
$obj = $this->event;
}

$my = CFactory::getUser();
$allowLike = !empty($my->id);
$allowComment = ($my -> authorise('community.add','activities.comment.'.$this->act->actor, $obj) );
$showLocation = !empty($this->act->location);

// @todo: delete permission shoudl be handled within ACL system
$allowDelete= ( ($act->actor == $my->id) || $isCommunityAdmin || ( $act->target == $my->id )) && ($my->id != 0);

// Allow system message deletion only for admin
if($act->app == 'users.featured'){
$allowDelete=  $isCommunityAdmin;
}

//Discussion Replies shouldnt allow any commenting - 30Jan13 (http://www.ijoomla.com:8080/browse/JOM-142)
if($act->app == 'groups.discussion.reply' || $act->app == 'groups.discussion' || $act->app == 'groups.bulletin'){
$allowComment = false;
}

// Allow comment for system post
if($appName == 'system'){
$allowComment = !empty($my->id);
}

?>
<div class="cStream-Actions clearfix">
<i class="cStream-Icon com-icon-<?php echo $appName;?> <?php if( isset($act->isFeatured))  echo 'com-icon-award-gold' ;?>"></i>


<!-- Show likes -->
<?php if($allowLike) { ?>
<span>

<?php if($act->userLiked != COMMUNITY_LIKE) { ?>
<!--   ++++ --> <a id="like_id<?php echo $act->id?>" href="#" 	data-actor="<?php echo $act->actor?>" data-toggle="popover" href="#"><?php echo JText::_('COM_COMMUNITY_LIKE');?></a>
<?php } else { ?>
<!--  <a id="like_id<?php echo $act->id?>" href="#unlike" ><?php echo JText::_('COM_COMMUNITY_UNLIKE');?></a>  --> <!-- jeremy woo need to disable this!  -->     
<?php } ?>
</span>
<?php } ?>

<!-- Show if it is explicitly allowed: -->
<?php if($allowComment ) { ?>
<span><a href="javascript:void(0);" onclick="joms.miniwall.show('<?php echo $act->id; ?>');return false;"><?php echo JText::_('COM_COMMUNITY_COMMENT');?></a></span>
<?php } ?>

<?php if( $showLocation ) { ?>
<span><a onclick="joms.activities.showMap(<?php echo $act->id; ?>, '<?php echo urlencode($act->location); ?>');" class="newsfeed-location" title="<?php echo JText::_('COM_COMMUNITY_VIEW_LOCATION_TIPS');?>" href="javascript: void(0)"><?php echo JText::_('COM_COMMUNITY_VIEW_LOCATION');?></a></span>
<?php } ?>

<?php /* Allow deleted */ ?>
<?php if( $allowDelete ) { ?>
<span><a href="#deletePost" class="newsfeed-location" title="<?php echo JText::_('COM_COMMUNITY_DELETE');?>" href="javascript: void(0)"><?php echo JText::_('COM_COMMUNITY_DELETE');?></a></span>
<?php } ?>

<?php
// Format created date
$date = JFactory::getDate($act->created);
$createdTime = CTimeHelper::timeLapse($date);
?>
<span><?php echo $createdTime; ?></span>

<?php
// Show access class for "friends (30)" or "me only (40)"
$accessClass = 'public'; // NO need to display this
$accessClass = ($act->access == PRIVACY_FRIENDS) ? 'site' : $accessClass ;
$accessClass = ($act->access == PRIVACY_FRIENDS) ? 'friends' : $accessClass ;
$accessClass = ($act->access == PRIVACY_PRIVATE) ? 'me' : $accessClass ;

$accessTitle = "";
$accessTitle = ($accessClass == 'site') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_SITE_MEMBERS') : $accessTitle;
$accessTitle = ($accessClass == 'friends') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_FRIENDS') : $accessTitle;
$accessTitle = ($accessClass == 'me') ? JText::_('COM_COMMUNITY_PRIVACY_TITLE_ME') : $accessTitle;

if($accessClass != 'public') {
?>
<span>
<i class="com-glyph-lock-<?php echo $accessClass; ?>" title="<?php echo $accessTitle; ?>"></i>
</span>
<?php } ?>
</div>

<?php if( $allowComment || $allowLike || $showLike) { ?>
<div class="cStream-Respond wall-cocs" id="wall-cmt-<?php echo $act->id; ?>">
<?php if($act->likeCount > 0 && $showLike) { /* hide count if no one like it */?>
<div class="cStream-Likes">
<i class="stream-icon com-icon-thumbup"></i><!--  Initial load .. -->
<a onclick="jax.call('community','system,ajaxStreamShowLikes', '<?php echo $act->id; ?>');return false;" href="#showLikes"><?php echo ($act->likeCount > 1) ? JText::sprintf('COM_COMMUNITY_LIKE_THIS_MANY', $act->likeCount) : JText::sprintf('COM_COMMUNITY_LIKE_THIS', $act->likeCount); ?></a>
</div>
<?php } ?>
<?php if( $act->commentCount > 1 ) { ?>
<div class="cStream-More" data-commentmore="true">
<i class="stream-icon com-icon-comment"></i>
<a href="#showallcomments"><?php echo JText::sprintf('COM_COMMUNITY_ACTIVITY_NO_COMMENT',$act->commentCount,'wall-cmt-count') ?></a>
</div>
<?php } ?>
<?php if( $act->commentCount > 0 ) { ?>
<?php echo $act->commentLast; ?>
<?php } ?>

<?php if($allowComment ) : ?>
<div class="cStream-Form stream-form wallform <?php if($act->commentCount == 0): echo 'wallnone'; endif; ?>" data-formblock="true">
<!-- post new comment form -->
<form class="reset-gap">
	<textarea class="cStream-FormText input-block-level" cols="" rows="" style="height: 40px;" name="comment"></textarea>
	<div class="cStream-FormSubmit">
		<a class="cStream-FormCancel" onclick="joms.miniwall.cancel('<?php echo $act->id; ?>');return false;" href="#cancelPostinComment"><?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON');?></a>
		<button type="submit" class="btn btn-primary btn-small" onclick="joms.miniwall.add('<?php echo $act->id; ?>');return false;"><?php echo JText::_('COM_COMMUNITY_POST_COMMENT_BUTTON');?></button>
	</div>
</form>
</div>

<?php /* Hide reply button if no one has post a comment */ ?>
<?php if( $allowComment ): ?>
<div  data-replyblock="true" <?php if( $act->commentCount == 0 ) { echo 'style="display:none"'; }?> >
<span class="cStream-Reply"><a href="javascript:void(0);" onclick="joms.miniwall.show('<?php echo $act->id; ?>')" ><?php echo JText::_('COM_COMMUNITY_REPLY');?></a></span>

</div>
<?php endif; ?>
<?php endif; ?>

</div>
<?php } ?>
