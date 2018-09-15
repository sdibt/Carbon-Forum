<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');

if($CurUserID && $UrlPath != 'register'){ ?>
<div class="sider-box">
	<div class="sider-box-title">
		<?php echo $Lang['User_Panel']; ?>
	</div>
	<div class="sider-box-content">
		<div class="user-pannel-avatar">
			<a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo urlencode($CurUserName); ?>">
				<?php echo GetAvatar($CurUserID, $CurUserName, 'large'); ?>
			</a>
		</div>
		<div class="user-pannel">
			<div class="user-pannel-name">
				<a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo urlencode($CurUserName); ?>"><?php echo $CurUserName; ?></a>
			</div>
			<ul>
				<li>
					<a href="<?php echo $Config['WebsitePath']; ?>/favorites">
						<strong><?php echo $CurUserInfo['NumFavTopics']; ?></strong>
						<span><?php echo $Lang['Favorite_Topics']; ?></span>
					</a>
				</li>
				<li>
					<a href="<?php echo $Config['WebsitePath']; ?>/tags/following">
						<strong><?php echo $CurUserInfo['NumFavTags']; ?></strong>
						<span><?php echo $Lang['Tags_Followed']; ?></span>
					</a>
				</li>
				<li>
					<a href="<?php echo $Config['WebsitePath']; ?>/users/following">
						<strong><?php echo $CurUserInfo['NumFavUsers']; ?></strong>
						<span><?php echo $Lang['Users_Followed']; ?></span>
					</a>
				</li>
			</ul>
		</div>
		<div class="c"></div>
	</div>
</div>
<?php
}
if($HotTagsArray) {
?>
<div class="sider-box">
	<div class="sider-box-title">
		<?php echo $Lang['Hot_Tags']; ?>
		<span class="float-right"><a href="<?php echo $Config['WebsitePath']; ?>/tags"><?php echo $Lang['Show_More']; ?></a></span>
	</div>
	<div class="sider-box-content btn">
		<?php foreach ($HotTagsArray as $Tag) {?>
		<a href="<?php echo $Config['WebsitePath']; ?>/tag/<?php echo urlencode($Tag['Name']); ?>"><?php echo $Tag['Name']; ?></a>
		<?php } ?>
	</div>
</div>
<?php
}
if($Config['PageSiderContent']) {
?>
<div class="sider-box">
	<div class="sider-box-title"><?php echo $Lang['Information_Bar']; ?></div>
	<div class="sider-box-content">
		<?php echo $Config['PageSiderContent']; ?>
		<div class="c"></div>
	</div>
</div>
<?php
}
?>
