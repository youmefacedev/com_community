<style>

.popover-title {
    background-color: #F7F7F7;
    border-bottom: 1px solid #EBEBEB;
    border-radius: 5px 5px 0 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 18px;
    margin: 0;
    padding: 8px 14px;
}

.popover {
    background-clip: padding-box;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px 6px 6px 6px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    display: none;
    left: 0;
    max-width: 276px;
    padding: 1px;
    position: absolute;
    text-align: left;
    top: 0;
    white-space: normal;
    z-index: 1010;
}

.fade {
    opacity: 0;
    transition: opacity 0.15s linear 0s;
}

.fade.in {
    opacity: 1;
}

.support-Content
{
	border: 1px solid #DADADA;
    border-radius: 3px 3px 3px 3px;
    margin: 2px;
    padding: 2px;
}

.cIndex-Status img 
{
	width : 48px;
	height : 48px;	
}



#close {
    float: right;
    font-size: 0.85em;
    margin-right: 0;
    text-transform: uppercase;
}


.cIndex-Status span
{
	font-size : 90%;	
}

.cIndex-Name a:link, a:visited {
    color: #095197;
    text-decoration: none;
    font-size : 14px;
}

.cIndex-Actions a.btn-primary {
	background-color: #006DCC;
    background-image: linear-gradient(to bottom, #0088CC, #0044CC);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #FFFFFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}

.cIndex-Actions a.btn {
 	-moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #F5F5F5;
    background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
    background-repeat: repeat-x;
    border-color: #CCCCCC #CCCCCC #B3B3B3;
    border-image: none;
    border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    float: none;
    font-size: 14px;
    height: auto;
    line-height: 20px;
    margin-bottom: 0;
    padding: 4px 12px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    text-transform: none;
    vertical-align: middle;
    text-decoration : none;
}


.popover {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1010;
  display: none;
  max-width: 600px;
  padding: 1px;
  text-align: left;
  white-space: normal;
  background-color: #ffffff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
     -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
          box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
     -moz-background-clip: padding;
          background-clip: padding-box;
}

.popover-content {
    
}

</style>

<script>

		
		function closeSupport(id)
		{	
			jomsQuery("#like_id" + id).popover('hide');
			jomsQuery("#like_id" + id).hide();
			reload();
		}

		function reload()
		{
			//alert(functionCount);
			functionCount=0;
			//window.location.reload();
			//alert(functionCount);
			//documentCount=0;
			//functionCount=0; 
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

		 	closeOtherPopup();

		 	jomsQuery("#like_id" + likedItem).popover(
				 	{
					 	title : 'Like ' + 
					 	 '<button type="button" id="close" class="close" onclick="jomsQuery(&quot;#like_id' + likedItem + '&quot;).popover(&quot;hide&quot;);">&times;</button>', 
		        		content : content
		 	}).popover('show');

		 	prevId = "#like_id" + likedItem;
		 	
		}
		

		function closeOtherPopup()
		{
			if (prevId == "") 
				return; 

			jomsQuery(prevId).popover('hide');
			
		}
		
		// binds support buttons
		var documentCount=0;
	         
		jomsQuery(document).ready(function()
        {
			var functionCount=0; 
			                       	
			if (documentCount == 0)
			{
				jomsQuery('a[id^=like_id]').live('click', function(evt) {
					
					    var e=jomsQuery(this);
					    evt.preventDefault();
					    e.unbind('click');
						var ctrlId = e.attr('id');
		 			    jax.call('community','system,showSupport', ctrlId);
		   			   
				});

				jomsQuery('a[id^=sendSupport]').live('click',function(evt) {
				var e=jomsQuery(this);
			    e.unbind('click');

				    if (functionCount == 0)
					{
				    	// send // 
						// evt.preventDefault();
						var giftId = e.attr('giftId');
						var itemId = e.attr('itemId');
						jax.call('community','system,sendSupport', giftId, itemId);
				 		closeSupport(itemId);
				 		//functionCount++;
				    }

				    return false;
				    
				});

				documentCount++; // bind only once 
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
<!--   ++++ --> <a id="like_id<?php echo $act->id?>" href="#" 	data-actor="<?php echo $act->actor?>" data-placement="top" data-toggle="popover" href="#"><?php echo JText::_('COM_COMMUNITY_LIKE');?></a>
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

