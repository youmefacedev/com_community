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

<script>


function updateWithdrawalStatus(ctrlId, status)
{
	 var message = ""; 
	 if (status == 2)
	 {
		 message = " (approved)";
	 }
	 if (status == 3)
	 {
		 message = " (denied)";
	 }
	 
	 jomsQuery("#statusBox" + ctrlId).html(" " + message);
}

</script>

<div class="cSearch-Result">


	<ul class="cIndexList forFriendsList cResetList">

		<li>Top up credit request</li>

		<?php foreach ($topupRequestResult as $dataRec) 
		{
		 ?>

		<li>
			<div class="cIndex-Box clearfix">

				<?php 
				$avatar = $dataRec->avatar;

				if (!empty($avatar))
				{
					?>
				<a class="cIndex-Avatar cFloat-L"
					href="/joomla/index.php/en/jomsocial/577-google/profile"> <img
					class="cAvatar" alt="google" src="<?php echo $avatar; ?>">
				</a>

				<?php 
				}
				?>

				<div class="cIndex-Content">
					<div class="cIndex-ReportInfo">
						&nbsp; Requestor :
						<?php  echo $dataRec->requestorName; ?>
						<span id="statusBox<?php echo $dataRec->id; ?>"> </span>
					</div>
					<div class="cIndex-ReportInfo">
						&nbsp; Top up point(s) : <b><?php  echo $dataRec->valuePoint; ?> </b> 
					</div>
					<div class="cIndex-ReportInfo">
						&nbsp; Date :
						<?php  echo $dataRec->lastUpdate; ?>
					</div>
					<!--<div class="cIndex-ReportInfo">
						&nbsp;&nbsp;<a
							onclick="jax.call('community','system,approveTopupRequest', <?php echo $dataRec->id; ?>);"
							href="javascript:void(0);" class="cIndex-Avatar "> Approve </a>
						&nbsp;&nbsp; <a
							onclick="jax.call('community','system,cancelTopupRequest', <?php echo $dataRec->id; ?>);"
							href="javascript:void(0);" class="cIndex-Avatar "> Cancel </a>
					</div>-->
				</div>
		
		</li>

		<?php } ?>

	</ul>
	<div class="cPagination" />
</div>
