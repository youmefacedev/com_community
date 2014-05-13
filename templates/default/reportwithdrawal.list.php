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

.highlightMode 
{
	color : #245DC1;
}

</style>


 
<div class="cSearch-Result">


	<ul class="cIndexList forFriendsList cResetList">

		<li><span style="float:right"> Total value : $<?php echo $totalValue; ?> </span></li> 

		<?php foreach ($giftList as $dataRec) 
		{
		 ?>

		<li>
			<div class="cIndex-Box clearfix">

				<?php $avatar = $dataRec->avatar;
				  
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
					<div class="cIndex-ReportInfo">&nbsp; User : <i> <?php  echo $dataRec->name; ?> </i></div>
					<div class="cIndex-ReportInfo">&nbsp; Withdrawal Amount :  <b> <i> <?php  echo $dataRec->withdrawal_amount; ?> pts</i></b></div>
					<div class="cIndex-ReportInfo">&nbsp; Bank Name : <i> <?php  echo $dataRec->bankName; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Bank Country : <?php  echo $dataRec->bankcountry; ?></div>
					<div class="cIndex-ReportInfo">&nbsp; Account No : <i>  <?php  echo $dataRec->acctnum; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Date/Time  : <i><?php  echo $dataRec->lastUpdate; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Status : <i class='highlightMode'><?php  echo $dataRec->status; ?></i></div>
				</div>
				

		</li>

		<?php } ?>

	</ul>
	<div class="cPagination" />
</div>
