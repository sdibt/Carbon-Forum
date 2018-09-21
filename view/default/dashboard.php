<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');

function GenerateSelect($Options, $Name)
{
	global $Config;
	if (isset($Config[$Name])) {
		$DefaultValue = $Config[$Name];
	} else {
		$DefaultValue = '';
	}
	$IsValueInOptions = false;
	$Result = '<select name="' . $Name . '">';
	foreach ($Options as $Key => $Value) {
		if ($Value !== $DefaultValue) {
			$Result .= '<option value="' . $Value . '">' . $Key . '</option>';
		} else {
			$Result .= '<option value="' . $Value . '" selected="selected">' . $Key . '</option>';
			$IsValueInOptions = true;
		}
	}
	if ($IsValueInOptions === false && !empty($DefaultValue)) {
		$Result .= '<option value="' . $DefaultValue . '" selected="selected">' . $DefaultValue . '</option>';
	}
	$Result .= '</select>';
	return $Result;
}
?>
<!-- main-content start -->
<script>
	$(document).ready(function () {
		$("#dashboard").easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion
			width: 'auto', //auto or any custom width
			fit: true,   // 100% fits in a container
			closed: false, // Close the panels on start, the options 'accordion' and 'tabs' keep them closed in there respective view types
			activate: function () {
			}  // Callback function, gets called if tab is switched
		});
	});
</script>

