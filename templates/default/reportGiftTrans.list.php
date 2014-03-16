<?php
defined('_JEXEC') or die();
?>

<style>
#community-wrap li {
	line-height: 20px;
	list-style: none;
}

#community-wrap .cIndex-ReportInfo {
    margin: 5px 0 0;
    padding: 0 0 0px;
}

</style>

<div class="cSearch-Result">


	<ul class="cIndexList forFriendsList cResetList"> 

		<?php foreach ($giftList as $dataRec) 
		{
		 ?>

		<li>
			<div class="cIndex-Box clearfix">

				<?php 
						$avatar = $dataRec->avatar;
				  
				if (!empty($avatar))
				{
					?>
				<a class="cIndex-Avatar cFloat-L" href="/joomla/index.php/en/jomsocial/577-google/profile">
						<img class="cAvatar" alt="google" src="<?php echo $avatar; ?>">
				</a>

				<?php 
				}
				?>
				
				<div class="cIndex-Content">
				
					<?php if (COwnerHelper::isCommunityAdmin($my->id)) {  ?>
						<div class="cIndex-ReportInfo">&nbsp; Source : <?php  echo $dataRec->giftSenderName; ?></div>
					<?php }  ?>
					<div class="cIndex-ReportInfo">&nbsp; Recipient : <?php  echo $dataRec->giftRecipientName; ?></div>
					<div class="cIndex-ReportInfo">&nbsp; Gift Value : <b><?php  echo $dataRec->giftValue; ?> pts</b></div>
					<div class="cIndex-ReportInfo">&nbsp; Date/Time  : <?php  echo $dataRec->lastUpdate; ?></div>
				</div>
				

		</li>

		<?php } ?>

	</ul>
	<div class="cPagination" />
</div>
