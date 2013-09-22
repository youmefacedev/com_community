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
</style>

<div class="cSearch-Result">
<p>
<b>Support Gift</b>
</p>

	<a id="lists" name="listing"/>
		<ul class="cIndexListSupport forFriendsList cResetList"> 
		
		 <?php 
			   $Idx=0; 
			   foreach ($giftList as $dataRec) 
               {	
                   $Idx++;			 
				   if ($Idx == 2) 
				   {
				     $Idx = 0;
				   }
		 ?>
		 
			<li>
			 
			 <?php if ($Idx == 1)
              {
			 ?>
				<div class='tableRow'> 
			  <?php } ?> 
			  <div class='tableColumn'> 
				<div class="cIndex-Box clearfix">
					
					<a href="<?php echo CRoute::getURI();?>/editGift" class="cIndex-Avatar cFloat-L">
						<img class="cAvatar" src="<?php echo JURI::root() . $dataRec->imageURL; ?>" alt="google"/>
					</a>

					<div class="cIndex-Content">
						<h3 class="cIndex-Name cResetH">
							<a href="<?php echo CRoute::getURI();?>/editGift?id=<?php echo $dataRec->id; ?>"><?php echo $dataRec->code; ?></a>
						</h3>
						<div class="cIndex-Status"><span></span><span><?php  echo $dataRec->valuePoint ?> credits</span></div>
						<div class="cIndex-Actions"><a href="<?php echo CRoute::getURI();?>/buySupport?id=<?php echo $dataRec->id; ?>">Buy Now</a></div>
					</div>
				</div>
			   </div>
			
			<?php 
			     if ($Idx == 1) 
                 {				 
			 ?>
			   </div>
			<?php } ?>
		</li>
		
		<?php } ?>
		
		<li> 
		  <div>&nbsp;</div>
		</li>
		<li> 
		  <div>&nbsp;</div>
		</li>
		
		<li> 
		  <div>&nbsp;</div>
		</li>
	</ul>
<div class="cPagination"/>
</div>