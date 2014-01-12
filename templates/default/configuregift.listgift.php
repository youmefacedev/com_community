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
<b>Gifts currently configured within the system.</b>
</p>

	<a id="lists" name="listing"/>
		<ul class="cIndexList forFriendsList cResetList"> 
		
		<li>
			<a href="<?php echo CRoute::getURI(); ?>/addGift">Add gift</a>
		</li>
		
		 <?php foreach ($giftList as $dataRec) 
               {		 
		 ?>
		 
			<li>
				<div class="cIndex-Box clearfix">
					<!-- Miki 5Jan2014, added id into the url of image -->
					<a href="<?php echo CRoute::getURI();?>/editGift?id=<?php echo $dataRec->id; ?>" class="cIndex-Avatar cFloat-L">
						<img class="cAvatar" src="<?php echo JURI::root() . $dataRec->imageURL; ?>" alt="google"/>
					</a>

					<div class="cIndex-Content">
						<h3 class="cIndex-Name cResetH">
							<a href="<?php echo CRoute::getURI();?>/editGift?id=<?php echo $dataRec->id; ?>"><?php echo $dataRec->code; ?></a>
						</h3>
						<div class="cIndex-Status">Value point: <span></span><span><?php  echo $dataRec->valuePoint ?></span></div>
						<div class="cIndex-Actions"><a href="<?php echo CRoute::getURI();?>/deleteGift?id=<?php echo $dataRec->id; ?>">Delete</a></div>
					</div>
				</div>
			
		</li>
		
		<?php } ?>
		
	</ul>
<div class="cPagination"/>
</div>