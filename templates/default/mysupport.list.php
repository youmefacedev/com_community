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
  line-height:20px;
  list-style:none;
  
  }
  	
  .timeStamping {
    font-size: 10px;
  }

</style>

<div class="cSearch-ResultTopless">
<h4>
<b>Who Like Me</b>
</h4>

	<div id="lists" name="listing"/>
		<ul class="cIndexList forFriendsList cResetList"> 
			<li>
				Total gift point(s) : <b><?php echo (!empty($totalGiftValue) ? $totalGiftValue : ""); ?> pts</b>
			</li>
			
			<li>&nbsp;</li>
		
		 <?php foreach ($supportList as $dataRec) 
               {		 
		 ?>
		 
			<li>
				<div class="cIndex-Box clearfix">
				
				
					<div href="#" class="cIndex-Avatar cFloat-L">
					
					<?php 
						
					  $avatar = $dataRec['avatar'];
					  
					  	if (!empty($avatar))
					  	{	
					 ?>
					 	<img class="cAvatar" src="<?php echo $avatar; ?>"/>
					 
					 <?php 
					  	}
					 ?>
					 
					</div>

					<div class="cIndex-Content">
						<div class="cIndex-Support">
							<span> <?php echo $dataRec['supportName']; ?> </span>
						</div>
						<div class="cIndex-Support">Gift value : <span></span><span> <?php echo (!empty($dataRec['giftValue']) ? $dataRec['giftValue'] : ""); ?> pts</span> 
						&nbsp; <i class="timeStamping"> <?php echo (!empty($dataRec['lastUpdate']) ? "(" . date("F j, Y", strtotime($dataRec['lastUpdate'])) . ")" : ""); ?></i> </div>
						
					</div>
				</div>
			
		</li>
		
		<?php } ?>
		
	</ul>
<div class="cPagination"/>
</div>