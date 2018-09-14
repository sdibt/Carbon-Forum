<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
if (empty($Lang) || !is_array($Lang))
	$Lang = array();

$Lang = array_merge($Lang, array(
	'Basic_Settings' => '基本设置',
	'Page_Settings' => '页面设置',
	'Advanced_Settings' => '高级设置',
	'Parameter_Settings' => '参数设置',

	'Forum_Name' => '论坛名称',
	'Forum_Descriptions' => '论坛描述<br /><br />给搜索引擎看的<br />150字符以内',

	'Page_Show' => '每页显示',
	'Page_Topics' => '个主题',

	'Topic_Show' => '每个主题显示',
	'Topic_Posts' => '个回帖',

	'Topic_Max' => '每个主题最多',
	'Topic_Max_Tags' => '个话题',

	'Tag_Max' => '单个话题最多',
	'Tag_Max_Chars' => '个字符',

	'Post_Max' => '每个帖子最多',
	'Post_Max_Chars' => '个字符',

	'Allow_Ordinary_Users_To_Edit_Their_Own_Posts' => '允许普通用户编辑自己的帖子',
	'Allow_Empty_Tags' => '允许不输入标签',
	'Allow_Ordinary_Users_To_Create_New_Topics' => '允许普通用户发布新主题',
	'Close_Registration' => '禁止注册',
	'New_User_Freeze_Time' => '新用户冻结时间',
	'Posting_Interval' => '发帖间隔',

	'Yes' => '是',
	'No' => '否',

	'Save' => '保存设置',

	'Html_Between_Head' => '&lt;Head&gt;标签之间的内容',
	'Html_Before_Body' => '&lt;/Body&gt;标签之前的内容<br />一般放置统计代码',
	'Html_SiderBar' => '侧边栏的内容',

	'jQuery_CDN' => 'jQuery库地址',
	'Main_Domainname' => 'PC端主站域名',
	'Mobile_Domainname' => '手机站域名',
	'API_Domainname' => '客户端API域名',

	'Push_Connection_Timeout_Period' => '推送超时时间<br />(如果你不知道这是什么请不要修改)',

	'Upload_Parameters' => '上传参数',
	'Text_Filter_Parameter' => '文本过滤参数',

	'Callback_URL' => '回调地址',

	'Basic_Settings_Successfully_Saved' => '基本设置修改成功，{{NewConfig}}项已修改',
	'Page_Settings_Successfully_Saved' => '页面设置修改成功，{{NewConfig}}项已修改',
	'Parameter_Settings_Successfully_Saved' => '参数设置修改成功，{{NewConfig}}项已修改',
	'Advanced_Settings_Successfully_Saved' => '高级设置修改成功，{{NewConfig}}项已修改',
	));
