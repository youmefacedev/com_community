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


<script type="text/javascript">

	var formValidated = false; 
	
	jomsQuery(document).ready(function() {

		//ensure only numeric value entered here 
		jomsQuery('#withdrawPoint').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});

		// submitBtn
		jomsQuery('#formWithdraw').submit(function (event) { 


			if (!formValidated)
			{

					event.preventDefault();
		
					if( jomsQuery("#withdrawPoint").val().length == 0 )
					{
						alert('Please specify value you would like to withdraw.');
						return false;
					}
		
					if( jomsQuery("#name").val().length == 0 )
					{
						alert('Please specify your name.');
						return false;
					}
		
					if( jomsQuery("#bankName").val().length == 0 )
					{
						alert('Please specify your bank name.');
						return false;
					}
		
		
					if(jomsQuery("#acctnum").val().length == 0 )
					{
						alert('Please specify your account number.');
						return false;
					}
		
		
					var acctNum = jomsQuery("#acctnum").val();
					var acctNumConfirm = jomsQuery("#acctnumConfirm").val();
					
					if (acctNum != acctNumConfirm)
					{
						alert('Please ensure your account confirmation number is the same.');
						return false;
					}
					
					var userAgree = jomsQuery('#agree').is(':checked');
		
					if (!userAgree)
					{
						alert('Please make sure you agree with the terms and condition.');
						return false;
					}  
					
				formValidated = true;
				jomsQuery("#formWithdraw").submit();
			}
				
		}); 	

});

</script>

<div class="cSearch-ResultTopless">
<p>
<b>Withdraw credit</b>
</p>

<form name="formWithdraw" id="formWithdraw" action="<?php echo $coreUrl; ?>" method="POST" class="cForm community-form-validate">

	
	<div class="cIndex-Box clearfix">
		<ul class="cFormList cFormHorizontal cResetList"> 
		 
			<li>
			  	<label class="form-label">Your Balance  </label>
				
					<div class="form-field">
						<span><?php echo (!empty($balancePoint) ? $balancePoint : ''); ?></span>
				   </div>
			</li>
					
			<li>
			  	<label class="form-label">Withdraw  </label>
					<div class="form-field">
						<input type='text' id="withdrawPoint" name="withdrawPoint" />
				   </div>
			</li>
			
			
			
			<li>
			
				<label for="bankCountry" class="form-label">Country of bank </label>
						
					<div class="form-field">
						<select id="bankCountry" name="bankCountry" >
							<option value="MY">Malaysia</option> 
							<option value="SG">Singapore</option>
						</select> 
					</div>
			
			</li>
			
			<li>
				<label for="name" class="form-label">Name</label>
				<div class="form-field">
					<input type='text' id="name" name="name" />  	
				</div>
			</li>	
				
			
			<li>	
			
			<label for="bankName" class="form-label">Bank Name</label>
					<div class="form-field">
					<input type='text' id="bankName" name="bankName" /> 
					</div>
			</li>		
		
		       
		     <li>
					<label for="mepsRouting" class="form-label">Meps Routing Code</label>
					<div class="form-field">
						<input type='text' id="mepsRouting" name="mepsRouting" /> <a href="">Get code</a>
					</div>
			</li>	
					
			<li>
			
			<label for="acctnum" class="form-label">Account number</label>
				<div class="form-field">
						<input type='text' id="acctnum" name="acctnum" /> 
					</div>
			</li>	
			
			<li>
					<label for="acctnumConfirm" class="form-label">Re-enter account number</label>
					<div class="form-field">
						<input type='text' id="acctnumConfirm" name="acctnumConfirm" />
					</div>
			</li>
			
			<li>		
					<label for="agree" class="form-label"></label>
				
					<div class="form-field">
						<input id="agree" name="agree" type='checkbox'> I agree to terms and condition.
					</div>
					
			</li>

			<li>		
					<div class="form-field">
					<span><button id="submitBtn" class="btn-primary btn" name="submitBtn">Submit</button>
					</div>
			
			</li>
		
		
	</ul>
<div class="cPagination"/>
</div>

 </form>
 
</div>


