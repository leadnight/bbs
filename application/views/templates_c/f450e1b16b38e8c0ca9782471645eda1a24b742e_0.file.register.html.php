<?php
/* Smarty version 3.1.29, created on 2016-08-09 18:48:41
  from "/mnt/hgfs/workspace/html/application/views/templates/register.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a9a6f9cb6503_61918381',
  'file_dependency' => 
  array (
    'f450e1b16b38e8c0ca9782471645eda1a24b742e' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/register.html',
      1 => 1470735781,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a9a6f9cb6503_61918381 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>楽しいユーザー登録</title>
</head>
<body>
<h1>ユーザー登録画面</h1>
<?php  echo validation_errors(); ?>
	<form action="/bbs/register" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>ユーザー名:</th>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<th>パスワード</th>
				<td><input type="password" name="password"></td>
			</tr>
		</table>

		<input id="submit_button" type="submit" value="登録">

	</form>
</body>
</html><?php }
}