<div id="dashboard" class="tab-container">
	<ul class='resp-tabs-list'>
		<li><?php echo $Lang['Basic_Settings']; ?></li>
		<li><?php echo $Lang['Page_Settings']; ?></li>
		<li><?php echo $Lang['Advanced_Settings']; ?></li>
		<li><?php echo $Lang['Parameter_Settings']; ?></li>
		<li><?php echo $Lang['Recycle_Bin']; ?></li>
	</ul>
	<div class="resp-tabs-container">

		<div>
			<p class="red text-center"><?php echo $BasicMessage; ?></p>
			<form method="post" action="<?php echo $Config['WebsitePath']; ?>/dashboard#dashboard1">
				<input type="hidden" name="Action" value="Basic"/>
				<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs14">
					<tbody>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Forum_Name']; ?></td>
						<td width="auto" align="left">
							<input type="text" class="w600" name="SiteName" value="<?php echo $Config['SiteName']; ?>"/>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Forum_Descriptions']; ?></td>
						<td width="auto" align="left">
							<textarea class="w600 h160" name="SiteDesc"><?php echo $Config['SiteDesc']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Page_Show']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'10' => '10',
								'20' => '20',
								'50' => '50',
								'100' => '100'
							), 'TopicsPerPage'); ?> <?php echo $Lang['Page_Topics']; ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Topic_Show']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'10' => '10',
								'20' => '20',
								'50' => '50',
								'100' => '100'
							), 'PostsPerPage'); ?> <?php echo $Lang['Topic_Posts']; ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Topic_Max']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								// '0' => '0',
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
								'5' => '5'
							), 'MaxTagsNum'); ?> <?php echo $Lang['Topic_Max_Tags']; ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Tag_Max']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'32' => '32',
								'64' => '64',
								'128' => '128',
								'256' => '256'
							), 'MaxTagChars'); ?> <?php echo $Lang['Tag_Max_Chars']; ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Post_Max']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'7500' => '7500',
								'15000' => '15000',
								'30000' => '30000',
								'60000' => '60000',
								'120000' => '120000',
								'240000' => '240000'
							), 'MaxPostChars'); ?> <?php echo $Lang['Post_Max_Chars']; ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Allow_Ordinary_Users_To_Edit_Their_Own_Posts']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								$Lang['Yes'] => 'true',
								$Lang['No'] => 'false',
							), 'AllowEditing'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Allow_Empty_Tags']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								$Lang['Yes'] => 'true',
								$Lang['No'] => 'false',
							), 'AllowEmptyTags'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Allow_Ordinary_Users_To_Create_New_Topics']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								$Lang['Yes'] => 'true',
								$Lang['No'] => 'false',
							), 'AllowNewTopic'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Close_Registration']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								$Lang['Yes'] => 'true',
								$Lang['No'] => 'false',
							), 'CloseRegistration'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['New_User_Freeze_Time']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'0 seconds' => '0',
								'30 seconds' => '30',
								'60 seconds' => '60',
								'300 seconds' => '300',
								'1800 seconds' => '1800',
								'3600 seconds' => '3600',
								'43200 seconds' => '43200',
								'86400 seconds' => '86400',
							), 'FreezingTime'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Posting_Interval']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'0 seconds' => '0',
								'10 seconds' => '10',
								'30 seconds' => '30',
								'60 seconds' => '60',
								'600 seconds' => '600'
							), 'PostingInterval'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"></td>
						<td width="auto" align="left">
							<input type="submit" value="<?php echo $Lang['Save']; ?>" name="submit" class="textbtn" />
						</td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div>
			<p class="red text-center"><?php echo $AdvancedMessage; ?></p>
			<form method="post" action="<?php echo $Config['WebsitePath']; ?>/dashboard#dashboard2">
				<input type="hidden" name="Action" value="Page"/>
				<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs14">
					<tbody>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Html_Between_Head']; ?> </td>
						<td width="auto" align="left">
							<textarea class="w600 h160" name="PageHeadContent"><?php echo CharCV($Config['PageHeadContent']); ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Html_Before_Body']; ?></td>
						<td width="auto" align="left">
							<textarea class="w600 h160" name="PageBottomContent"><?php echo CharCV($Config['PageBottomContent']); ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"> <?php echo $Lang['Html_SiderBar']; ?><br/></td>
						<td width="auto" align="left">
							<textarea class="w600 h160" name="PageSiderContent"><?php echo CharCV($Config['PageSiderContent']); ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"></td>
						<td width="auto" align="left">
							<input type="submit" value="<?php echo $Lang['Save']; ?>" name="submit" class="textbtn"/>
						</td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div>
			<p class="red text-center"><?php echo $AdvancedMessage; ?></p>
			<form method="post" action="<?php echo $Config['WebsitePath']; ?>/dashboard#dashboard3">
				<input type="hidden" name="Action" value="Advanced"/>
				<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs14">
					<tbody>
					<tr>
						<td width="200" align="right"><?php echo $Lang['jQuery_CDN']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'No CDN (Default)' => $Config['WebsitePath'] . '/static/js/jquery.js',
								'Bootcss CDN' => '//cdn.bootcss.com/jquery/1.10.2/jquery.min.js',
								'Sina CDN' => '//lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js',
								'Baidu CDN' => '//libs.baidu.com/jquery/1.10.2/jquery.min.js',
								'Qihoo360 CDN' => '//libs.useso.com/js/jquery/1.10.2/jquery.min.js',
								'Microsoft CDN' => '//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js',
								'Google CDN' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'
							), 'LoadJqueryUrl'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Main_Domainname']; ?></td>
						<td width="auto" align="left">
							<input type="text" class="w600" name="MainDomainName" value="<?php echo $Config['MainDomainName']; ?>"/>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Mobile_Domainname']; ?></td>
						<td width="auto" align="left">
							<input type="text" class="w600" name="MobileDomainName" value="<?php echo $Config['MobileDomainName']; ?>"/>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Push_Connection_Timeout_Period']; ?></td>
						<td width="auto" align="left">
							<?php echo GenerateSelect(array(
								'22 seconds' => '22',
								'53 seconds' => '53',
								'80 seconds' => '80',
								'110 seconds' => '110',
								'170 seconds' => '170',
								'235 seconds' => '235',
								'280 seconds' => '280'
							), 'PushConnectionTimeoutPeriod'); ?>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"></td>
						<td width="auto" align="left">
							<input type="submit" value="<?php echo $Lang['Save']; ?>" name="submit" class="textbtn"/>
						</td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div>
			<p class="red text-center"><?php echo $ParameterMessage; ?></p>
			<form method="post" action="<?php echo $Config['WebsitePath']; ?>/dashboard#dashboard4">
				<input type="hidden" name="Action" value="Parameter"/>
				<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs14">
					<tbody>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Upload_Parameters']; ?> </td>
						<td width="auto" align="left">
							<textarea class="w600 h320" name="UploadParameters"><?php
								if (is_file(LibraryPath . 'Uploader.config.json')) {
									echo CharCV(file_get_contents(LibraryPath . 'Uploader.config.json'));
								} else {
									echo CharCV(file_get_contents(LibraryPath . 'Uploader.config.template.json'));
								}
								?></textarea>
						</td>
					</tr>
					<tr>
						<td width="200" align="right"><?php echo $Lang['Text_Filter_Parameter']; ?></td>
						<td width="auto" align="left">
							<textarea class="w600 h320" name="TextFilterParameter"><?php
								if (is_file(LibraryPath . 'Filtering.words.config.json')) {
									echo CharCV(file_get_contents(LibraryPath . 'Filtering.words.config.json'));
								} else {
									echo CharCV(file_get_contents(LibraryPath . 'Filtering.words.config.template.json'));
								}
								?></textarea>
						</td>
					</tr>
                    <tr>
                        <td width="200" align="right"><?php echo $Lang['White_User_List_Parameter']; ?></td>
                        <td width="auto" align="left">
							<textarea class="w600 h320" name="UploadWhiteUserListParameter"><?php
                                if (!is_null($whiteList)) foreach ($whiteList as $item) echo $item . "\n";
                                ?></textarea>
                        </td>
                    </tr>
					<tr>
						<td width="200" align="right"></td>
						<td width="auto" align="left">
							<input type="submit" value="<?php echo $Lang['Save']; ?>" name="submit" class="textbtn"/>
						</td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div>
			<form method="get" action="<?php echo $Config['WebsitePath']; ?>/recycle-bin">
				<div class="div-align">
					<input type="submit" value="<?php echo $Lang['Recycle_Bin']; ?>" name="submit" class="textbtn"/>
				</div>
			</form>
		</div>
	</div>
</div>
