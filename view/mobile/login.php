<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');

if($Error){
?>
<script type="text/javascript">CarbonAlert("<?php echo $Error; ?>");</script>
<?php
}
?>
<br />
<form action="?" method="post" onsubmit="JavaScript:this.Password.value=md5(this.Password.value);">
	<div class="input-group">
		<input type="hidden" value="<?php echo $ReturnUrl; ?>" name="ReturnUrl" />
		<input type="hidden" name="FormHash" value="<?php echo $FormHash; ?>" />
		<input type="hidden" name="Expires" value="30" />
		<p>
		<input type="text" name="UserName" id="UserName" placeholder="<?php echo $Lang['UserName']; ?>" value="<?php echo htmlspecialchars($UserName); ?>" />
		</p>
		<p>
		<input type="password" name="Password" id="Password" placeholder="<?php echo $Lang['Password']; ?>" value="" />
		</p>
		<p>
			<input type="text" name="VerifyCode" id="VerifyCode" placeholder="<?php echo $Lang['Verification_Code']; ?>" onclick="document.getElementById('Verification_Code_Img').src='<?php echo $Config['WebsitePath']; ?>/seccode.php';" value="" placeholder="<?php echo $Lang['Verification_Code']; ?>" style="width:66%;"/>
			<img src="" id="Verification_Code_Img" style="cursor: pointer;" onclick="this.src+=''" style="width:33%;" align="middle" />
			<br style="clear:both" />
		</p>
		<p>
			<input type="submit" class="button" value="<?php echo $Lang['Log_In']; ?>" name="submit" style="float:right;" />
		</p>
	</div>
</form>
