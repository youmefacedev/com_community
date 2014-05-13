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
						$recipientavatar = $dataRec->recipientavatar;
				  
				if (!empty($avatar))
				{
					?>
				<div class="cFloat-L" style="height:75px; width:65px" >
						<img class="cAvatar" alt="google" src="<?php echo $avatar; ?>">
				</div>
				<div  class="cFloat-L" style="padding-top:20px">
				<img  height="25px" width="25px" src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQvu9IJavBCsKyXSh3RpT6CGC7WBakeICRHyu5xUzku7th4Pf-a">
				 </div>
				<div class="cFloat-L" style="height:75px; width:65px" >
						<img class="cAvatar" alt="google" src="<?php echo $recipientavatar; ?>">
				</div>

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
