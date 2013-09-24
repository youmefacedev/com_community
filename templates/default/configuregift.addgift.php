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

<script type="text/javascript">

	
	jomsQuery(document).ready(function() {
		
		jomsQuery('#giftvaluepoint').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
	});

</script>



<div id="detailSet" class="section"> <!-- Profile Detail Setting -->
				<form name="jsform-profile-edit" id="frmSaveDetailProfile" action="<?php echo $coreUrl; ?>" method="POST" class="cForm community-form-validate" enctype="multipart/form-data">
					
					<div class="before-form">
						
					</div>
				
					<ul class="cFormList cFormHorizontal cResetList">
						
						<!-- gift code -->
						<li>
							<label class="form-label" for="name">Code </label>
							<div class="form-field">
								<input class="input text" type="text" id="giftcode" name="giftcode" size="40" value='<?php echo (!empty($giftRecord->code) ? $giftRecord->code : ''); ?>' />
								
							</div>
						</li>
						
						<!--  giftdescription -->
						<li>
							<label class="form-label" for="name">Description</label>
							<div class="form-field">
								<input class="input text" type="text" id="giftdescription" name="giftdescription" size="40" value="<?php echo (!empty($giftRecord->description) ? $giftRecord->description : ''); ?>" />
							</div>
						</li>
						
						
						<!--  giftvaluepoint -->
						<li>
							<label class="form-label" for="name">Value Point</label>
							<div class="form-field">
								<input class="input text" type="text" id="giftvaluepoint" name="giftvaluepoint" size="40" value="<?php echo (!empty($giftRecord->valuePoint) ? $giftRecord->valuePoint : ''); ?>" />
							</div>
						</li>
						
						<!--  giftphoto -->
						<li>
						
							<label class="form-label" for="name">Photo</label>
							<div class="form-field">
								<input type="file" id="file-upload" name="Filedata" />
								<!--  <input class="btn" size="30" type="submit" id="file-upload-submit" value="<?php echo JText::_('COM_COMMUNITY_BUTTON_UPLOAD_PICTURE'); ?>">  -->
							</div>
						
						</li>
						
						<?php  if (!empty($giftRecord->imageURL)) {  ?> 
						
						<li>
						
							<label class="form-label" for="name"></label>
							<div class="form-field">
							<img class="cAvatar" src="<?php echo JURI::root() . $giftRecord->imageURL; ?>" alt="google">
							<input class="input text" type="hidden" id="filePart" name="filePart"  value='<?php echo (!empty($giftRecord->imageURL) ? $giftRecord->imageURL : ''); ?>' />	
							</div>
						
						</li>
						
						
						<?php } ?>
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
			