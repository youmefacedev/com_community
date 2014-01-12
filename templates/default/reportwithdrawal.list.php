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


<h2>Credit Withdrawal Report</h2>
<div class="cSearch-Result">


	<ul class="cIndexList forFriendsList cResetList">

		<li>Withdrawal List Report</li>

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
					<div class="cIndex-ReportInfo">&nbsp; Withdrawal Amount :  <b> <i> <?php  echo $dataRec->withdrawal_amount; ?></i></b></div>
					<div class="cIndex-ReportInfo">&nbsp; Bank Name : <i> <?php  echo $dataRec->bankName; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Bank Country : <?php  echo $dataRec->bankcountry; ?></div>
					<div class="cIndex-ReportInfo">&nbsp; Account No : <i>  <?php  echo $dataRec->acctnum; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Date  : <i><?php  echo $dataRec->lastUpdate; ?></i></div>
					<div class="cIndex-ReportInfo">&nbsp; Status : <i><?php  echo $dataRec->lastUpdate; ?></i></div>
				</div>
				

		</li>

		<?php } ?>

	</ul>
	<div class="cPagination" />
</div>
