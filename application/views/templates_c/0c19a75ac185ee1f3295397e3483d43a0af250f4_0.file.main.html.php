<?php
/* Smarty version 3.1.29, created on 2016-08-12 14:08:00
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/main.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57ad59b0852113_50013891',
  'file_dependency' => 
  array (
    '0c19a75ac185ee1f3295397e3483d43a0af250f4' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/main.html',
      1 => 1470977304,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57ad59b0852113_50013891 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約管理ページ</title>
</head>
<body>
	<h1>予約管理ページ</h1>
	<p>こんにちは <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
 さん</p>
	<br>
	<br>
	<p>
		<a href="/yoyaku/profile">アカウント設定</a>
	</p>
	<br>
	<br>
	<form action="/yoyaku/logout" method="post" accept-charset="utf-8">
		<input type="submit" value="ログアウト">
	</form>
</body>
</html><?php }
}
