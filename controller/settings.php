<?php
require(LanguagePath . 'settings.php');
Auth(1);
$UploadAvatarMessage   = '';
$UpdateUserInfoMessage = '';

// $DoNotNeedOriginalPassword === True表示该用户为oAuth登陆用户，修改密码不需要原密码

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$Action = Request('POST', 'Action', false);
	switch ($Action) {
		case 'UploadAvatar':
			if ($_FILES['Avatar']['size'] && $_FILES['Avatar']['size'] < 1048576) {
				require(LibraryPath . "ImageResize.class.php");
				$UploadAvatar  = new ImageResize('PostField', 'Avatar');
				$LUploadResult = $UploadAvatar->Resize(256, 'upload/avatar/large/' . $CurUserID . '.png', 80);
				$MUploadResult = $UploadAvatar->Resize(48, 'upload/avatar/middle/' . $CurUserID . '.png', 90);
				$SUploadResult = $UploadAvatar->Resize(24, 'upload/avatar/small/' . $CurUserID . '.png', 90);
				if ($LUploadResult && $MUploadResult && $SUploadResult) {
					$UploadAvatarMessage = $Lang['Avatar_Upload_Success'];
				} else {
					$UploadAvatarMessage = $Lang['Avatar_Upload_Failure'];
				}
				
			} else {
				$UploadAvatarMessage = $Lang['Avatar_Is_Oversize'];
			}
			break;
		
		case 'UpdateUserInfo':
			$CurUserInfo['UserSex']      = intval(Request('POST', 'UserSex', 0));
			$CurUserInfo['UserMail']     = IsEmail(Request('POST', 'UserMail', $CurUserInfo['UserMail'])) ? Request('POST', 'UserMail', $CurUserInfo['UserMail']) : $CurUserInfo['UserMail'];
			$CurUserInfo['UserHomepage'] = CharCV(Request('POST', 'UserHomepage', $CurUserInfo['UserHomepage']));
			$CurUserInfo['UserIntro']    = CharCV(Request('POST', 'UserIntro', $CurUserInfo['UserIntro']));
			$UpdateUserInfoResult        = UpdateUserInfo(array(
				'UserSex' => $CurUserInfo['UserSex'],
				'UserMail' => $CurUserInfo['UserMail'],
				'UserHomepage' => $CurUserInfo['UserHomepage'],
				'UserIntro' => $CurUserInfo['UserIntro']
			));
			if ($UpdateUserInfoResult) {
				$UpdateUserInfoMessage = $Lang['Profile_Modified_Successfully'];
			} else {
				$UpdateUserInfoMessage = $Lang['Profile_Do_Not_Modify'];
			}
			
			break;
		default:
			# code...
			break;
	}
}
$DB->CloseConnection();
// 页面变量
$PageTitle   = $Lang['Settings'];
$ContentFile = $TemplatePath . 'settings.php';
include($TemplatePath . 'layout.php');
