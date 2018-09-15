<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- main-content start -->
<div class="main-content">
	<div class="main-box">
		<?php if($Error){ ?>
		<p class="red fs12" style="margin-left:60px;">
		› <?php echo $Error; ?> <br/></p>
		<?php } ?>
		<form action="?" method="post" onsubmit="JavaScript:this.Password.value=md5(this.Password.value);">
			<input type="hidden" value="<?php echo $ReturnUrl; ?>" name="ReturnUrl" />
			<input type="hidden" name="FormHash" value="<?php echo $FormHash; ?>" />
			<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs14">
				<tbody>
					<tr>
						<td width="180" align="right"><?php echo $Lang['UserName']; ?></td>
						<td width="auto" align="left"><input type="text" name="UserName" id="UserName" class="sl w200" value="<?php echo htmlspecialchars($UserName); ?>" onblur="CheckUserNameExist()" /></td>
					</tr>
					<tr>
						<td width="180" align="right"><?php echo $Lang['Password']; ?></td>
						<td width="auto" align="left"><input type="password" name="Password" class="sl w200" value="" /></td>
					</tr>
					<tr>
						<td width="180" align="right"><?php echo $Lang['Login_Expiration_Time']; ?></td>
						<td width="auto" align="left">
							<select name="Expires">
								<option value="30">30<?php echo $Lang['Days']; ?></option>
								<option value="14">14<?php echo $Lang['Days']; ?></option>
								<option value="7">7<?php echo $Lang['Days']; ?></option>
								<option value="1">1<?php echo $Lang['Days']; ?></option>
								<option value="0">0<?php echo $Lang['Days']; ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="180" align="right"><?php echo $Lang['Verification_Code']; ?></td>
						<td width="auto" align="left">
							<label><input type="text" name="VerifyCode" class="w100" onfocus="document.getElementById('Verification_Code_Img').src='<?php echo $Config['WebsitePath']; ?>/seccode.php';document.getElementById('Verification_Code_Img').style.display='inline';" value="" placeholder="<?php echo $Lang['Verification_Code']; ?>" /></label> 
							<img src="" id="Verification_Code_Img" style="cursor: pointer;display:none;" onclick="this.src+=''" alt="<?php echo $Lang['Verification_Code']; ?>" align="middle" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
	<!-- main-content end -->
	<!-- main-sider start -->
	<div class="main-sider">
	<?php include($TemplatePath.'sider.php'); ?>
	</div>
	<!-- main-sider end -->
