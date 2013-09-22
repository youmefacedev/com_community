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
<b>Top up credit</b>
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
				event.preventDefault();
				alert('please setup validation routine in javascript first');


				if( jomsQuery("#FirstName").val().length == 0 )
				{
					alert('Please specify first name.');
					return false;
				}

				if( jomsQuery("#LastName").val().length == 0 )
				{
					alert('Please specify last name.');
					return false;
				}



				
					
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
						 	<option>100 </option>
						 	<option>200 </option>
						 	<option>300 </option>
						   </select>
				   </div>
			</li>
			
			<li>
			  	<label class="form-label"></label>
					<div class="form-field">
						CIMB   MayBank 
				   </div>
			</li>
			
			
			<li>
			  	<label for="FirstName" class="form-label">First Name</label>
					<div class="form-field">
						<input type='text' id="FirstName" name="FirstName" />
				   </div>
			</li>
			
			<li>
			  	<label for="LastName" class="form-label">Last Name</label>
					<div class="form-field">
						<input type='text' id="LastName" name="LastName" />
				   </div>
			</li>
			
			
			<li>
			  	<label for="CardName" class="form-label">Select package</label>
					<div class="form-field">
						<input type='text' id="CardName" name="CardName" />
				   </div>
			</li>
			
			<li>
			  	<label for="CardNumber" class="form-label">Card Number</label>
					<div class="form-field">
						<input type='text' id="CardNumber" name="CardNumber" />
				   </div>
			</li>
			
			<li>
			  	<label for="Street" class="form-label">Street </label>
					<div class="form-field">
						<input type='text' id="Street" name="Street" />
				   </div>
			</li>
			
			
			<li>
			  	<label for="SecurityCode" class="form-label">Security Code</label>
					<div class="form-field">
						<input type='text' id="SecurityCode" name="SecurityCode" />
				   </div>
			</li>
				
				
			<li>
			  	<label for="City" class="form-label">City</label>
					<div class="form-field">
						<input type='text' id="City" name="City" />
				   </div>
			</li>

			
			<li>
			  	<label for="ExpiryDate" class="form-label">Expiry Date</label>
					<div class="form-field">
						<input type='text' id="ExpiryDate" name="ExpiryDate" />
				   </div>
			</li>
			
			
			<li>
			  	<label for="State" class="form-label">State</label>
					<div class="form-field">
						<input type='text' id="State" name="State" />
				   </div>
			</li>
			
			
			<li>
			  	<label for="Zip" class="form-label">Zip/Postal Code</label>
					<div class="form-field">
						<input type='text' id="Zip" name="Zip" />
				   </div>
			</li>
			
			<li>
			  	<label for="Country" class="form-label">Country</label>
					<div class="form-field">
						<input type='text' id="Country" name="Country" />
				   </div>
			</li>
		
			<li>
			  	<label for="Email" class="form-label">Email</label>
					<div class="form-field">
						<input type='text' id="Email" name="Email" />
				   </div>
			</li>
			
			
			<li>
			  	<label for="Phone" class="form-label">Phone No</label>
					<div class="form-field">
						<input type='text' id="Phone" name="Phone" />
				   </div>
			</li>
			
			<li>
			  	<label class="form-label"></label>
			  	
					<div class="form-field">
						 <button id="ConfirmBtn" name="ConfirmBtn"> Confirm </button>
				   </div>
			</li>
		
	</ul>
<div class="cPagination"/>
</div>


</div>
</div>

</form>
