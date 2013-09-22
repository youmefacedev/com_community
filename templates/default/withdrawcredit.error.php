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

<style>

.cAvatar {
  height:64px;
  width:64px;
}

</style>


<div id="detailSet" class="section"> <!-- Profile Detail Setting -->
				<form name="jsform-profile-edit" id="frmSaveDetailProfile" action="<?php echo $coreUrl; ?>" method="POST" class="cForm community-form-validate" enctype="multipart/form-data">
					
					<div class="before-form">
						
					</div>
				
					<ul class="cFormList cFormHorizontal cResetList">
						
						<!-- gift code -->
						<li>
							<label class="form-label" for="name">Current Credit(s) </label>
							<div class="form-field">
								<span><?php echo (!empty($balancePoint) ? $balancePoint : JText::_('COM_COMMUNITY_NO_CREDIT_AVAILABLE')); ?> <span/>
							</div>
						</li>
						
						<!--  giftdescription -->
						<li>
							<label class="form-label" for="name">Withdrawn Credit(s)</label>
							<div class="form-field">
								<span><?php echo (!empty($withdrawalPoint) ? $withdrawalPoint : JText::_('COM_COMMUNITY_NO_CREDIT_WITHDRAWN')); ?> <span/>
							</div>
						</li>
						
						
						<!--  giftvaluepoint -->
						<li>
							<label class="form-label" for="name">Withdraw Balance</label>
							<div class="form-field">
								<input class="input text" type="text" id="withdrawValue" name="withdrawValue" size="40" value="<?php echo (!empty($giftRecord->valuePoint) ? $giftRecord->valuePoint : ''); ?>" />
							</div>
						</li>
						
						<!--  button -->
						<li>
							<label class="form-label" for="name"></label>
							<div class="form-field">
							 
								<input class="btn" size="30" type="submit" id="save" value="Save"/>&nbsp;<input class="btn" size="30" type="button" id="cancel" onclick="history.go(-1);return false;" value="Cancel"/>
							
							</div>
						</li>
						
					</ul>
					</form>
</div>
			