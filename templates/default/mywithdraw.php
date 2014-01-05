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

	function showBankRoutingCode()
	{

		var bankdata = Array();
		bankdata.push({"name" : "AFFIN BANK BERHAD", "code" : "PHBMMYKL"});
		bankdata.push({"name" : "ALLIANCE BANK MALAYSIA BERHAD", "code" : "MFBBMYKL"});
		bankdata.push({"name" : "AMBANK BERHAD", "code" : "ARBKMYKL"});
		bankdata.push({"name" : "BANK ISLAM MALAYSIA BERHAD", "code" : "BIMBMYKL"});
		bankdata.push({"name" : "BANK KERJASAMA RAKYAT BERHAD", "code" : "BKRMMYK1"});
				
		cWindowShow('', 'Bank routing code', 400, 300);
		var content = "<div style='display : table;'>";
			content += "<div style='display : table-row;'><div style='display: table-cell'>Bank Name</div><div style='display: table-cell'>Bank Code</div></div>";

			for(var i=0; i < bankdata.length; i ++)
			{
				content += "<div style='display : table-row;'><div style='display: table-cell'>" +  bankdata[i].name  + "</div><div style='display: table-cell'>" + bankdata[i].code + "</div></div>";	
			}
			
		content += "</div>";
		cWindowAddContent(content, "<button class='btn' onclick='selectBankRoutingCode(); '>Ok</button>");	
	}

	function selectBankRoutingCode()
	{
		cWindowHide();
	}
	
	
	jomsQuery(document).ready(function() {

		var defaultDataValue = jomsQuery('#bankName option:selected').attr('code');
		console.log(defaultDataValue);
		
		//jomsQuery('#mepsRouting').val(dataValue);
	
		

		//ensure only numeric value entered here 
		jomsQuery('#withdrawPoint').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		jomsQuery('#bankName').change(function () {
			var dataValue = jomsQuery('option:selected', this).attr('code');
			jomsQuery('#mepsRouting').val(dataValue);
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
					<select id="bankName" name="bankName">
							<option code='PHBMMYKL' value='AFFIN BANK BERHAD'>AFFIN BANK BERHAD</option>
							<option code='MFBBMYKL' value='ALLIANCE BANK MALAYSIA BERHAD'>ALLIANCE BANK MALAYSIA BERHAD</option>
							<option code='ARBKMYKL' value='AMBANK BERHAD'>AMBANK BERHAD</option>
							<option code='BIMBMYKL' value='BANK ISLAM MALAYSIA BERHAD'>BANK ISLAM MALAYSIA BERHAD</option>
							<option code='BKRMMYK1' value='BANK KERJASAMA RAKYAT BERHAD'>BANK KERJASAMA RAKYAT BERHAD</option>
							<option code='BMMBMYKL' value='BANK MUAMALAT BERHAD'>BANK MUAMALAT BERHAD</option>
							
							<option code='BOFAMY2X' value='BANK OF AMERICA'>BANK OF AMERICA</option>
							<option code='BSNAMYK1' value='BANK SIMPANAN NASIONAL'>BANK SIMPANAN NASIONAL</option>
							<option code='CIBBMYKL' value='CIMB BANK BERHAD'>CIMB BANK BERHAD</option>
							<option code='CITIMYKL' value='CITIBANK BERHAD'>CITIBANK BERHAD</option>
							<option code='DEUTMYKL' value='DEUSTCHE BANK'>DEUSTCHE BANK</option>
							<option code='EOBBMYKL' value='EON BANK BERHAD'>EON BANK BERHAD</option>
							<option code='HLBBMYKL' value='HONG LEONG BANK BERHAD'>HONG LEONG BANK BERHAD</option>
							
							
							<option code='HBMBMYKL' value='HSBC BANK MALAYSIA BERHAD'>HSBC BANK MALAYSIA BERHAD</option>
							<option code='MBBEMYKL' value='MALAYAN BANKING BERHAD'>MALAYAN BANKING BERHAD</option>
							<option code='OCBCMYKL' value='OCBC BANK (M) BERHAD'>OCBC BANK (M) BERHAD</option>
							<option code='PBBEMYKL' value='PUBLIC BANK BERHAD'>PUBLIC BANK BERHAD</option>
							
							<option code='RHBBMYKL' value='RHB BANK BERHAD'>RHB BANK BERHAD</option>
							<option code='SCBLMYKX' value='STANDARD CHARTERED BANK MSIA BHD'>STANDARD CHARTERED BANK MSIA BHD</option>
							<option code='ABNAMYKL' value='THE ROYAL BANK OF SCOTLAND BERHAD (RBS)'>THE ROYAL BANK OF SCOTLAND BERHAD (RBS)</option>
							<option code='UOVBMYKL' value='UNITED OVERSEAS BANK'>UNITED OVERSEAS BANK</option>
							
					    </select>
					    
					    <input type='hidden'  value="PHBMMYKL" id="mepsRouting" name="mepsRouting" />
					     
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


