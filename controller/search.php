<?php
require(LanguagePath . 'home.php');

$Page         = Request('Get', 'page');
$Keyword      = CharCV(Request('Get', 'keyword'));
$KeywordArray = array_unique(explode(" ", $Keyword));
$Error        = '';

$PostsSearch = false;//是否启用帖子搜索
$PostsSearchOffset = array_search('post:true', $KeywordArray);
if ($PostsSearchOffset !== false) {
	$PostsSearch = true;
	unset($KeywordArray[$PostsSearchOffset]);
}
ksort($KeywordArray);

if (!$KeywordArray) {
	AlertMsg('404 Not Found', '404 Not Found', 404);
}
if ($Page < 0 || $Page == 1)
	Redirect('search/' . $Keyword);
if ($Page == 0)
	$Page = 1;

$SQLKeywordArray = array();//查询关键字参数数组
$AdvancedSearch = false;
$NormalQuery = array();//普通查询条件，用OR连接
$AdvancedQuery = array();//高级查询条件，用AND连接
//关键词预处理
foreach ($KeywordArray as $Key => $KeywordToken) {
	//匹配用户名限制条件
	preg_match('/user:(.*)/i', $KeywordToken, $SearchUserTopics);
	if (!empty($SearchUserTopics[1]) && IsName($SearchUserTopics[1])){
		$AdvancedSearch = true;
		break;
	}
}

// 禁止普通用户使用无索引的全文搜索
if (!$AdvancedSearch && $CurUserRole < 2) {
	$PostsSearch = false;
}
foreach ($KeywordArray as $Key => $KeywordToken) {
	//匹配用户名限制条件
	preg_match('/user:(.*)/i', $KeywordToken, $SearchUserTopics);
	if (!empty($SearchUserTopics[1]) && IsName($SearchUserTopics[1])){
		if ($PostsSearch) {
			$AdvancedQuery[] = 'p.UserName = :PostUser';
			$SQLKeywordArray['PostUser'] = $SearchUserTopics[1];
		} else {
			$AdvancedQuery[] = 't.UserName = :TopicUser';
			$SQLKeywordArray['TopicUser'] = $SearchUserTopics[1];
		}
	} else {
		$ParamName = substr(md5($KeywordToken), 0, 8);
		if ($PostsSearch) {
			$NormalQuery[] = 'p.Subject LIKE :Subject' . $ParamName . ' or p.Content LIKE :Content' . $ParamName;
			$SQLKeywordArray['Subject' . $ParamName] = '%' . $KeywordToken . '%';
			$SQLKeywordArray['Content' . $ParamName] = '%' . $KeywordToken . '%';
		} else {
			$NormalQuery[] = 't.Topic LIKE :Topic' . $ParamName . ' or t.Tags LIKE :Tag' . $ParamName;
			$SQLKeywordArray['Topic' . $ParamName] = '%' . $KeywordToken . '%';
			$SQLKeywordArray['Tag' . $ParamName] = '%' . $KeywordToken . '%';
		}
	}
}

$SearchCondition = array();
$Temp = implode(' AND ', $AdvancedQuery);
if (!empty($Temp)) {
	$SearchCondition[] = $Temp;
}
$Temp = implode(' OR ', $NormalQuery);
if (!empty($Temp)) {
	$SearchCondition[] = '(' . $Temp . ')';
}
unset($Temp);
$SearchConditionQuery = implode(' AND ', $SearchCondition);

	if ($PostsSearch) {
		$SearchFields = 'SELECT 
				t.`ID`,
				t.`Topic`,
				t.`Tags`,
				t.`LastName`,
				t.`Replies`,
				p.`UserID`,
				p.`UserName`,
				p.`Content`,
				p.`ID` AS PostID,
				p.`PostTime` AS LastTime
			FROM ' . PREFIX . 'posts p 
			LEFT JOIN  ' . PREFIX . 'topics t 
			ON t.ID=p.TopicID';
	} else {
		$SearchFields = 'SELECT t.`ID`, t.`Topic`, t.`Tags`, t.`UserID`, t.`UserName`, t.`LastName`, t.`LastTime`, t.`Replies` 
			FROM ' . PREFIX . 'topics t ';
	}
		$TopicsArray = $DB->query($SearchFields . ' 
			WHERE ' . $SearchConditionQuery . ' 
			ORDER BY LastTime DESC 
			LIMIT ' . ($Page - 1) * $Config['TopicsPerPage'] . ', ' . ($Config['TopicsPerPage'] + 1), $SQLKeywordArray);
		if ($PostsSearch) {
			foreach ($TopicsArray as &$Topic) {
				$Topic['MinContent'] = strip_tags(mb_substr($Topic['Content'], 0, 300, 'utf-8'),'<p><br>');
			}
		}

$DB->CloseConnection();

if (count($TopicsArray) > $Config['TopicsPerPage']) {
    $IsLastPage = false;
    array_pop($TopicsArray);
} else {
    $IsLastPage = true;
}

$PageTitle = $Lang['Search'] . ' ' . $Keyword . ' ';
$PageTitle .= $Page > 1 ? ' Page' . $Page : '';
$ContentFile = $TemplatePath . 'search.php';
include($TemplatePath . 'layout.php');
