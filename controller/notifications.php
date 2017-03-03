<?php
require(LanguagePath . 'notifications.php');
SetStyle('api', 'API');
Auth(1);

$Type = Request('GET', 'type', false);
$Page = max(intval(Request('Request', 'page', 1)), 1);

$ResultArray = array(
	"Status" => 1
);
if ($Type === false || $Type === 'reply') {
	$ResultArray['ReplyArray'] = $DB->query('
		SELECT n.ID as NID, n.Type, n.IsRead, p.ID, p.TopicID, p.IsTopic, p.UserID, p.UserName, p.Subject, p.Content, p.PostTime, p.IsDel 
		FROM ' . PREFIX . 'notifications n LEFT JOIN ' . PREFIX . 'posts p 
		on p.ID=n.PostID 
		WHERE n.UserID = :UserID and n.Type=1 
		ORDER BY n.Time DESC LIMIT :Offset, :Number', array(
			'UserID' => $CurUserID,
			'Offset' => ($Page - 1) * $Config['TopicsPerPage'],
			'Number' => $Config['TopicsPerPage']
	));
	foreach($ResultArray['ReplyArray'] as $Key => $Post)
	{
		$ResultArray['ReplyArray'][$Key]['PostFloor'] = -1;
		$ResultArray['ReplyArray'][$Key]['FormatPostTime'] = FormatTime($Post['PostTime']);
		$ResultArray['ReplyArray'][$Key]['Content'] = strip_tags(mb_substr($Post['Content'], 0, 256, 'utf-8'),'<p><br><a>');
	}
}

if ($Type === false || $Type === 'mention') {
	$ResultArray['MentionArray'] = $DB->query('SELECT n.ID as NID, n.Type, n.IsRead, p.ID, p.TopicID, p.IsTopic, p.UserID, p.UserName, p.Subject, p.Content, p.PostTime, p.IsDel 
		FROM ' . PREFIX . 'notifications n 
		LEFT JOIN ' . PREFIX . 'posts p 
		on p.ID=n.PostID 
		WHERE n.UserID = :UserID and n.Type=2 
		ORDER BY n.Time DESC LIMIT :Offset, :Number', array(
			'UserID' => $CurUserID,
			'Offset' => ($Page - 1) * $Config['TopicsPerPage'],
			'Number' => $Config['TopicsPerPage']
	));
	foreach($ResultArray['MentionArray'] as $Key => $Post)
	{
		$ResultArray['MentionArray'][$Key]['PostFloor'] = -1;
		$ResultArray['MentionArray'][$Key]['FormatPostTime'] = FormatTime($Post['PostTime']);
		$ResultArray['MentionArray'][$Key]['Content'] = strip_tags(mb_substr($Post['Content'], 0, 256, 'utf-8'),'<p><br><a>');
	}
}

if ($Type === false || $Type === 'inbox') {
	$ResultArray['InboxArray'] = $DB->query('
		SELECT * FROM
			(
					(SELECT
						m1.SenderID AS ContactID,
						m1.SenderName AS ContactName,
						m1.Content,
						m1.Time
					FROM ' . PREFIX . 'messages m1
					WHERE
						m1.ReceiverID = :ReceiverID
					AND m1.IsDel = 0)
				UNION
					(SELECT
						m2.ReceiverID AS ContactID,
						m2.ReceiverName AS ContactName,
						m2.Content,
						m2.Time
					FROM ' . PREFIX . 'messages m2
					WHERE
						m2.SenderID = :SenderID
					AND m2.IsDel = 0)
			) t
		GROUP BY
			ContactID
		ORDER BY
			Time DESC
		LIMIT :Offset, :Number', array(
			'ReceiverID' => $CurUserID,
			'SenderID' => $CurUserID,
			'Offset' => ($Page - 1) * $Config['TopicsPerPage'],
			'Number' => intval($Config['TopicsPerPage'])
	));
	foreach($ResultArray['InboxArray'] as $Key => $Message)
	{
		$ResultArray['InboxArray'][$Key]['FormatPostTime'] = FormatTime($Message['Time']);
		$ResultArray['InboxArray'][$Key]['Content'] = strip_tags(mb_substr($Message['Content'], 0, 80, 'utf-8'),'<p><br><a>') . '……';
	}
}
//Clear unread marks
UpdateUserInfo(array(
	'NewNotification' => 0
));
$CurUserInfo['NewNotification'] = 0;
$DB->CloseConnection();
// 页面变量
$PageTitle   = $Lang['Notifications'];
$ContentFile = $TemplatePath . 'notifications.php';
include($TemplatePath . 'layout.php');