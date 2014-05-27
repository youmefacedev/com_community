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

.highlightMode {
	color: #245DC1;
}

.divTable {
	display: table;
	width: 100%;
	background-color: #eee;
	border: 1px solid #666666;
	border-spacing: 5px; /*cellspacing:poor IE support for  this*/
	/* border-collapse:separate;*/
}

.divRow {
	display: table-row;
	width: auto;
}

.divRowHeader {
	display: table-row;
	width: auto;
	height : 30px;
}

.divCell {
	float: left; /*fix for  buggy browsers*/
	display: table-column;
	width: 160px;
	text-align: left;
}

.divCellCenter {
	float: left; /*fix for  buggy browsers*/
	display: table-column;
	width: 160px;
	text-align: center;
}

.divCellHeader {
	float: left; /*fix for  buggy browsers*/
	display: table-column;
	width: 160px;
	text-align: center;
}

.divCellLastSeen {
	float: left; /*fix for  buggy browsers*/
	display: table-column;
	width: 160px;
	text-align: center;
}
</style>


<div class="cSearch-Result">

	<ul class="cIndexList forFriendsList cResetList">

		<li><span style="float: right"> </span></li>

		<div class="divTable">

			<div class="divRowHeader">
				<div class="divCellHeader">Avatar</div>
				<div class="divCell">Username</div>
				<div class="divCellHeader">Email</div>
				<div class="divCellHeader">Current Points</div>
				<!--   <div class=".divCellLastSeen"> Last seen 
					</div> -->
			</div>



			<?php foreach ($memberList as $dataRec) 
			{
				?>


			<div class="headRow">

				<div class="cIndex-Box clearfix">

					<div class="divCell">

						<?php $avatar = $dataRec->avatar;
							
						if (!empty($avatar))
						{
							?>

						<a class="cIndex-Avatar cFloat-L"> <img class="cAvatar"
							alt="google" src="<?php echo $avatar; ?>">
						</a>

						<?php 
						}
						?>

					</div>

					<div class="divCell">
						<i> <?php  echo $dataRec->name; ?>
						</i>
					</div>
					<div class="divCell">
						<i> <?php  echo $dataRec->email; ?>
						</i>
					</div>
					<div class="divCellCenter">
						<i> <b><?php  echo $dataRec->userPoints; ?> pts</b>
						</i>
					</div>

					<!-- 
					<div class=".divCellLastSeen">
						<i><?php  echo $dataRec->lastvisitDate; ?> </i>
					</div>  -->

				</div>
			</div>

			<?php } ?>

		</div>

	</ul>
	<div class="cPagination" />
</div>
