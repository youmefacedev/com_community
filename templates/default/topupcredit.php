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

<div class="cSearch-ResultTopless">
<p>
<b>Topup credit</b>
</p>


<script type="text/javascript">

	var formValidated = false; 
	
	jomsQuery(document).ready(function() {

		//ensure only numeric value entered here 
		jomsQuery('#withdrawPoint').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});


		jomsQuery('#topupForm').submit(function (event) { 

			if (!formValidated)
			{
				if( jomsQuery("#packageName").val() !=  '' )
				{
					return true; 
				}
				event.preventDefault();
			}		
		});
	});

</script>

<form name="topupForm" id="topupForm" action="<?php echo $coreUrl; ?>" method="POST" class="cForm community-form-validate">

	<div class="cIndex-Box clearfix">
		<ul class="cFormList cFormHorizontal cResetList"> 
		
			<li>
			  	<label for="packageName" class="form-label">Select package</label>
					<div class="form-field">
						<select id='packageName' name='packageName'>
						 	<option value="PKG1">100</option>
						 	<option value="PKG2">200</option>
						 	<option value="PKG3">300</option>
						   </select>
				   </div>
			</li>
					
			<li>
			  	<label class="form-label"></label>
			  	
					<div class="form-field">
						 <button id="ConfirmBtn" class="btn-primary btn" name="ConfirmBtn"> Pay </button>
				   </div>
			</li>
		
	</ul>
<div class="cPagination"/>
</div>


</div>
</div>

</form>
