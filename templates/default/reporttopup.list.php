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

		<li>
		
				<?php if (COwnerHelper::isCommunityAdmin($my->id)) {  ?>
							Admin View			
					<?php }  ?>
		
		  <span style="float:right"> Total value : <b>$<?php echo $totalValue; ?></b> </span>
		
		</li>

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
				<a class="cIndex-Avatar cFloat-L">
						<img class="cAvatar" alt="google" src="<?php echo $avatar; ?>">
				</a>

				<?php 
				}
				?>
				
				<div class="cIndex-Content">
				
					<?php if (COwnerHelper::isCommunityAdmin($my->id)) {  ?>
					
					<?php }  ?>
					<div class="cIndex-ReportInfo">&nbsp; User : <i> <?php  echo $dataRec->name; ?> </i></div>
					<div class="cIndex-ReportInfo">&nbsp; Topup Value: <i> <b><?php  echo $dataRec->valuePoint; ?> pts</b> </i></div>
					<div class="cIndex-ReportInfo">&nbsp; Date/Time  : <?php  echo $dataRec->lastUpdate; ?></div>
				</div>
				

		</li>

		<?php } ?>

	</ul>
	<div class="cPagination" />
</div>
