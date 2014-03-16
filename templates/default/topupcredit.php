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
</style>

<div class="cSearch-ResultTopless">
	<p>
		<b>Topup credit</b>
	</p>


	<script type="text/javascript">

	var formValidated = false; 
	var ctrlId = "#packageId";
	var PackageId10 = "10pts";
	var PackageId20 = "20pts";
	var PackageId50 = "50pts";
	var PackageId100 = "100pts";
	var PackageId500 = "500pts";
	var PackageId1000 = "1000pts";

	function setValue(pts, packageId)
	{
		jomsQuery("#item_name").val(packageId);
		jomsQuery("#item_number").val(packageId);
		jomsQuery("#amount").val(pts);
	}
	
	jomsQuery(document).ready(function() {

		jax.call('community','system,startPayment', "<?php echo $trxId; ?>", "10pts");
		
		jomsQuery(ctrlId).change(function (event) { 
						
			if (!formValidated)
			{	
				var packageId = jomsQuery(ctrlId).val();
				
				if(packageId !=  '' )
				{	
					if (packageId == PackageId10)
					{	
						setValue(10, PackageId10);
					}
					else if (packageId == PackageId20)
					{	
						setValue(20, PackageId20);
					}
					else if (packageId == PackageId50)
					{	
						setValue(50, PackageId50);
					}
					else if (packageId == PackageId100)
					{
						setValue(100, PackageId100);
					}
					else if (packageId == PackageId500)
					{
						setValue(500, PackageId500);
					}
					else if (packageId == PackageId1000)
					{
						setValue(1000, PackageId1000);
					}
					
					jax.call('community','system,startPayment', "<?php echo $trxId; ?>", packageId);
					return true; 
				}
				else 
				{
					return false;
				}
				event.preventDefault();
			}
		});
	
});

</script>

	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr"
		method="post">

		<div class="cIndex-Box clearfix">

			<div class="cIndex-Box clearfix">
				<ul class="cFormList cFormHorizontal cResetList">

					<li><label for="packageName" class="form-label">Select package</label>

						<input type="hidden" name="hosted_button_id" value="ZTY3E8UW99HVC">
						<div>
							<select id="packageId">
								<option value="10pts">10pts 10.00 USD</option>
								<option value="20pts">20pts 20.00 USD</option>
								<option value="50pts">50pts 50.00 USD</option>
								<option value="100pts">100pts 100.00 USD</option>
								<option value="500pts">500pts 500.00 USD</option>
								<option value="1000pts">1000pts 1,000.00 USD</option>
							</select>
						</div>
					</li>

					<li><label class="form-label"></label>
						<div class="form-field">
							<input type="hidden" name="currency_code" value="USD"> <input
								type="image"
								src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif"
								border="0" id="submit" name="submit"
								alt="PayPal - The safer, easier way to pay online!"> <img alt=""
								border="0"
								src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif"
								width="1" height="1">
						</div>
					</li>
				</ul>

				<input type="hidden" name="cmd" value="_xclick"> <input
					type="hidden" name="business" value="miki.flintech@gmail.com"> 
					<input type="hidden" name="item_name" id="item_name" value="10pts USD 10,00"> <input type="hidden" name="item_number" id="item_number" value="10pts USD 10,00"> 
					<input type="hidden" id="amount" name="amount" value="10"> 
					<input type="hidden" name="tax" value="0"> 
					<input type="hidden" name="quantity" value="1"> 
					<input type="hidden" name="txn_id" value="<?php echo $trxId; ?>"> 
				
				<!-- Quantity-->
				<input type="hidden" name="no_note" value="1"> <input type="hidden"
					name="currency_code" value="USD">
				<!-- Currency-->
				<input type="hidden" name="notify_url"
					value="http://www.youmeface.com/joomla/index.php/en/jomsocial/payment/ipn">
				<input type="hidden" name="return"
					value="http://www.youmeface.com/index.php/payment/success">
				<input type="hidden" name="cancel_return"
					value="http://www.youmeface.com/index.php/payment/cancel">


				<div class="cPagination" />
			</div>
		</div>

	</form>
</div>
