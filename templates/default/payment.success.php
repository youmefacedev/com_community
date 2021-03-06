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
	height: 64px;
	width: 64px;
}
</style>


<div id="detailSet" class="section">
	<!-- Profile Detail Setting -->
	<form name="jsform-profile-edit" id="frmSaveDetailProfile"
		action="<?php echo $targetDestinationUrl; ?>" method="POST"
		class="cForm community-form-validate" enctype="multipart/form-data">

		<div class="before-form"></div>

		<ul class="cFormList cFormHorizontal cResetList">

			<li>&nbsp;</li>
						
			<li>
				<div>
					<div>You have successfully top up your credits. Initiating credit
						transfer. </div><div>Please allow 1-2 days for this process to
						complete.</div>	
				
				</div>
			</li>

			<li>&nbsp;</li>
			
			<li><label class="form-label" for="name"></label>
				<div class="form-field">

					<input class="btn" size="30" type="submit" id="save" value="Ok" />

				</div>
			</li>

		</ul>
	</form>
</div>
