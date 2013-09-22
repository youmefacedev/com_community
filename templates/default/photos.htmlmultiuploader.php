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

<?php if ($disableUpload) { ?>
<div style="width:100%;text-align:center;height:2em;"><?php echo $preMessage;?></div>
<?php } else { ?>
<link rel="stylesheet" href="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/browserplus-min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.gears.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.silverlight.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.browserplus.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo JURI::root();?>components/com_community/assets/multiupload_js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script type="text/javascript">
joms.jQuery('#clear').click(function(e) {
	e.preventDefault();
	joms.jQuery("#uploader").pluploadQueue().splice();
});

joms.jQuery(document).ready(function() {
	// Hide Create/Select Album, Add Files and Start Upload if Needs disable
	// e.g. when limit is reached
	var uploadMsg = {
		defaultMsg: '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_DEFAULT_UPLOAD_NOTICE')); ?>',
		groupEmptyValidateMsg : '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_ENTER_ALBUM_NAME')); ?>',
		uploadingCreateMsg: '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_UPLOADING_TO_CREATED_ALBUM')); ?>',
		uploadingSelectMsg: '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_UPLOADING_TO_SELECTED_ALBUM')); ?>',
		uploadedCompleteMsg: '<?php echo addslashes(JText::_('COM_COMMUNITY_PHOTOS_UPLOADED_COMPLETE_TO_ALBUM'));?>',
		maxFileSize:'<?php echo $maxFileSize;?>'
	};
	joms.photos.multiUpload._init('<?php echo $groupId; ?>', uploadMsg);

	joms.photos.multiUpload.defaultUploadUrl = '<?php echo CRoute::_('index.php?option=com_community&view=photos&task=multiUpload', false);?>';

	// Remove all tooptips
	joms.jQuery('#multi_uploader [title]').removeAttr('title');
	joms.jQuery('.plupload_header').remove();

	// Switch class for customized manipulation
	joms.jQuery('.plupload_buttons').addClass('custom_plupload_buttons');
	joms.jQuery('.custom_plupload_buttons').removeClass('plupload_buttons');
	joms.jQuery(".plupload_upload_status").addClass('custom_plupload_status');
	joms.jQuery(".custom_plupload_status").removeClass('plupload_upload_status');

	joms.photos.multiUpload.assignUploadUrl( joms.photos.multiUpload.getSelectedAlbumId() );

	<?php if(count($allAlbums)<1){ ?>
	joms.jQuery("#optional-album").hide();
	<?php } ?>

	<?php if(intval($selectedAlbum)!=0){ ?>
	joms.jQuery("#new-album").hide();
	joms.jQuery("#newalbum").hide();
	joms.jQuery("#select-album").css('display','inline');
	joms.jQuery("#albumid").val('<?php echo $selectedAlbum; ?>');
	<?php } ?>

	joms.jQuery('#albumid').change(function() {
		joms.photos.multiUpload.assignUploadUrl(joms.jQuery(this).val());
	});

	joms.jQuery('#album-name').keydown(function (e){

	    if(pluploader.pluploadQueue().files.length>0){
		joms.jQuery('.plupload_start').removeClass('plupload_disabled');
	    }

	});

	joms.jQuery('a.add-more').click(function() {
		joms.jQuery("#multi_uploader").pluploadQueue().splice();
		joms.jQuery(".custom_plupload_buttons").show();
		joms.jQuery(".custom_plupload_status").hide();
		joms.jQuery('div#upload-footer').hide();
		joms.jQuery("#optional-album").css('display','inline');
		joms.photos.multiUpload.displayNotice(joms.photos.multiUpload.defaultMsg);
		joms.photos.multiUpload.hideShowInput();
	});

	joms.jQuery('a#album_link').click(function() {
		jax.call('community' , 'photos,ajaxGetAlbumURL' , joms.photos.multiUpload.getSelectedAlbumId(), '<?php echo $groupId; ?>' );
		return false;
	});
});
</script>

<div id="photo-uploader" style="overflow:hidden;">
	<div id="upload-header" class="clrfix">
	    <label><span id="newalbum"><?php echo JText::_('COM_COMMUNITY_PHOTOS_NEW'); ?> </span><?php echo JText::_('COM_COMMUNITY_PHOTOS_ALBUM_NAME'); ?></label>
	    <div id="new-album" style="display:inline;">
	    	<input type="text" id="album-name" style="width: 200px" />
    		<div id="optional-album" style="display:inline">
    			<?php echo JText::_('COM_COMMUNITY_OR'); ?>
    			<a href="javascript:joms.photos.multiUpload.showExistingAlbum();"><?php echo JText::_('COM_COMMUNITY_PHOTOS_ADD_TO_EXISTING_ALBUM'); ?></a>
    		</div>
    	</div>
	    <div id="select-album" style="display:none;">
	    <ul class="unstyled inline">
	    	<li>
	    		<select id="albumid" name="albumid" class="reset-gap" >
	    		<?php foreach ($allAlbums as $index => $objAlbumProp) { ?>
						<option value="<?php echo $objAlbumProp->id;?>"><?php echo $objAlbumProp->name;?></option>
					<?php } ?>
					</select>
				</li>
				<li><?php echo JText::_('COM_COMMUNITY_OR'); ?></li>
	    	<li>
	    		<a class="btn btn-primary" href="javascript:joms.photos.multiUpload.createNewAlbum();"><?php echo strtolower(JText::_('COM_COMMUNITY_PHOTOS_CREATE_NEW_ALBUM_TITLE')); ?></a>
				</li>
	    </ul>

					</div>
    </div>
	<?php if (intval($groupId) === 0): ?>
	<!--#upload-header-->
	<div id="photoUploaderNotice" class="cAlert" style="margin: 0"><?php echo $preMessage;?></div>
	<?php endif; ?>

    <div id="upload-content" class="clrfix">
    	<div id="multi_uploader"></div>
    </div><!--#upload-content-->

	<div id="upload-footer" style="display:none" style="margin-top: 10px">
		<a class="btn add-more" href="javascript: void(0); "><?php echo JText::_('COM_COMMUNITY_PHOTOS_ADD_MORE_PHOTOS'); ?></a>
		<a class="btn btn-primary" href="javascript: void(0);" id="album_link"><?php echo JText::_('COM_COMMUNITY_UPLOAD_VIEW_ALBUM'); ?></a>
		<div id="photoUploadedCounter"></div>
	</div><!--#upload-footer-->
</div><!--#photo-uploader-->
<?php } ?>