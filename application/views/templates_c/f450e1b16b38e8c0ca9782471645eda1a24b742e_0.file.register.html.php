<?php
/* Smarty version 3.1.29, created on 2016-08-10 13:28:19
  from "/mnt/hgfs/workspace/html/application/views/templates/register.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57aaad635f5253_14513186',
  'file_dependency' => 
  array (
    'f450e1b16b38e8c0ca9782471645eda1a24b742e' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/register.html',
      1 => 1470803291,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57aaad635f5253_14513186 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>楽しいユーザー登録</title>
</head>
<body>
<h1>ユーザー登録画面</h1>
<?php  echo validation_errors();
echo $_smarty_tpl->tpl_vars['myerrormessage']->value["username"];?>

	<form action="/bbs/register" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>ユーザー名</th>
				<td><input type="text" name="username" value="<?php  echo set_value('username'); ?>"></td>
			</tr>
			<tr>
				<th>パスワード</th>
				<td><input type="password" name="password"></td>
			</tr>
		</table>
		<input type="hidden" name = "visited" value="1">
		<input type="submit" value="登録">

	</form>

	<p><a href="/bbs/">トップページへ戻る</a></p>
</body>
</html><?php }
}
