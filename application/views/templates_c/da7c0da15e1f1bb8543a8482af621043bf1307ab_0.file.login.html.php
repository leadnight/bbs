<?php
/* Smarty version 3.1.29, created on 2016-08-10 15:55:49
  from "/mnt/hgfs/workspace/html/application/views/templates/login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57aacff5c58136_26331241',
  'file_dependency' => 
  array (
    'da7c0da15e1f1bb8543a8482af621043bf1307ab' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/login.html',
      1 => 1470811971,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57aacff5c58136_26331241 ($_smarty_tpl) {
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
	<h1>ログイン</h1>
	<form action="/bbs/login" method="post" accept-charset="utf-8">
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

		<input id="submit_button" type="submit" value="ログイン">

	</form>
	<h2><a href = "/bbs/register">新規登録</a></h2>
</body>
</html><?php }
}
