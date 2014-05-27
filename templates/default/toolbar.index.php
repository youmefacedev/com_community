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
$viewName = JRequest::getCmd( 'view');
$taskName = JRequest::getCmd( 'task');
// call the auto refresh on specific page
?>

<?php if($showToolbar) : ?>

<style type="text/css">
	/*@TEMPORARY*/
	#community-wrap .row-fluid [class*="span"] {
		float: left;
	}
</style>

<div class="navbar js-toolbar">
  <div class="navbar-inner">
      <a class="btn btn-navbar js-bar-collapse-btn">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      	<ul class="nav hidden-desktop">
        	<li <?php echo $active == 0 ? ' class="active"' :'';?> ><a href="<?php echo CRoute::_( 'index.php?option=com_community&view=frontpage' );?>">
        		<i class="js-icon-home"></i></a>
					</li>
					<li>
						<a href="javascript:joms.notifications.showWindow();" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_GLOBAL' );?>">
							<i class="js-icon-globe"></i>
							<?php if( $newEventInviteCount ) { ?>
							<span class="js-counter"><?php echo $newEventInviteCount; ?></span>
							<?php } ?>
						</a>
					</li>

					<li>
						<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=friends&task=pending' );?>" onclick="joms.notifications.showRequest();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INVITE_FRIENDS' );?>">
							<i class="js-icon-users"></i>
							<?php if( $newFriendInviteCount ){ ?><span class="js-counter"><?php echo $newFriendInviteCount; ?></span><?php } ?>
						</a>
					</li>

					<li>
						<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=inbox' );?>"  onclick="joms.notifications.showInbox();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INBOX' );?>">
							<i class="js-icon-chat"></i>
							<?php if( $newMessageCount ){ ?><span class="js-counter"><?php echo $newMessageCount; ?></span><?php } ?>
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" title="<?php echo JText::_('COM_COMMUNITY_LOGOUT'); ?>" onclick="document.communitylogout2.submit();">
							Logout <i class="js-icon-logout"></i>
						</a>
					<form class="cForm" action="<?php echo JRoute::_('index.php');?>" method="post" name="communitylogout2" id="communitylogout2">
						<input type="hidden" name="option" value="<?php echo COM_USER_NAME ; ?>" />
						<input type="hidden" name="task" value="<?php echo COM_USER_TAKS_LOGOUT ; ?>" />
						<input type="hidden" name="return" value="<?php echo $logoutLink; ?>" />
						<?php echo JHtml::_('form.token'); ?>
					</form>
					</li>
				</ul>

      <div class="nav-collapse collapse js-bar-collapse">
        <ul class="nav">
        	<li class="<?php echo $active == 0 ? 'active' :'';?> visible-desktop" ><a href="<?php echo CRoute::_( 'index.php?option=com_community&view=frontpage' );?>">
        		<i class="js-icon-home"></i></a>
					</li>

					<?php
				    $adminUser = COwnerHelper::isCommunityAdmin($my->id);
					
					foreach( $menus as $menu ) {

					$dropdown	= !empty( $menu->childs ) ? 'dropdown' : '';
					$toggle = !empty( $menu->childs ) ? 'class="dropdown-toggle"' : '';
					$mainmenuitem = $menu->item->name;
					$show = true;
					if($adminUser && $mainmenuitem=="Like"){ 
					   $show = false;
					}
					
					if($show == true) {
					?>
                       
					<li class="<?php echo $active === $menu->item->id ? 'active' : '';?> <?php echo (isset($menu->item->css)) ? $menu->item->css : '' ; ?> <?php echo $dropdown; ?>" >
						<a href="<?php echo CRoute::_( $menu->item->link );?>" <?php echo $toggle; ?> ><?php echo JText::_( $menu->item->name );?></a>
						<?php if( !empty($menu->childs) ) { ?>
						<ul class="dropdown-menu">
						<?php
						foreach( $menu->childs as $child ) { ?>
                                                    <li class="<?php echo (isset($child->css)) ? $child->css : ''; ?>">
								<?php if( $child->script ){ ?>
									<a href="javascript:void(0);" onclick="<?php echo $child->link;?>">
								<?php } else { ?>
									<a href="<?php echo CRoute::_( $child->link );?>">
								<?php } ?>
								<?php echo JText::_( $child->name );?></a>
								</li>
								<?php } ?>
						</ul>
						<?php } ?>
					</li>

					<?php
						}}
					?>

					<li class="visible-desktop" >
						<a class="menu-icon" href="javascript:joms.notifications.showWindow();" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_GLOBAL' );?>">
							<i class="js-icon-globe"></i>
							<?php if( $newEventInviteCount ) { ?>
							<span class="js-counter"><?php echo $newEventInviteCount; ?></span>
							<?php } ?>
						</a>
					</li>

					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=friends&task=pending' );?>" onclick="joms.notifications.showRequest();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INVITE_FRIENDS' );?>">
							<i class="js-icon-users"></i>
							<?php if( $newFriendInviteCount ){ ?><span class="js-counter"><?php echo $newFriendInviteCount; ?></span><?php } ?>
						</a>
					</li>

					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=inbox' );?>"  onclick="joms.notifications.showInbox();return false;" title="<?php echo JText::_( 'COM_COMMUNITY_NOTIFICATIONS_INBOX' );?>">
							<i class="js-icon-chat"></i>
							<?php if( $newMessageCount ){ ?><span class="js-counter"><?php echo $newMessageCount; ?></span><?php } ?>
						</a>
					</li>
					<!--<li class="visible-desktop" style="padding-top:5px">
					  Report:
					</li>-->
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=reportgifttrans' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_VIEW_GIFT_REPORT' );?>">
							<i class="icon-thumbs-up"></i>
						</a>
					</li>
					
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=reporttopup' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_VIEW_TOPUP_REPORT' );?>">
							<i class="icon-plus-circle"></i>
						</a>
					</li>
					
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=reportwithdrawal' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_VIEW_WITHDRAWAL_REPORT' );?>">
							<i class="icon-minus-circle"></i>
						</a>
					</li>
					
					<?php 
						if(!$adminUser ){ ?> 
						
						<?php if( $balancePoint ){ ?>
						<li class="visible-desktop" >
								<i class="icon-gift"></i><span id="balancePoints" class="js-counter"><?php echo $balancePoint; ?> pts</span>
						</li>
						<?php } else { ?>
						<li class="visible-desktop" >
								<i class="icon-gift"></i><span id="balancePoints" class="js-counter">0 pts</span>
						</li>
						<?php } ?>
					
					<?php } ?>
					
					<?php if( $withdrawalPoint ){ ?>
					<li class="visible-desktop" >
							<span class="js-counter"><?php echo $withdrawalPoint; ?></span>
					</li>
					<?php } ?>
					
					
					<?php 
						//$adminUser = COwnerHelper::isCommunityAdmin($my->id);
						if( $adminUser ){ ?>
						
					
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=withdrawals' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_WITHDRAWALS' );?>">
							<i class="icon-ok"></i> 
						</a>
					</li>
					
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=viewmember' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_WITHDRAWALS' );?>">
							<i class="icon-users"></i> 
						</a>
					</li>
					
					
					<!--<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=approvetopup' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_APPROVETOPUP' );?>">
							<i class="icon-download"></i>
						</a>
					</li>-->
					
					<li class="visible-desktop" >
						<a class="menu-icon" href="<?php echo CRoute::_( 'index.php?option=com_community&view=configureGift' );?>" title="<?php echo JText::_( 'COM_COMMUNITY_CONFIGUREGIFT' );?>">
							<i class=" icon-cog-1"></i>
						</a>
					</li>
					
					
					<?php } ?>
					
					

        </ul>
        <ul class="nav pull-right">
					<li class="visible-desktop" >
						<a href="javascript:void(0);" title="<?php echo JText::_('COM_COMMUNITY_LOGOUT'); ?>" onclick="document.communitylogout.submit();">
							Logout <i class="js-icon-logout"></i>
						</a>
					<form class="cForm" action="<?php echo JRoute::_('index.php');?>" method="post" name="communitylogout" id="communitylogout">
						<input type="hidden" name="option" value="<?php echo COM_USER_NAME ; ?>" />
						<input type="hidden" name="task" value="<?php echo COM_USER_TAKS_LOGOUT ; ?>" />
						<input type="hidden" name="return" value="<?php echo $logoutLink; ?>" />
						<?php echo JHtml::_('form.token'); ?>
					</form>
					</li>
        </ul>
      </div><!-- /.nav-collapse -->
  </div><!-- /navbar-inner -->
</div>

<?php endif; ?>

<?php if ( $miniheader ) : ?>
	<?php echo @$miniheader; ?>
<?php endif; ?>

<?php if ( !empty( $groupMiniHeader ) ) : ?>
	<?php echo $groupMiniHeader; ?>
<?php endif; ?>


<script>

		joms.jQuery(function() {

		var $collapsible = joms.jQuery('#js-collapse');

		$collapsible.collapse({
	        toggle: false
	    });

	    joms.jQuery('#js-collapse-btn').on('click', 
	        function(){
	            $collapsible.collapse('toggle');
	        }
	    );
	});

	function refreshUserPoint(userValuePoint)
	{
		
		jomsQuery("#balancePoints").html(userValuePoint + "pts");
	}


	
</script>
