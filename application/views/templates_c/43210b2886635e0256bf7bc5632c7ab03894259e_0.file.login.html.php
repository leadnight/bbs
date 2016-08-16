<?php
/* Smarty version 3.1.29, created on 2016-08-15 18:31:04
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b18bd87636f2_40321568',
  'file_dependency' => 
  array (
    '43210b2886635e0256bf7bc5632c7ab03894259e' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/login.html',
      1 => 1470985655,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b18bd87636f2_40321568 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ログイン</title>
<style>
input#submit_button {
	padding: 10px 5px;
	font-size: 1.2em;
}
</style>
</head>
<body>
	<h1>予約管理ログイン</h1>
	<form action="/yoyaku/login/" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>ユーザー名</th>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<th>パスワード</th>
				<td><input type="password" name="password"></td>
			</tr>
		</table>
		<input type = "hidden" name = "check" value ="1">
		<input type="submit" value="ログイン">
	</form>
	<h2><a href = "/yoyaku/createuser">新規登録</a></h2>
</body>
</html><?php }
}
