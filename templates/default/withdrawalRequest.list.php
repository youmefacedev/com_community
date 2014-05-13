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
#community-wrap li {
	line-height: 20px;
	list-style: none;
}

.withdrawContent {
	margin: 0 0 0 6px;
	min-height: 64px;
	position: relative;
}

.cIndex-Status span.detailsInfo {
	font-size: 12px;
}


</style>


<script type = 'text/javascript'>

function confirmApproval(action,id)
{ 
	 var cmt = confirm('Are you sure you want to '+action+' this withdrawal?');
	 if(cmt)
	 {
	    if(action=="approve")
		   jax.call('community','system,approveWithdrawal', id);
		else
		   jax.call('community','system,denyWithdrawal', id);
		//window.open('withdrawals?wstatus=1','_self');
	 }
	 else
	 {
		return false;
	 }
}
 
 function updateWithdrawalStatus(ctrlId, status)
 {
	 /*var message = ""; 
	
	 if (status == 2)	
	 {
		 message = " (approved)";
	 }
	 
	 if (status == -1)
	 {
		 message = " (denied)";
		 jomsQuery("#infoStatusBox" + ctrlId).html(" (denied)");
	 }

	 if (status == 3)
	 {
		 message = " (approved)";
		 jomsQuery("#approveControlContainer" + ctrlId).remove();
		 jomsQuery("#denyControlContainer" + ctrlId).remove();
		 jomsQuery("#moneyInBankControl" + ctrlId).remove();
		 jomsQuery("#infoStatusBox" + ctrlId).html(" (approved)");
	 }

	 jomsQuery("#statusBox" + ctrlId).html(" " + message);*/
	 window.open('withdrawals?wstatus=1','_self');
 }

 function getStatus(status)
 {
 	switch (status)
 	{
 		case "-1":
 	 		return " denied";
	 	 	break;
 		case "1": 
 	 		return " pending";
 	 		break;
 		case "3": 
			return " approved";
 	 		break;
 	}	
 }
 
 function updateViewWithFilterResult(result)
 {
	var output = "";

	for (var i=0; i < result.length; i++)
	 { 
		 output += "<li>";
		 output += '<div class="cIndex-Box clearfix">';
		 output += '<div class="withdrawContent">';
		 output += '<h3 class="cIndex-Name cResetH">';
		 output += '<a href="javascript:void(0);">'  +  result[i].username + '</a>';
		 output += '</h3>';

		 output += '<div class="cIndex-Status">';
		 output += 'requested withdrawal of :' + result[i].withdrawal_amount ;
		 output += '<span id="statusBox' + result[i].id +  '"></span>';
		 output += '<div id="showDetail' + result[i].id  + '">';
		 output += '<div class="panel-	heading">';
		 output += '<h4 class="panel-title">';
		 
		 output += '</h4>';
		 output += '</div>';
		 output += '<div id="collapseOne"	>';
		 output += '<div class="panel-body">';
		 output += '<ul>';
		 output += '<li>Account no : ' + result[i].acctnum;
		 output += '</li>';
		 output += '<li>Name : ' + result[i].name;
		 output += '</li>';
		 output += '<li>Bank Name : ' + result[i].bankName;
		 output += '</li>';
		 output += '<li>Bank Country : '+ result[i].bankCountry;
		 output += '</li>';
		 output += '<li>Meps Routing ' + result[i].mepsRouting;
		 output += '</li>';
		 output += '<li>Date/Time ' + result[i].lastUpdate;
		 output += '</li>';
		 output += '<li>Status :' +  '<span id="infoStatusBox' + result[i].id + '">' + getStatus(result[i].status) + '</span>';
		 output += '</li>';
		 output += '<li>&nbsp;</li>';
		 output += '</ul>';
		 output += '</div>';
		 output += '</div>';
		 output += '</div>';
		 output += '</div>';
		 output += '<div class="cIndex-Actions">';
 
		 if (result[i].status == 1)
		 {
			 output += '<div id="approveControlContainer' + result[i].id +  '">';
			 output += '<a id="approveControl' + result[i].id + '"';
			 output += 'href="javascript:void(0);"';
			 output += 'onclick="jax.call(&#39;community&#39;,&#39;system,approveWithdrawal&#39;,' + result[i].id + ');"><i';
			 output += ' class="icon-ok-2"></i> Approved </a>';
			 output += '</div>';
			 
			 output += '<div id="denyControlContainer' + result[i].id + '">';
			 output += '<a id="denyControl' + result[i].id + '"';
			 output += 'href="javascript:void(0);"';
			 output += 'onclick="jax.call(&#39;community&#39;,&#39;system,denyWithdrawal&#39;,' + result[i].id  +  ');"><span><i';
			 output += ' class="icon-cancel-2"></i> Deny withdrawal</span> </a>';
			 output += '</div>';
		 }

		 if (result[i].status == -1)
		 {
			 output += '<div id="deniedControlContainer' + result[i].id +  '">';
			// output += '<a id="approveControl' + result[i].id + '"';
			// output += 'href="javascript:void(0);"';
			// output += 'onclick="jax.call(&#39;community&#39;,&#39;system,approveWithdrawal&#39;,' + result[i].id + ');"><i';
			 //output += ' class="icon-ok-2"></i> Approved </a>';
			 output += '</div>';
		 }

		 
		 output += '</div>';
		 output += '</div>';
		 output += '</div>';
		 output += "</li>";
	 }

	 jomsQuery('#resultWindow').html(output);
 }
 
 jomsQuery(document).ready(function()
 { 	
	 var alinkPatter = "showDetail"; 
	 jomsQuery('.collapse').collapse("hide");
 });   

	    
 
