<?php
require(LanguagePath . 'dashboard.php');
Auth(5);
$BasicMessage    = '';
$PageMessage     = '';
$AdvancedMessage = '';
$ParameterMessage = '';
$Action          = Request('Post', 'Action', false);

switch ($Action) {
	case 'Parameter':
		$SuccessNumber = 0;
		$UploadWhiteList = Request('Post', 'UploadWhiteUserListParameter', '');
		$SuccessNumber += file_put_contents(LibraryPath . 'WhiteUserList.config.json',
            json_encode(explode("\r\n", $UploadWhiteList))) === false ? 0 : 1;

		$UploadParameters = Request('Post', 'UploadParameters', '');
		if (IsJson($UploadParameters)) {
			$SuccessNumber += file_put_contents(LibraryPath . 'Uploader.config.json', $UploadParameters) === false ? 0 : 1;
		}

		$TextFilterParameter = Request('Post', 'TextFilterParameter', '');
		if (IsJson($TextFilterParameter)) {
			$SuccessNumber += file_put_contents(LibraryPath . 'Filtering.words.config.json', $TextFilterParameter) === false ? 0 : 1;
		}
		$ParameterMessage = str_replace('{{NewConfig}}', $SuccessNumber, $Lang['Parameter_Settings_Successfully_Saved']);
		break;

	case 'Statistics':
		@set_time_limit(0);
		$DB->query('DELETE FROM ' . PREFIX . 'statistics');
		$StatisticsTime = strtotime(date('Y-m-d', $DB->single('SELECT UserRegTime FROM ' . PREFIX . 'users ORDER BY ID ASC LIMIT 1')));
		while ($StatisticsTime < ($TimeStamp - 86400)) {
			$StatisticsTimeAddOneDay = $StatisticsTime + 86400;
			//echo date('Y-m-d', $StatisticsTime);
			//echo '<br />';
			$DB->query('INSERT INTO `' . PREFIX . 'statistics` 
				(
					`DaysUsers`, 
					`DaysPosts`, 
					`DaysTopics`, 
					`TotalUsers`, 
					`TotalPosts`, 
					`TotalTopics`, 
					`DaysDate`, 
					`DateCreated`
				) 
				SELECT 
					(SELECT count(*) FROM ' . PREFIX . 'users u 
						WHERE u.UserRegTime >= ' . $StatisticsTime . ' 
							AND u.UserRegTime < ' . $StatisticsTimeAddOneDay . ' ), 
					(SELECT count(*) FROM ' . PREFIX . 'posts p 
						WHERE p.PostTime >= ' . $StatisticsTime . ' 
							AND p.PostTime < ' . $StatisticsTimeAddOneDay . ' 
							AND p.IsTopic = 0), 
					(SELECT count(*) FROM ' . PREFIX . 'topics t 
						WHERE t.PostTime >= ' . $StatisticsTime . ' 
							AND t.PostTime < ' . $StatisticsTimeAddOneDay . '  
							AND t.IsDel = 0), 
					(SELECT count(*) FROM ' . PREFIX . 'users u 
						WHERE u.UserRegTime < ' . $StatisticsTimeAddOneDay . ' ), 
					 (SELECT count(*) FROM ' . PREFIX . 'posts p 
						WHERE p.TopicID NOT IN (SELECT ID FROM ' . PREFIX . 'topics t 
							WHERE t.PostTime < ' . $StatisticsTimeAddOneDay . ' 
								AND t.IsDel = 1)
							AND p.PostTime < ' . $StatisticsTimeAddOneDay . ' 
							AND p.IsTopic = 0 ), 
					(SELECT count(*) FROM ' . PREFIX . 'topics t 
						WHERE t.PostTime < ' . $StatisticsTimeAddOneDay . ' 
							AND t.IsDel = 0), 
					:DaysDate,
					:DateCreated 
					FROM dual  
					WHERE NOT EXISTS(  
						SELECT *  FROM `' . PREFIX . 'statistics`  
						WHERE DaysDate = :DaysDate2
					)
				', array(
				'DaysDate' => date('Y-m-d', $StatisticsTime),
				'DaysDate2' => date('Y-m-d', $StatisticsTime),
				'DateCreated' => $StatisticsTimeAddOneDay - 1
			));
			$StatisticsTime = $StatisticsTimeAddOneDay;
		}

		break;
	default:
		$NewConfig = $_POST;
		//Fool-proofing
		if ($Action == 'Basic') {
			$NewConfig['TopicsPerPage'] = intval(Request('Post', 'TopicsPerPage', 20));
			$NewConfig['PostsPerPage']  = intval(Request('Post', 'PostsPerPage', 20));
			$NewConfig['MaxTagsNum']    = intval(Request('Post', 'MaxTagsNum', 5));
			$NewConfig['MaxTagChars']   = intval(Request('Post', 'MaxTagChars', 128));
			$NewConfig['MaxPostChars']  = intval(Request('Post', 'MaxPostChars', 65536));
		}
		//Fool-proofing
		if ($Action == 'Advanced') {
			if ($NewConfig['MobileDomainName'] == $_SERVER['HTTP_HOST']) {
				$NewConfig['MobileDomainName'] = $Config['MobileDomainName'];
			}
		}
		foreach ($NewConfig as $Key => $Value) {
			if (!array_key_exists($Key, $Config) || $Value == $Config[$Key]) {
				unset($NewConfig[$Key]);
			} else {
				$Config[$Key] = $NewConfig[$Key];
			}
		}
		UpdateConfig($NewConfig);
		switch ($Action) {
			case 'Basic':
				$BasicMessage = str_replace('{{NewConfig}}', count($NewConfig), $Lang['Basic_Settings_Successfully_Saved']);
				break;
			case 'Page':
				$PageMessage = str_replace('{{NewConfig}}', count($NewConfig), $Lang['Page_Settings_Successfully_Saved']);
				break;
			case 'Advanced':
				$AdvancedMessage = str_replace('{{NewConfig}}', count($NewConfig), $Lang['Advanced_Settings_Successfully_Saved']);
				break;
			default:
				break;
		}
		break;
}

$DB->CloseConnection();
// 页面变量
$PageTitle   = $Lang['System_Settings'];
$ContentFile = $TemplatePath . 'dashboard.php';
include($TemplatePath . 'layout.php');