</script>
<?php 
$wstatus = 1;
if ($_REQUEST["wstatus"] != "") {  
   $wstatus = $_REQUEST["wstatus"];
}
?>
<div class="cSearch-ResultTopless">
	<p>
		<b>Withdrawal request </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filter by : <span>
		
		<!--<a href="javascript:void(0);"
			onclick="jax.call('community','system,filterRequest');">Requested</a>
		</span> <span> | <a href="javascript:void(0);"
			onclick="jax.call('community','system,filterApproved');">Approved</a> </span>
			<span> |
		<a href="javascript:void(0);"
			onclick="jax.call('community','system,filterDenied');">Denied</a> </span>-->
		<a href="javascript:void(0);"
			onclick="window.open('index.php/withdrawals?wstatus=1','_self');">
			<?php if ($wstatus == 1) { ?>
			  <b>Requested</b>
			<?php } else { ?>
			   Requested
			<?php } ?>
		</a>
		</span> <span> | <a href="javascript:void(0);"
			onclick="window.open('index.php/withdrawals?wstatus=3','_self');">
			<?php if ($wstatus == 3) { ?>
			  <b>Approved</b>
			<?php } else { ?>
			   Approved
			<?php } ?>
			</a> </span>
			<span> |
		<a href="javascript:void(0);"
			onclick="window.open('index.php/withdrawals?wstatus=-1','_self');">
			<?php if ($wstatus == -1) { ?>
			  <b>Denied</b>
			<?php } else { ?>
			   Denied
			<?php } ?>
			</a>
	</p>

	
	<ul class="cIndexList forFriendsList cResetList" id="resultWindow">

		<?php foreach ($requestList as $element) {  ?>
		<li>

			<div class="cIndex-Box clearfix">
				<div class="withdrawContent">
					<h3 class="cIndex-Name cResetH">
						<a href="javascript:void(0);" style="cursor:none"> <?php 
						$user = CFactory::getUser($element->userId);
						echo (!empty($user->username) ? $user->username : ''); ?>
						</a>
					</h3>
					<div class="cIndex-Status">
						requested withdrawal of :
						<?php echo $element->withdrawal_amount; ?>
						<span id="statusBox<?php echo $element->id; ?>"></span>


						<div id="showDetail<?php echo $element->id; ?>">
							 <div class="panel-	heading">
								<h4 class="panel-title">
									
								</h4>
							</div> 
						  <div id="collapseOne"> 
								<div class="panel-body">
									<ul>
										<li>Account no : <?php echo $element->acctnum; ?>
										</li>
										<li>Name : <?php echo $element->name; ?>
										</li>
										<li>Bank Name : <?php echo $element->bankName; ?>
										</li>
										<li>Bank Country : <?php echo $element->bankCountry; ?>
										</li>
										<li>Meps Routing :  <?php echo $element->mepsRouting; ?>
										</li>
					                    <li>Date/Time  :  <?php  echo $element->lastUpdate; ?></i> 
										<li>Status  :  <span id="infoStatusBox<?php echo $element->id; ?>"><?php  
										
										switch ($element->status)
										{
											case 1: 
												echo " Pending.";
												break;
											case 3: 
												echo " Approved.";
												break; 
											case -1: 
												echo " Denied.";
												break;
										}
										
										?> </span></i> 
										<li>&nbsp;</li>
										
									</ul>
								</div>
							 </div> 
						</div>



					</div>

					<div class="cIndex-Actions">

						<?php 
							
						if ($element->status == 1)
						{
							?>
						<div id="approveControlContainer<?php echo $element->id; ?>">
							<a id="approveControl<?php echo $element->id; ?>"
								href="javascript:void(0);"
								onclick="confirmApproval('approve',<?php echo $element->id; ?>);"><i
								class="icon-ok-2"></i> Approved </a>
						</div>

						<div id="denyControlContainer<?php echo $element->id; ?>">
							<a id="denyControl<?php echo $element->id; ?>"
								href="javascript:void(0);"
								onclick="confirmApproval('deny',<?php echo $element->id; ?>);"><span><i
									class='icon-cancel-2'></i> Deny withdrawal</span> </a>
						</div>

						<!--<div>
							<a id="moneyInBankControl<?php echo $element->id; ?>"
								href="javascript:void(0);"
								onclick="jax.call('community','system,moneyInBank',<?php echo $element->id; ?>);"><span><i
									class='icon-dollar'></i> Money In Bank</span> </a>
						</div>-->

						<?php } ?>


					</div>
				</div>
			</div>

		</li>

		<?php }  ?>


	</ul>
	<div class="cPagination" />
</div>
